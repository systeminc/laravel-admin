<?php

return [

    'disks' => [

        'system' => [
            'driver'     => 'local',
            'root'       => resource_path('views'),
            'visibility' => 'public',
        ],
        'system-images' => [
            'driver'     => 'local',
            'root'       => public_path('images'),
            'visibility' => 'public',
        ],

    ],

];
