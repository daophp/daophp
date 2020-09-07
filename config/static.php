<?php

return [
    'enable' => true, // 是否支持静态文件
    'middleware' => [     // 静态文件中间件
        \App\Http\Middleware\StaticFile::class,
    ],
];