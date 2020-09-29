<?php

return [
    'type' => 'file', // or redis or redis_cluster

    'handler' => \Swift\Session\FileSessionHandler::class,

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
        'redis_cluster' => [
            'host'    => ['127.0.0.1:7000', '127.0.0.1:7001', '127.0.0.1:7001'],
            'timeout' => 2,
            'auth'    => '',
            'prefix'  => 'redis_session_',
        ]
    ],

    'session_name' => '_session',
    'lifetime' => env('SESSION_LIFETIME', 1440),
    'path' => '/',
    'domain' => env('SESSION_DOMAIN', ''),
    'secure' => env('SESSION_SECURE_COOKIE', false),
    'http_only' => true,
    'same_site' => '',
];
