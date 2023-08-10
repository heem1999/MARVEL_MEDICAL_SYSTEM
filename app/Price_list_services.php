<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price_list_services extends Model
{
    protected $guarded = [];

    public function service()
    {
    return $this->belongsTo('App\Services');
    }

    public function price_list()
    {
    return $this->belongsTo('App\Price_lists');
    }

    public function extra_service()
    {
    return $this->belongsTo('App\extra_services','ex_code');
    }
}
