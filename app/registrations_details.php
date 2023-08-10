<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class registrations_details extends Model
{
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo('App\registrations', 'patient_id');
    }

    public function payer()
    {
        return $this->belongsTo('App\Payers');
    }

    public function payer_contract()
    {
        return $this->belongsTo('App\Payer_contracts', 'contract_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branches','branch_id');
    }

    public function user()
    {
        return $this->belongsTo('App\user', 'created_by');
    }

    public function referringDoctor()
    {
        return $this->belongsTo('App\ReferringDoctors', 'referringDoctors_id');
    }
}
