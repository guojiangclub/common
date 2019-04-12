<?php

return [

    'secure' => env('SECURE', false),

    'pay_debug' => env('PAY_DEBUG', false),

    'database' => [
        'prefix' => env('DB_PREFIX', 'ibrand_'),
    ],

    'api_version' => env('API_VERSION', 'v1'),
];
