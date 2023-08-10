<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class result_clutuer_org_antis extends Model
{
    
    protected $guarded = [];

    public function antibiotic()
    {
        return $this->belongsTo('App\antibiotics', 'antibiotic_id');
    }
}
