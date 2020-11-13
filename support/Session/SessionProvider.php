<?php

namespace Swift\Session;

use Swift\Contracts\Bootstrap;
use Workerman\Protocols\Http;
use Workerman\Protocols\Http\Session as SessionBase;
use Workerman\Worker;

/**
 * Class SessionProvider
 * @package Swift\Session
 */
class SessionProvider implements Bootstrap
{
    /**
     * @param Worker $worker
     * @return void
     */
    public static function start($worker)
    {
        $config = config('session');
        Http::sessionName($config['session_name']);
        SessionBase::handlerClass($config['handler'], $config['config'][$config['type']]);
        session_set_cookie_params(0, $config['path'], $config['domain'], $config['secure'], $config['http_only']);
    }
}
