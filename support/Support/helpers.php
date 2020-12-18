<?php

use Swift\Config\Config;
use Swift\Foundation\App;
use Swift\Http\Request;
use Swift\Http\Response;
use Swift\Routing\Route;
use Swift\Translation\TranslationProvider;

/**
 * @param string $path
 * @return string
 */
function base_path($path = '')
{
    return BASE_PATH . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}

/**
 * @param string $path
 * @return string
 */
function app_path($path = '')
{
    return base_path('app') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}

/**
 * @param string $path
 * @return string
 */
function config_path($path = '')
{
    return base_path('config') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}

/**
 * @param string $path
 * @return string
 */
function database_path($path = '')
{
    return base_path('database') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}

/**
 * @param string $path
 * @return string
 */
function public_path($path = '')
{
    return base_path('public') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}

/**
 * @param string $path
 * @return string
 */
function resource_path($path = '')
{
    return base_path('resources') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}

/**
 * @param string $path
 * @return string
 */
function runtime_path($path = '')
{
    return base_path('runtime') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}

/**
 * @param int $status
 * @param array $headers
 * @param string $body
 * @return Response
 */
function response($body = '', $status = 200, $headers = array())
{
    return new Response($status, $headers, $body);
}

/**
 * @param $data
 * @param int $options
 * @return Response
 */
function json($data, $options = JSON_UNESCAPED_UNICODE)
{
    return new Response(200, ['Content-Type' => 'application/json'], json_encode($data, $options));
}

/**
 * @param $xml
 * @return Response
 */
function xml($xml)
{
    if ($xml instanceof SimpleXMLElement) {
        $xml = $xml->asXML();
    }
    return new Response(200, ['Content-Type' => 'text/xml'], $xml);
}

/**
 * @param $data
 * @param string $callback_name
 * @return Response
 */
function jsonp($data, $callback_name = 'callback')
{
    if (!is_scalar($data) && null !== $data) {
        $data = json_encode($data);
    }
    return new Response(200, [], "$callback_name($data)");
}

/**
 * @param $location
 * @param int $status
 * @param array $headers
 * @return Response
 */
function redirect($location, $status = 302, $headers = [])
{
    $response = new Response($status, ['Location' => $location]);
    if (!empty($headers)) {
        $response->withHeaders($headers);
    }
    return $response;
}

/**
 * @param $template
 * @param array $vars
 * @param null $app
 * @return string
 */
function view($template, $vars = [], $app = null)
{
    static $handler;
    if (null === $handler) {
        $handler = config('view.handler');
    }
    return new Response(200, [], $handler::render($template, $vars, $app));
}

/**
 * @return Request
 */
function request()
{
    return App::request();
}

/**
 * @param $key
 * @param null $default
 * @return mixed
 */
function config($key = null, $default = null)
{
    return Config::get($key, $default);
}

/**
 * @param $name
 * @param array $parameters
 * @return string
 */
function route($name, $parameters = [])
{
    $route = Route::getByName($name);
    if (!$route) {
        return '';
    }
    return $route->url($parameters);
}

/**
 * @param null $key
 * @param null $default
 * @return mixed
 */
function session($key = null, $default = null)
{
    $session = request()->session();
    if (null === $key) {
        return $session;
    }
    if (is_array($key)) {
        $session->put($key);
        return null;
    }
    return $session->get($key, $default);
}

/**
 * @param null|string $id
 * @param array $parameters
 * @param string|null $domain
 * @param string|null $locale
 * @return string
 */
function trans(string $id, array $parameters = [], string $domain = null, string $locale = null)
{
    return TranslationProvider::trans($id, $parameters, $domain, $locale);
}

/**
 * @param null|string $locale
 * @return string
 */
function locale(string $locale)
{
    if (!$locale) {
        return TranslationProvider::getLocale();
    }
    TranslationProvider::setLocale($locale);
}

/**
 * 字符串命名风格转换
 * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
 * @param string $name 字符串
 * @param int $type 转换类型
 * @param bool $ucfirst 首字母是否大写（驼峰规则）
 * @return string
 */
function parse_name(string $name, int $type = 0, bool $ucfirst = true): string
{
    if ($type) {
        $name = preg_replace_callback('/_([a-zA-Z])/', function ($match) {
            return strtoupper($match[1]);
        }, $name);

        return $ucfirst ? ucfirst($name) : lcfirst($name);
    }

    return strtolower(trim(preg_replace('/[A-Z]/', '_\\0', $name), '_'));
}

/**
 * @param $worker
 * @param $class
 */
function worker_bind($worker, $class)
{
    $callback_map = [
        'onConnect',
        'onMessage',
        'onClose',
        'onError',
        'onBufferFull',
        'onBufferDrain',
        'onWorkerStop',
        'onWebSocketConnect'
    ];
    foreach ($callback_map as $name) {
        if (method_exists($class, $name)) {
            $worker->$name = [$class, $name];
        }
    }
    if (method_exists($class, 'onWorkerStart')) {
        call_user_func([$class, 'onWorkerStart'], $worker);
    }
}

/**
 * @return int
 */
function cpu_count()
{
    if (strtolower(PHP_OS) === 'darwin') {
        $count = shell_exec('sysctl -n machdep.cpu.core_count');
    } else {
        $count = shell_exec('nproc');
    }
    $count = (int)$count > 0 ? (int)$count : 4;
    return $count;
}