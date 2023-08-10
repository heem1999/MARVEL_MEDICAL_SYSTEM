<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppBooking extends Model
{
    protected $guarded = [];

     public function AppUser()
    {
        return $this->belongsTo('App\AppUsers', 'appuser_id', 'id');
    }

    public function Offer()
    {
        return $this->belongsTo('App\Offer', 'offer_id', 'id');
    }

    public function LabTechUser()
    {
        return $this->belongsTo('App\lab_tech_users', 'LabTech_id', 'id');
    }

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    /*public function processing_by()
    {
        return $this->belongsTo('App\User', 'processing_by', 'id');
    }*/

    public function canceled_by()
    {
        return $this->belongsTo('App\User', 'canceled_by', 'id');
    }
    

    public function area()
    {
        return $this->belongsTo('App\Areas', 'area_id', 'id');
    }

    public function contract()
    {
    return $this->belongsTo('App\Payer_contracts');
    }

    public function payer()
    {
        return $this->belongsTo('App\Payers');
    }

    public function review()
    {
        return $this->hasOne('App\Review', 'booking_id', 'id');
    }
    
}
