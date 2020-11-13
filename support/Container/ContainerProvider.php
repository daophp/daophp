<?php

namespace Swift\Container;

use Psr\Container\ContainerInterface;
use Swift\Contracts\Bootstrap;
use Workerman\Worker;

/**
 * Class ContainerProvider
 * @package Swift\Container
 * @method static mixed get($name)
 * @method static mixed make($name, array $parameters)
 * @method static bool has($name)
 */
class ContainerProvider implements Bootstrap
{
    /**
     * @var ContainerInterface
     */
    protected static $_instance = null;

    /**
     * @param Worker $worker
     * @return void
     */
    public static function start($worker)
    {
        static::$_instance = include base_path() . '/bootstrap/app.php';
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return static::$_instance->{$name}(... $arguments);
    }

    /**
     * @return ContainerInterface|null
     */
    public static function instance()
    {
        return static::$_instance;
    }
}