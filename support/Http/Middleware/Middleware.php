<?php

namespace Swift\Http\Middleware;

use Swift\Foundation\App;

/**
 * Class Middleware
 * @package Swift\Http\Middleware
 */
class Middleware
{
    /**
     * @var array
     */
    protected static $_instances = [];

    /**
     * @param $all_middlewares
     */
    public static function load($all_middlewares)
    {
        foreach ($all_middlewares as $app_name => $middlewares) {
            foreach ($middlewares as $class_name) {
                if (method_exists($class_name, 'process')) {
                    static::$_instances[$app_name][] = [App::container()->get($class_name), 'process'];
                } else {
                    // @todo Log
                    echo "middleware $class_name::process not exsits\n";
                }
            }
        }
    }

    /**
     * @param $app_name
     * @param bool $with_global_middleware
     * @return array
     */
    public static function getMiddleware($app_name, $with_global_middleware = true)
    {
        $global_middleware = $with_global_middleware && isset(static::$_instances['']) ? static::$_instances[''] : [];
        if ($app_name === '') {
            return array_reverse($global_middleware);
        }
        $app_middleware = static::$_instances[$app_name] ?? [];
        return array_reverse(array_merge($global_middleware, $app_middleware));
    }

    /**
     * @param $app_name
     * @return bool
     */
    public static function hasMiddleware($app_name)
    {
        return isset(static::$_instances[$app_name]);
    }
}
