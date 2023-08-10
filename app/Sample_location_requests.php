<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample_location_requests extends Model
{
    protected $guarded = [];

   
    public function user()
    {
        return $this->belongsTo('App\user','user_id');
    }
    
    public function processing_unit()
    {
        return $this->belongsTo('App\Processing_units','processing_units_id');
    }
}
