<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDetailss extends Model
{
    public function booking() {
        return $this->belongsTo(Booking::class);
    }
}
