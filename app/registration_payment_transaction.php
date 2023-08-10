<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class registration_payment_transaction extends Model
{
    protected $guarded = [];
    
    public function branch()
    {
        return $this->belongsTo('App\Branches');
    }
    public function Created_by()
    {
        return $this->belongsTo('App\user', 'Created_by');
    }
    
}
