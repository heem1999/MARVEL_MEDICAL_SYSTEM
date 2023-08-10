<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service_tests extends Model
{
    protected $guarded = [];

    public function test()
    {
    return $this->belongsTo('App\Tests');
    }
    public function service()
    {
    return $this->belongsTo('App\Services');
    }
}
