<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clinic_trans_services extends Model
{
    protected $guarded = [];

    public function service()
    {
        return $this->belongsTo('App\Services', 'service_id');
    }
    
}
