<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'date_time',
        'location',
        'image_path',
        'user_id',
        'organizer_name',
        'category_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);    
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    // tdk ambilji dr model favorit krn dia pivot table
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    // public function favoritedBy()
    // {
    //     return $this->belongsToMany(User::class, 'favorites', 'event_id', 'user_id');
    // }
}

