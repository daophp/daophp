<?php

namespace Swift\Database;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Jenssegers\Mongodb\Connection;
use Swift\Contracts\Bootstrap;
use Workerman\Worker;

/**
 * Class LaravelProvider
 * @package Swift\Database
 */
class LaravelProvider implements Bootstrap
{
    /**
     * @param Worker $worker
     *
     * @return void
     */
    public static function start($worker)
    {
        if (!class_exists('\Illuminate\Database\Capsule\Manager')) {
            return;
        }
        $capsule = new Capsule;
        $configs = config('database');

        $capsule->getDatabaseManager()->extend('mongodb', function($config, $name) {
            $config['name'] = $name;
            return new Connection($config);
        });

        $default_config = $configs['connections'][$configs['default']];
        $capsule->addConnection($default_config);

        foreach ($configs['connections'] as $name => $config) {
            $capsule->addConnection($config, $name);
        }

        if (class_exists('\Illuminate\Events\Dispatcher')) {
            $capsule->setEventDispatcher(new Dispatcher(new Container));
        }

        $capsule->setAsGlobal();

        $capsule->bootEloquent();
    }
}
