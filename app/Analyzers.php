<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analyzers extends Model
{
    protected $guarded = [];

    public function processing_unit()
    {
        return $this->belongsTo('App\Processing_units', 'processing_units_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branches', 'branch_id');
    }

}
