<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contracts_price_list_settings extends Model
{
    protected $guarded = [];

    public function contract()
    {
    return $this->belongsTo('App\Payer_contracts');
    }
    public function price_list()
    {
    return $this->belongsTo('App\Price_lists');
    }
    
}
