<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignServiceToProcessingUnit1 extends Model
{
    protected $guarded = [];
    public function processing_unit()
    {
        return $this->belongsTo('App\processing_units');
    }
    public function service()
    {
        return $this->belongsTo('App\Services');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branches');
    }

}
