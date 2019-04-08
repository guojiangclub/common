<?php

return [

    'secure' => env('SECURE', false),

    'database' => [
        'prefix' => 'el_'
    ],

    'api_version' => env('API_VERSION', 'v1'),
];
