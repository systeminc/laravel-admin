<?php

namespace SystemInc\LaravelAdmin\Validations;

class PageElementValidation
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules()
    {
        return [
        'title'   => 'required',
        'content' => 'required',
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
