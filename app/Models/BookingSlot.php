<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSlot extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'booking_id',
        'field_id',
        'slot_date',
        'slot_hour',
        'price',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
