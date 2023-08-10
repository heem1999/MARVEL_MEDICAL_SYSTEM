<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class appPaymentTransactions extends Model
{
    protected $guarded = [];
    
    public function created_by_user()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
