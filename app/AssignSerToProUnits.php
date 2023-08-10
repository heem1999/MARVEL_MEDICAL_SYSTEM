<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignSerToProUnits extends Model
{
    protected $guarded = [];
    public function processing_unit()
    {
        return $this->belongsTo('App\Processing_units');
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
