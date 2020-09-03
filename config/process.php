<?php

return [
    // 文件更新检测
    'monitor' => [
        'handler' => app\process\FileMonitor::class,
        'constructor' => [
            // 监控这些目录
            'monitor_dir' => [
                app_path(),
                config_path(),
                base_path() . '/bootstrap',
                base_path() . '/resources'
            ],
            // 监控这些后缀的文件
            'monitor_extenstions' => [
                'php', 'html', 'htm'
            ]
        ]
    ],
    // 其它进程
    /*'websocket'  => [
        'handler'  => app\process\Websocket::class,
        'listen' => 'websocket://0.0.0.0:8888',
        'count'  => 10,
    ],*/
];
