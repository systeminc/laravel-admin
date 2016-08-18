<?php

namespace SystemInc\LaravelAdmin\Validations;

class UpdatedOrderValidation
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules(){
        return [
            'invoice_number' => 'numeric',
            'order_status_id' => 'exists:order_statuses,id',
            'shipment_price' => 'numeric',
            'currency' => 'in:EUR,USD',
            'currency_sign' => 'in:€,$',
            'note' => 'string',
            'billing_name' => 'required|string',
            'billing_email' => 'required|email',
            'billing_telephone' => 'required|string',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string',
            'billing_country' => 'required|string',
            'billing_postcode' => 'required|string',
            'billing_contact_person' => 'required|string',
            'shipping_name' => 'string',
            'shipping_email' => 'email',
            'shipping_telephone' => 'string',
            'shipping_address' => 'string',
            'shipping_city' => 'string',
            'shipping_country' => 'string',
            'shipping_postcode' => 'string',
            'shipping_contact_person' => 'string',
            'parity' => 'string',
            'term_of_payment' => 'string',
            'footnote' => 'string',
            'show_shipping_address' => 'boolean',
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