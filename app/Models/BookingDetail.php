<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    // ini krn nama tabelnya defaultnya booking_details
    // cbmi bde komen i nnti
    protected $table = 'bookingdetails';

    protected $fillable = [
        'booking_id',
        'ticket_id',
        'ticket_code',
        'name',
        'email',
        'gender',
        'price'
    ];

    public function booking() {
        return $this->belongsTo(Booking::class);
    }

    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }
}
