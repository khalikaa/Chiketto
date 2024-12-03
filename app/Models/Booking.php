<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'status', 
        'user_id',
        'event_id'
    ];

    // public function ticket()
    // {
    //     return $this->belongsTo(Ticket::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function bookingDetail()
    {
        return $this->hasMany(BookingDetail::class);
    }
}
