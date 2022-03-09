<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FullNameRule implements Rule
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
        $value = trim($value);
        if (!isset($value[2])) {
            return false;
        }
    
        $containsNotOnlyAlphaAndSpace = preg_match('/[^a-z ]/i', $value);
        if ($containsNotOnlyAlphaAndSpace) {
            return false;
        }

        $nameParts = explode(' ', $value);
        foreach ($nameParts as $name) {
            if (!isset($name[1])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The value enterred is not a valid name.';
    }
}
