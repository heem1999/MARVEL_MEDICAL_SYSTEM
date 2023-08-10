<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test_branch_samples extends Model
{
    protected $guarded = [];

    public function sample_type()
    {
        return $this->belongsTo('App\Sample_types');
    }
    public function sample_condition()
    {
        return $this->belongsTo('App\Sample_conditions');
    }
}
