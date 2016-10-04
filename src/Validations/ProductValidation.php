<?php

namespace SystemInc\LaravelAdmin\Validations;

class ProductValidation
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules($product_id = '')
    {
        return [
        'title'       => 'required',
        'uri_id'      => 'required|unique:products,uri_id,'.$product_id,
        'description' => 'required',
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
