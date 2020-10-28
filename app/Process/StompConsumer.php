<?php

namespace App\Process;

use Swift\Container\ContainerProvider;
use Swift\Stomp\StompProvider;
use Workerman\Stomp\Client;

/**
 * Class StompConsumer
 * @package App\Process
 */
class StompConsumer
{
    /**
     * @var string
     */
    protected $_consumerDir = '';

    /**
     * StompConsumer constructor.
     * @param string $consumer_dir
     */
    public function __construct($consumer_dir = '')
    {
        $this->_consumerDir = $consumer_dir;
    }

    /**
     * onWorkerStart.
     */
    public function onWorkerStart()
    {
        $dir_iterator = new \RecursiveDirectoryIterator($this->_consumerDir);
        $iterator = new \RecursiveIteratorIterator($dir_iterator);
        foreach ($iterator as $file) {
            if (is_dir($file)) {
                continue;
            }
            $fileinfo = new \SplFileInfo($file);
            $ext = $fileinfo->getExtension();
            if ($ext === 'php') {
                $class = str_replace('/', "\\", substr(substr($file, strlen(base_path())), 0, -4));
                if (!method_exists($class, 'consume')) {
                    continue;
                }
                $consumer = ContainerProvider::get($class);
                $connection_name = $consumer->connection ?? 'default';
                $queue = $consumer->queue;
                $ack   = $consumer->ack ?? 'auto';
                $connection = StompProvider::connection($connection_name);
                $cb = function ($client, $package, $ack) use ($consumer) {
                    \call_user_func([$consumer, 'consume'], $package['body'], $ack, $client);
                };
                if ($connection->getState() == Client::STATE_ESTABLISHED) {
                    $connection->subscribe($queue, $cb, ['ack' => $ack]);
                } else {
                    $connection->onConnect = function (Client $connection) use ($queue, $ack, $cb) {
                        $connection->subscribe($queue, $cb, ['ack' => $ack]);
                    };
                }
            }
        }
    }
}