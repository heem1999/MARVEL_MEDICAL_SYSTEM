<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class lab_tech_users extends Authenticatable
{
    use HasApiTokens;

    protected $guarded = [];
    protected $table = 'lab_tech_users';
    
    protected $appends = ['imageUri'];
    public function getImageUriAttribute()
    {
        if (isset($this->attributes['image'])) {

            return url('upload/usersProfile') . '/' . $this->attributes['image'];
        }
    }

    public function area()
    {
        return $this->belongsTo('App\Areas', 'area_id');
    }

}
