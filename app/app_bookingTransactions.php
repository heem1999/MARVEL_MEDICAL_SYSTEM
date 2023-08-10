<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class app_bookingTransactions extends Model
{
    protected $guarded = [];

    public function AppUser()
   {
       return $this->belongsTo('App\AppUsers', 'appuser_id', 'id');
   }

   public function edit_by_user()
   {
       return $this->belongsTo('App\User', 'edit_by', 'id');
   }
}
