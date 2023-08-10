<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample_conditions extends Model
{
    protected $guarded = [];
    public function Sample_type()
   {
   return $this->belongsTo('App\Sample_types');
   }
}
