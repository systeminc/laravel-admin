<?php

namespace SystemInc\LaravelAdmin\Validations;

class AdminValidationWithoutPassword
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules($admin_id = '')
    {
        return [
            'name'     => 'required',
            'email'    => 'required|email|unique:pages,email,'.$admin_id,
        ];
    }

    /**
     * Get the specific message for rules that apply to the request.
     *
     * @return array of message
     */
    public static function messages()
    {
        return [
            //
        ];
    }
}
