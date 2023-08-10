<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reg_samples_barcode_servs_test extends Model
{
    protected $guarded = [];

    public function test()
    {
        return $this->belongsTo('App\Tests', 'test_id');
    }

    public function saved_by()
    {
        return $this->belongsTo('App\user', 'saved_by');
    }

    public function verify_by()
    {
        return $this->belongsTo('App\user', 'verify_by');
    }

    public function reviewed_name()
    {
        return $this->belongsTo('App\user', 'reviewed_by');
    }

    public function analyzer()
    {
        return $this->belongsTo('App\Analyzers', 'analyzer_id');
    }

    
}
