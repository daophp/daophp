<?php

namespace App\Process;

use Workerman\Timer;
use Workerman\Worker;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * Class FileMonitor
 * @package App\Process
 */
class FileMonitor
{
    /**
     * @var array
     */
    protected array $_paths = [];

    /**
     * @var array
     */
    protected array $_extensions = [];

    /**
     * FileMonitor constructor.
     * @param $monitor_dir
     * @param $monitor_extensions
     */
    public function __construct($monitor_dir, $monitor_extensions)
    {
        if (Worker::$daemonize) {
            return;
        }
        $this->_paths = (array)$monitor_dir;
        $this->_extensions = $monitor_extensions;
        Timer::add(1, function () {
            foreach ($this->_paths as $path) {
                $this->check_files_change($path);
            }
        });
    }

    /**
     * @param $monitor_dir
     */
    public function check_files_change($monitor_dir)
    {
        static $last_mtime;
        if (!$last_mtime) {
            $last_mtime = time();
        }

        clearstatcache();

        if (!is_dir($monitor_dir)) {
            if (!is_file($monitor_dir)) {
                return;
            }
            $iterator = [new SplFileInfo($monitor_dir)];
        } else {
            // recursive traversal directory
            $dir_iterator = new RecursiveDirectoryIterator($monitor_dir);
            $iterator = new RecursiveIteratorIterator($dir_iterator);
        }

        foreach ($iterator as $file) {
            /** var SplFileInfo $file */
            if (is_dir($file)) {
                continue;
            }
            // check mtime
            if ($last_mtime < $file->getMTime() && in_array($file->getExtension(), $this->_extensions)) {
                $var = 0;
                exec(PHP_BINDIR . "/php -l " . $file, $out, $var);
                if ($var) {
                    $last_mtime = $file->getMTime();
                    continue;
                }
                echo $file . " update and reload\n";
                // send SIGUSR1 signal to master process for reload
                posix_kill(posix_getppid(), SIGUSR1);
                $last_mtime = $file->getMTime();
                break;
            }
        }
    }
}