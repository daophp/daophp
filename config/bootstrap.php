<?php

return [
    \Swift\Container\ContainerProvider::class,
    \Swift\Session\SessionProvider::class,
    \Swift\Database\LaravelProvider::class,
    \Swift\Redis\RedisProvider::class,
    \Swift\Log\LogProvider::class,
    \Swift\Translation\TranslationProvider::class,
    \Swift\Stomp\StompProvider::class,
];
