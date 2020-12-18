<?php

namespace Swift\Foundation\Console;

use Dotenv\Dotenv;
use ErrorException;
use Swift\Config\Config;
use Swift\Container\ContainerProvider;
use Swift\Foundation\App;
use Swift\Http\Middleware\Middleware;
use Swift\Http\Request;
use Swift\Log\LogProvider;
use Swift\Routing\Route;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http;
use Workerman\Worker;

/**
 * Class ServeCommand
 * @package Swift\Foundation\Console
 */
class ServeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected static $defaultName = 'serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected function configure()
    {
        $this->setDescription('Serve the application')
            ->addArgument('action', InputArgument::OPTIONAL, 'php artisan serve {start|reload|stop}', 'start')
            ->addOption('daemon', 'd', null, 'Start in DAEMON mode');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        global $argv;
        $argv[1] = $input->getArgument('action');
        $argv[2] = $input->getOption('daemon') ? '-d' : '';

        if (method_exists('Dotenv\Dotenv', 'createUnsafeImmutable')) {
            Dotenv::createUnsafeImmutable(base_path())->load();
        } else {
            Dotenv::createMutable(base_path())->load();
        }

        Config::load(config_path());
        $config = config('server');

        if ($timezone = config('app.default_timezone')) {
            date_default_timezone_set($timezone);
        }

        Worker::$onMasterReload = function () {
            if (function_exists('opcache_get_status')) {
                if (isset($status['scripts']) && $scripts = $status['scripts']) {
                    foreach (array_keys($status['scripts']) as $file) {
                        opcache_invalidate($file, true);
                    }
                }
            }
        };

        Worker::$pidFile = $config['pid_file'];
        Worker::$stdoutFile = $config['stdout_file'];
        TcpConnection::$defaultMaxPackageSize = $config['max_package_size'] ?? 10 * 1024 * 1024;

        $worker = new Worker($config['listen'], $config['context']);
        $property_map = [
            'name',
            'count',
            'user',
            'group',
            'reusePort',
            'transport',
        ];
        foreach ($property_map as $property) {
            if (isset($config[$property])) {
                $worker->$property = $config[$property];
            }
        }

        $worker->onWorkerStart = function ($worker) {
            set_error_handler(function ($level, $message, $file = '', $line = 0) {
                if (error_reporting() & $level) {
                    throw new ErrorException($message, 0, $level, $file, $line);
                }
            });
            register_shutdown_function(function ($start_time) {
                if (time() - $start_time <= 1) {
                    sleep(1);
                }
            }, time());
            foreach (config('autoload.files', []) as $file) {
                include_once $file;
            }
            if (method_exists('Dotenv\Dotenv', 'createUnsafeImmutable')) {
                Dotenv::createUnsafeImmutable(base_path())->load();
            } else {
                Dotenv::createMutable(base_path())->load();
            }
            Config::reload(config_path());
            foreach (config('bootstrap', []) as $class_name) {
                /** @var \Swift\Contracts\Bootstrap $class_name */
                $class_name::start($worker);
            }
            $app = new App($worker, ContainerProvider::instance(), LogProvider::channel('default'), app_path(), public_path());
            Route::load(base_path() . '/routes/route.php');
            Middleware::load(config('middleware', []));
            Middleware::load(['__static__' => config('static.middleware', [])]);
            Http::requestClass(Request::class);

            $worker->onMessage = [$app, 'onMessage'];
        };

        foreach (config('process', []) as $process_name => $config) {
            $worker = new Worker($config['listen'] ?? null, $config['context'] ?? []);
            $property_map = [
                'count',
                'user',
                'group',
                'reloadable',
                'reusePort',
                'transport',
                'protocol',
            ];
            $worker->name = $process_name;
            foreach ($property_map as $property) {
                if (isset($config[$property])) {
                    $worker->$property = $config[$property];
                }
            }

            $worker->onWorkerStart = function ($worker) use ($config) {
                foreach (config('autoload.files', []) as $file) {
                    include_once $file;
                }
                Dotenv::createMutable(base_path())->load();
                Config::reload(config_path());

                $bootstrap = $config['bootstrap'] ?? config('bootstrap', []);
                if (!in_array(LogProvider::class, $bootstrap)) {
                    $bootstrap[] = LogProvider::class;
                }
                foreach ($bootstrap as $class_name) {
                    /** @var \Swift\Contracts\Bootstrap $class_name */
                    $class_name::start($worker);
                }

                foreach ($config['services'] ?? [] as $server) {
                    if (!class_exists($server['handler'])) {
                        echo "process error: class {$config['handler']} not exists\r\n";
                        continue;
                    }
                    $listen = new Worker($server['listen'] ?? null, $server['context'] ?? []);
                    if (isset($server['listen'])) {
                        echo "listen: {$server['listen']}\n";
                    }
                    $class = ContainerProvider::make($server['handler'], $server['constructor'] ?? []);
                    worker_bind($listen, $class);
                    $listen->listen();
                }

                if (isset($config['handler'])) {
                    if (!class_exists($config['handler'])) {
                        echo "process error: class {$config['handler']} not exists\r\n";
                        return;
                    }

                    $class = ContainerProvider::make($config['handler'], $config['constructor'] ?? []);
                    worker_bind($worker, $class);
                }

            };
        }

        Worker::runAll();
    }
}