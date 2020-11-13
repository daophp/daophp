<?php

namespace Swift\Session;

use Redis;
use RedisCluster;

/**
 * Class RedisClusterSessionHandler
 * @package Swift\Session
 */
class RedisClusterSessionHandler extends RedisSessionHandler
{
    public function __construct($config)
    {
        $this->_maxLifeTime = (int)ini_get('session.gc_maxlifetime');
        $timeout = $config['timeout'] ?? 2;
        $read_timeout = $config['read_timeout'] ?? $timeout;
        $persistent = $config['persistent'] ?? false;
        $auth = $config['auth'] ?? '';
        $args = [null, $config['host'], $timeout, $read_timeout, $persistent];
        if ($auth) {
            $args[] = $auth;
        }
        $this->_redis = new RedisCluster(...$args);
        if (empty($config['prefix'])) {
            $config['prefix'] = 'redis_session_';
        }
        $this->_redis->setOption(Redis::OPT_PREFIX, $config['prefix']);
    }
}
