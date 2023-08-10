<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample_location_mac_address extends Model
{
    protected $guarded = [];

   
    public function sample_location_request()
    {
        return $this->belongsTo('App\Sample_location_requests','sampleLocReq_id');
    }
}
