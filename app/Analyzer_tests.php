<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analyzer_tests extends Model
{
    protected $guarded = [];

    public function test()
    {
        return $this->belongsTo('App\tests', 'test_id');
    }

    public function analyzer()
    {
        return $this->belongsTo('App\analyzers', 'analyzer_id');
    }
}
