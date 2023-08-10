<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treasury_mac_address extends Model
{
    protected $guarded = [];

    public function treasury_request_mac()
    {
        return $this->belongsTo('App\Treasury_requests');
    }
}
