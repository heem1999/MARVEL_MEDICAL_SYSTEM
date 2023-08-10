<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class result_clutuer_tests extends Model
{
    protected $guarded = [];

    public function organism()
    {
        return $this->belongsTo('App\organisms', 'organism_id');
    }
}
