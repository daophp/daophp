<?php

use Swift\Session\FileSessionHandler;

return [

    'type' => 'file', // or redis

    'handler' => FileSessionHandler::class,

    'config' => [
        'file' => [
            'save_path' => runtime_path() . '/sessions',
        ],
        'redis' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'port' => env('REDIS_PORT', 6379),
            'auth' => env('REDIS_PASSWORD', null),
            'timeout' => 2,
            'database' => env('REDIS_DB', '0'),
            'prefix' => 'redis_session_',
        ],
    ],

    'session_name' => 'PHPSESSID',
];
