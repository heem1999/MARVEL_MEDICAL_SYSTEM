<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tests_configurations_numeric extends Model
{
    protected $guarded = [];
    public function test()
    {
        return $this->belongsTo('App\Tests', 'test_id');
    }
}
