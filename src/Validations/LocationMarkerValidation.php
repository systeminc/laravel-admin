<?php

namespace SystemInc\LaravelAdmin\Validations;

class LocationMarkerValidation
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules($page_id = '')
    {
        return [
        'title'        => 'required',
        'latitude'     => 'required',
        'longitude'    => 'required',
        'key'          => 'required|unique:location_markers,key,'.$page_id,
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
