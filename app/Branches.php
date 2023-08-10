<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
    protected $guarded = [];
    public function region()
   {
   return $this->belongsTo('App\regions');
   }

}
