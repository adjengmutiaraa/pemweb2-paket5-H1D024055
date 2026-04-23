<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'field_id',
        'booking_date',
        'start_time',
        'end_time',
        'duration_hours',
        'total_price',
        'payment_proof',
        'status',
        'refund_amount',
        'cancelled_at',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'cancelled_at' => 'datetime',
        'total_price'  => 'float',
        'refund_amount'=> 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function slots()
    {
        return $this->hasMany(BookingSlot::class);
    }

    /**
     * Generate unique booking code: SB-XXXXXXXX
     */
    public static function generateCode(): string
    {
        do {
            $code = 'SB-' . strtoupper(Str::random(8));
        } while (self::where('booking_code', $code)->exists());

        return $code;
    }

    /**
     * Helper: badge color per status
     */
    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'menunggu_pembayaran' => 'warning',
            'terkonfirmasi'       => 'success',
            'selesai'             => 'primary',
            'dibatalkan'          => 'danger',
            'refund'              => 'secondary',
            default               => 'light',
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'terkonfirmasi'       => 'Terkonfirmasi',
            'selesai'             => 'Selesai',
            'dibatalkan'          => 'Dibatalkan',
            'refund'              => 'Refund',
            default               => ucfirst($this->status),
        };
    }
}
