<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Field;
use Illuminate\Support\Str; // Tambahkan ini supaya Str::random tidak error
use Carbon\Carbon;

class BookingService
{
    public function createBooking(array $data, Field $field)
    {
        // 1. Hitung Total Harga berdasarkan jam yang dipilih
        $totalPrice = 0;
        $isWeekend = Carbon::parse($data['booking_date'])->isWeekend();

        foreach ($data['hours'] as $hour) {
            // Logika harga: Peak jam 17 keatas, sisanya Off-peak
            $basePrice = ($hour >= 17) ? $field->price_peak : $field->price_offpeak;
            
            // Tambahan 20% kalau weekend
            if ($isWeekend) {
                $basePrice *= 1.2;
            }
            
            $totalPrice += $basePrice;
        }

        // 2. Logika DP 50% atau Lunas
        if ($data['payment_type'] === 'dp') {
            $amountPaid = $totalPrice * 0.5;
            $remaining = $totalPrice - $amountPaid;
        } else {
            $amountPaid = $totalPrice;
            $remaining = 0;
        }

        // 3. Simpan ke Database
        $hoursArray = $data['hours']; // array slot jam yang dipilih
        $startHour  = min($hoursArray);
        $endHour    = max($hoursArray) + 1;
        $duration   = count($hoursArray); // Menghitung total jam yang dipesan

        $booking = Booking::create([
            'booking_code'      => 'BOOK-' . strtoupper(Str::random(6)),
            'user_id'           => auth()->id(),
            'field_id'          => $field->id,
            'start_time'        => sprintf('%02d:00', $startHour),
            'end_time'          => sprintf('%02d:00', $endHour),
            'booking_date'      => $data['booking_date'],
            'duration_hours'    => $duration, // TAMBAHKAN INI
            'total_price'       => $totalPrice,
            'payment_type'      => $data['payment_type'],
            'amount_paid'       => $amountPaid,
            'remaining_payment' => $remaining,
            'status'            => 'menunggu_pembayaran',
        ]);

        // 4. Simpan Slot Jam (Contoh jika kamu pakai tabel booking_slots)
        foreach ($data['hours'] as $hour) {
            $isPeak = $hour >= 17;
            $price  = $isPeak ? $field->price_peak : $field->price_offpeak;
            if (Carbon::parse($data['booking_date'])->isWeekend()) {
                $price *= 1.2;
            }

            // PASTIKAN SEMUA FIELD INI MASUK
            $booking->slots()->create([
                'field_id'   => $field->id,
                'slot_date'  => $data['booking_date'], // Kolom yang bikin error tadi
                'slot_hour'  => $hour,
                'price'      => $price,
                'start_time' => sprintf('%02d:00', $hour),
                'end_time'   => sprintf('%02d:00', $hour + 1),
            ]);
        }

        return $booking;
    }

    // Fungsi pembantu lainnya (Contoh)
    public function getBookedSlots($fieldId, $date)
    {
        return \App\Models\BookingSlot::whereHas('booking', function($q) use ($fieldId, $date) {
            $q->where('field_id', $fieldId)
              ->where('booking_date', $date)
              ->whereIn('status', ['menunggu_pembayaran', 'terkonfirmasi', 'selesai']);
        })->pluck('slot_hour')->map(fn($t) => (int)substr($t, 0, 2))->toArray();
    }

    public function cancelBooking(Booking $booking)
    {
        // Hitung waktu pembatalan (misal: kebijakan refund 12-24 jam)
        $now = now();
        $bookingDate = Carbon::parse($booking->booking_date . ' ' . $booking->slots->first()->start_time);
        $diffInHours = $now->diffInHours($bookingDate, false);

        $refundAmount = 0;
        if ($diffInHours >= 24) {
            $refundAmount = $booking->amount_paid; // Refund 100%
        } elseif ($diffInHours >= 12) {
            $refundAmount = $booking->amount_paid * 0.5; // Refund 50%
        }

        $booking->update([
            'status' => 'dibatalkan',
            'refund_amount' => $refundAmount
        ]);

        return $booking;
    }
}