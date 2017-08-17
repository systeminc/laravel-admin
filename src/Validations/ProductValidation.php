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
        'slug'        => 'required|unique:products,slug,'.$product_id,
        'length'      => 'nullable|numeric',
        'width'       => 'nullable|numeric',
        'height'      => 'nullable|numeric',
        'weight'      => 'nullable|numeric',
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
