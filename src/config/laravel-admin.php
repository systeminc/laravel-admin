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
        'locations' => true,
        'shop'      => true,
        'settings'  => true,
    ],

];
