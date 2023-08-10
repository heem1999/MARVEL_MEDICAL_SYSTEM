<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract_branches extends Model
{
    protected $guarded = [];

    public function branch()
    {
    return $this->belongsTo('App\Branches');
    }

    public function cpls()
    {
    return $this->belongsTo('App\Contracts_price_list_settings');
    }
}
