<?php

namespace SystemInc\LaravelAdmin\Validations;

class UpdatedOrderValidation
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'invoice_number'          => 'numeric',
            'order_status_id'         => 'exists:order_statuses,id',
            'shipment_price'          => 'numeric',
            'currency'                => 'in:EUR,USD',
            'billing_name'            => 'required|string',
            'billing_email'           => 'required|email'
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
