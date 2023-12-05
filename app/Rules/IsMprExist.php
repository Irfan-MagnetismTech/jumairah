<?php

namespace App\Rules;

use App\Procurement\Supplierbillmprdetails;
use App\Procurement\Supplierbillmrrdetails;
use Illuminate\Contracts\Validation\Rule;

class IsMprExist implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($attribute == 'mpr_id'){
        Supplierbillmprdetails::where('mpr_id', $value)->get();
        }else{
            Supplierbillmrrdetails::where('mrr_id', $value)->get();
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The value is already exist.';
    }
}
