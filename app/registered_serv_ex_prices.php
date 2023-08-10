<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class registered_serv_ex_prices extends Model
{
    protected $guarded = [];

    public function extra_service()
    {
    return $this->belongsTo('App\extra_services','ex_serv_id');
    }

    public function canceled_by()
    {
        return $this->belongsTo('App\user', 'canceled_by');
    }
}
