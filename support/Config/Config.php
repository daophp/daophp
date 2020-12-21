<?php

namespace Swift\Config;

/**
 * Class Config
 * @package Swift\Config
 */
class Config
{
    /**
     * @var array
     */
    protected static $_config = [];

    /**
     * @param $config_path
     * @param array $exclude_file
     */
    public static function load($config_path, $exclude_file = [])
    {
        foreach (glob($config_path . '/*.php') as $file) {
            $basename = basename($file, '.php');
            if (in_array($basename, $exclude_file)) {
                continue;
            }
            $config = include $file;
            static::$_config[$basename] = $config;
        }
    }

    /**
     * @param null $key
     * @param null $default
     * @return array|mixed|null
     */
    public static function get($key = null, $default = null)
    {
        if ($key === null) {
            return static::$_config;
        }
        $key_array = explode('.', $key);
        $value = static::$_config;
        foreach ($key_array as $index) {
            if (!isset($value[$index])) {
                return $default;
            }
            $value = $value[$index];
        }
        return $value;
    }

    /**
     * @param $config_path
     * @param array $exclude_file
     */
    public static function reload($config_path, $exclude_file = [])
    {
        static::$_config = [];
        static::load($config_path, $exclude_file);
    }
}
