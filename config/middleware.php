<?php

return [
    '' => [
        //
    ],
    'Api' => [
        \App\Http\Middleware\AccessControl::class,
    ],
    'Console' => [
        \App\Http\Middleware\Authenticate::class,
        \App\Http\Middleware\Authorization::class,
    ],
];