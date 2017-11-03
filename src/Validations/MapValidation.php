<?php

namespace SystemInc\LaravelAdmin\Validations;

class MapValidation
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules($map_id = '')
    {
        return [
        'title'     => 'required',
        'latitude'  => 'required',
        'longitude' => 'required',
        'key'       => 'required|unique:maps,key,'.$map_id,
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
