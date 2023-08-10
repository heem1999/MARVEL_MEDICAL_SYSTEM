<?php

namespace App\Rules;

use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;

class CurrentPasswordCheckRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value, auth()->user()->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return (['err'=>'The current password does not match your password.','err_ar'=>'كلمة المرور الحالية لا تتطابق مع كلمة المرور الخاصة بك.']);

        //return __('The current password field does not match your password');
    }
}
