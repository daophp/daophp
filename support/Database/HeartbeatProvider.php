<?php

namespace Swift\Database;

use Swift\Contracts\Bootstrap;
use Workerman\Timer;
use Workerman\Worker;

/**
 * mysql心跳。定时发送一个查询，防止mysql连接长时间不活跃被mysql服务端断开。
 * 默认不开启，如需开启请到 config/bootstrap.php中添加 Swift\Database\HeartbeatProvider::class,
 * Class HeartbeatProvider
 * @package Swift\Database
 */
class HeartbeatProvider implements Bootstrap
{
    /**
     * @param Worker $worker
     *
     * @return void
     */
    public static function start($worker)
    {
        Timer::add(55, function () {
            DB::select('select 1 limit 1');
        });
    }
}
