<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class registered_serv_prices extends Model
{
    protected $guarded = [];

    public function service()
    {
    return $this->belongsTo('App\Services');
    }

    public function canceled_by()
    {
        return $this->belongsTo('App\user', 'canceled_by');
    }
    
}
