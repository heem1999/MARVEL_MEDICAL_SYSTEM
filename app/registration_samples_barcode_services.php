<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class registration_samples_barcode_services extends Model
{
    protected $guarded = [];

    public function samples_barcode()
    {
        return $this->belongsTo('App\registration_samples_barcodes','samples_barcode_id');
    }
    
    public function service()
    {
        return $this->belongsTo('App\Services', 'service_id');
    }
    
    public function updated_by()
    {
        return $this->belongsTo('App\user', 'updated_by');
    }
}
