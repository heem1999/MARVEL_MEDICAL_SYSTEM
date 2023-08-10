<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payers extends Model
{
    protected $guarded = [];

    public function currency()
    {
    return $this->belongsTo('App\Currencies');
    }
}
