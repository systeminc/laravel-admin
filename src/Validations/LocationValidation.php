<?php

namespace SystemInc\LaravelAdmin\Validations;

class LocationValidation
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules($location_id = '')
    {
        return [
        'title'     => 'required',
        'latitude'  => 'required',
        'longitude' => 'required',
        'url'       => 'required',
        'key'       => 'required|unique:locations,key,'.$location_id,
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
