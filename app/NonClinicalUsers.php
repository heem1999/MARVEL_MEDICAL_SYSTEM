<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonClinicalUsers extends Model
{
    protected $guarded = [];
    
    public function non_clinical_user()
    {
    return $this->belongsTo('App\NonClinicalUsers');
    }

}
