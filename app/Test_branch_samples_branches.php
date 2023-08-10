<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test_branch_samples_branches extends Model
{
    protected $guarded = [];

   
    public function branch()
    {
        return $this->belongsTo('App\Branches');
    }

    public function test_branch_sample()
    {
        return $this->belongsTo('App\Test_branch_samples');
    }
}
