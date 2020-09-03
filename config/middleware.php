<?php

return [
    '' => [
        //
    ],
    'api' => [
        \app\middleware\AccessControl::class,
    ],
    'console' => [
        \app\middleware\Authenticate::class,
        \app\middleware\Authorization::class,
    ],
];