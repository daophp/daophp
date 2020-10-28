<?php

return [
    'listen' => 'http://0.0.0.0:8080',
    'transport' => 'tcp',
    'context' => [],
    'name' => 'app',
    'count' => env('SERVER_PROCESS_COUNT', cpu_count() * 2),
    'user' => env('SERVER_PROCESS_USER', ''),
    'group' => env('SERVER_PROCESS_GROUP', ''),
    'pid_file' => runtime_path() . '/app.pid',
    'max_request' => 1000000,
    'stdout_file' => runtime_path() . '/logs/stdout.log',
    'max_package_size' => 10 * 1024 * 1024
];