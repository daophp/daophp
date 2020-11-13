<?php

namespace Swift\Contracts;

use Workerman\Worker;

/**
 * Interface Bootstrap
 * @package Swift\Contracts
 */
interface Bootstrap
{
    /**
     * onWorkerStart
     *
     * @param $worker Worker
     * @return mixed
     */
    public static function start($worker);
}
