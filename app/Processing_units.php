<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Processing_units extends Model
{
    protected $guarded = [];
    public function branch()
   {
   return $this->belongsTo('App\Branches');
   }
}
