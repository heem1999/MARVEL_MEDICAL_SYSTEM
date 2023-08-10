<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class appBranches extends Model
{
    protected $guarded = [];
    
    public function region()
   {
   return $this->belongsTo('App\regions');
   }
}
