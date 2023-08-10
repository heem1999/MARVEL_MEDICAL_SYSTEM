<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample_traking_transactions extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\user','Created_by');
    }

    public function sample()
    {
        return $this->belongsTo('App\registration_samples_barcodes','rsb_id');
    }

    public function location()
    {
        return $this->belongsTo('App\Processing_units','location_id');
    }
    
    public function analyzer()
    {
        return $this->belongsTo('App\Analyzers', 'analyzer_id');
    }
}
