<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class service_nested_services extends Model
{
    protected $guarded = [];
    public function nested_service()
    {
    return $this->belongsTo('App\Services','nested_service_id');
    }
}
