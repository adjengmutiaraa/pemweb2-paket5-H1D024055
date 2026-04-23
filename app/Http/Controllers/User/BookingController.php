<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Field;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function __construct(private BookingService $bookingService) {}

    public function index(Request $request)
    {
        $query = auth()->user()->bookings()->with('field.fieldType');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10)->withQueryString();

        return view('user.bookings.index', compact('bookings'));
    }

    public function create(Field $field, Request $request)
    {
        abort_if(!$field->is_active, 404);

        $date        = $request->date ?? now()->format('Y-m-d');
        $bookedSlots = $this->bookingService->getBookedSlots($field->id, $date);

        return view('user.bookings.create', compact('field', 'date', 'bookedSlots'));
    }

    public function store(Request $request, Field $field)
    {
        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'hours'        => 'required|array|min:1|max:14',
            'hours.*'      => 'integer|min:8|max:21',
            'payment_type' => 'required|in:full,dp', // Tambahkan validasi ini
        ]);

        $hours = array_map('intval', $request->hours);

        

        try {
            $booking = $this->bookingService->createBooking([
                'user_id'      => auth()->id(),
                'booking_date' => $request->booking_date,
                'hours'        => $hours,
                'payment_type' => $request->payment_type, // Kirim tipe pembayaran ke service
            ], $field);

            return redirect()->route('user.bookings.show', $booking)
                ->with('success', 'Booking berhasil dibuat! Silakan bayar sesuai nominal.');

        } catch (\Exception $e) {
            return back()->withErrors(['hours' => $e->getMessage()])->withInput();
        }
    }
    public function areSlotsContiguous(array $hours): bool
    {
        sort($hours);
        for ($i = 1; $i < count($hours); $i++) {
            if ($hours[$i] - $hours[$i-1] !== 1) return false;
        }
        return true;
    }
    public function show(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        $booking->load('field.fieldType', 'slots');
        return view('user.bookings.show', compact('booking'));
    }

    public function uploadPayment(Request $request, Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        abort_if($booking->status !== 'menunggu_pembayaran', 422);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('payments', 'public');

        $booking->update(['payment_proof' => $path]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload! Menunggu konfirmasi admin.');
    }

    public function cancel(Request $request, Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);

        if (!in_array($booking->status, ['menunggu_pembayaran', 'terkonfirmasi'])) {
            return back()->with('error', 'Booking ini tidak dapat dibatalkan.');
        }

        try {
            $booking = $this->bookingService->cancelBooking($booking);

            $msg = 'Booking berhasil dibatalkan.';
            if ($booking->refund_amount > 0) {
                $msg .= ' Refund sebesar Rp ' . number_format($booking->refund_amount, 0, ',', '.') . ' akan diproses.';
            } else {
                $msg .= ' Tidak ada refund karena pembatalan kurang dari 12 jam.';
            }

            return back()->with('success', $msg);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
