<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = [];
    
    public function appUser()
    {
        return $this->belongsTo('App\AppUsers', 'user_id', 'id');
    }
    public function appBooking()
    {
        return $this->belongsTo('App\AppBooking', 'booking_id', 'id');
    }
}
