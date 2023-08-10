<?php
/*
namespace App;

use Illuminate\Database\Eloquent\Model;

class AppUsers extends Model
{
    protected $guarded = [];
}

*/

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class AppUsers extends Authenticatable
{

    use HasApiTokens;

   // protected $fillable = ['name', 'email', 'phone_no', 'OTP', 'address', 'status', 'image', 'device_token', 'noti', 'verified','sex'];
    protected $guarded = [];
    protected $table = 'app_users';
   
    protected $appends = ['imageUri'];
    public function getImageUriAttribute()
    {
        if (isset($this->attributes['image'])) {

            return url('upload/usersProfile') . '/' . $this->attributes['image'];
        }
    }
   
}
