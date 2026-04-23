<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_type_id',
        'name',
        'price_offpeak',
        'price_peak',
        'description',
        'photo',
        'is_active',
    ];

    protected $casts = [
        'is_active'     => 'boolean',
        'price_offpeak' => 'float',
        'price_peak'    => 'float',
    ];

    public function fieldType()
    {
        return $this->belongsTo(FieldType::class);
    }

    public function bookingSlots()
    {
        return $this->hasMany(BookingSlot::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Hitung harga per jam berdasarkan aturan bisnis:
     * - Peak Hour  (17:00-22:00) = price_peak
     * - Off-Peak   (08:00-17:00) = price_offpeak
     * - Weekend    (Sabtu-Minggu) = harga × 1.2
     */
    public function getPriceForSlot(int $hour, string $date): float
    {
        // Peak: jam 17-21 (slot 17 = 17:00-18:00, dst)
        $basePrice = ($hour >= 17) ? $this->price_peak : $this->price_offpeak;

        // Weekend +20%
        $dayOfWeek = Carbon::parse($date)->dayOfWeek; // 0=Sun, 6=Sat
        if (in_array($dayOfWeek, [0, 6])) {
            $basePrice *= 1.20;
        }

        return $basePrice;
    }
}
