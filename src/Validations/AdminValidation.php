<?php

namespace SystemInc\LaravelAdmin\Validations;

class AdminValidation
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
            'email'    => 'required|email|unique:admins,email,'.$admin_id,
            'password' => 'required',
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
