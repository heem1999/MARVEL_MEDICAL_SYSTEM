<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treasuries extends Model
{
    protected $guarded = [];

   
    public function branch()
    {
        return $this->belongsTo('App\Branches');
    }
}
