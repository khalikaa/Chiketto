<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    protected $fillable = ['amount', 'booking_id'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
