<?php

return [
    '' => [
        //
    ],
    'api' => [
        \App\Http\Middleware\AccessControl::class,
    ],
    'console' => [
        \App\Http\Middleware\Authenticate::class,
        \App\Http\Middleware\Authorization::class,
    ],
];