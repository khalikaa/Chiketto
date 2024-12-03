<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'quota',
        'event_id'
    ];

    public function event()
    {
        // 1 tiket belongs to 1 event
        return $this->belongsTo(Event::class);
    }

    public function bookingDetail()
    {
        // 1 tiket has many booking details
        return $this->hasMany(BookingDetail::class);
    }
}
