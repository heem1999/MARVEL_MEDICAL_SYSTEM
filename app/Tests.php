<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tests extends Model
{
    protected $guarded = [];

    public function clinical_unit()
   {
   return $this->belongsTo('App\Clinical_units');
   }

   public function sample_type()
   {
   return $this->belongsTo('App\Sample_types');
   }

   public function sample_condition()
   {
   return $this->belongsTo('App\Sample_conditions');
   }

   public function unit()
   {
   return $this->belongsTo('App\Units');
   }
   
  
     
}
