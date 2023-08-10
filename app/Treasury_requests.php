<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treasury_requests extends Model
{
    protected $guarded = [];

   
    public function treasury()
    {
        return $this->belongsTo('App\Treasuries');
    }
}
