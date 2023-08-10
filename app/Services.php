<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $guarded = [];

    public function clinical_unit()
    {
    return $this->belongsTo('App\Clinical_units','clinical_unit_id');
    }
    
    
}
