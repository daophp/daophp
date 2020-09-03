<?php

use Swift\Database\Laravel;
use Swift\Foundation\Container;
use Swift\Log\Log;
use Swift\Redis\Redis;
use Swift\Session\Session;
use Swift\Translation\Translation;

return [
    Container::class,
    Session::class,
    Laravel::class,
    Redis::class,
    Log::class,
    Translation::class,
];
