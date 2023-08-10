<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppBookingSerPrices extends Model
{
    protected $guarded = [];

    public function service()
    {
        return $this->belongsTo('App\Services', 'service_id', 'id');
    }
    public function appBooking()
    {
        return $this->belongsTo('App\AppBooking', 'booking_id', 'id');
    }
}
