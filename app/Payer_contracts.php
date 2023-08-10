<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payer_contracts extends Model
{
    protected $guarded = [];

    public function payer()
    {
    return $this->belongsTo('App\Payers');
    }
    public function classification()
    {
    return $this->belongsTo('App\Contract_classifications');
    }
}
