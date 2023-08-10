<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class registrations extends Model
{
    protected $guarded = [];

    public function created_by_user()
    {
        return $this->belongsTo('App\user', 'Created_by');
    }

    public function Edited_by()
    {
        return $this->belongsTo('App\user', 'Edited_by');
    }
    
}
