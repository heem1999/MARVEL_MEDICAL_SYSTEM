<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class registration_samples_barcodes extends Model
{
    protected $guarded = [];

    public function Processing_unit()
    {
        return $this->belongsTo('App\Processing_units', 'processing_unit_id');
    }
}
