<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Administration URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by Laravel Admin panel
    |
    */

    'route_prefix' => 'administration',

    /*
    |--------------------------------------------------------------------------
    | Google map api key
    |--------------------------------------------------------------------------
    |
    | Set your own Google map api key
    |
    */

    'google_map_api' => '',

    /*
    |--------------------------------------------------------------------------
    | Display modules
    |--------------------------------------------------------------------------
    |
    | Set modules you want to show
    |
    */

    'modules' => [
        'blog'      => true,
        'galleries' => true,
        'pages'     => true,
        'leads'     => true,
        'places'    => true,
        'shop'      => true,
        'settings'  => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Invoice
    |--------------------------------------------------------------------------
    |
    | Set you billing info for invoice.pdf
    |
    */

    'invoice' => [
        'location'       => '',
        'address'        => '',
        'skype'          => '',
        'website'        => '',
        'email'          => '',
        'company_prefix' => '',
        'company_name'   => '',
        'company_number' => '',
        'tax_id'         => '',
        'vat'            => '',
        'disclaimer'     => '',
        'beneficiary'    => '',
        'IBAN'           => '',
        'swift'          => '',
        'bank'           => '',
        'account_no'     => '',
        'small_note'     => '',
        'signee'         => '',
    ],
];
