<?php

namespace app\middleware;

use Swift\Contracts\Middleware;
use Swift\Http\Request;
use Swift\Http\Response;

/**
 * Class AccessControl
 * @package app\middleware
 */
class AccessControl implements Middleware
{
    /**
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function process(Request $request, callable $next): Response
    {
        // 允许uri以 /api 开头的地址跨域访问
        if (stripos($request->path(), '/api') === 0) {
            // 如果是options请求，不处理业务
            if ($request->method() == 'OPTIONS') {
                $response = response('');
            } else {
                $response = $next($request);
            }

            $response->withHeaders([
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'GET,POST,PUT,DELETE,OPTIONS',
                'Access-Control-Allow-Headers' => 'Content-Type,Authorization,X-Requested-With,Accept,Origin',
            ]);
        } else {
            $response = $next($request);
        }

        return $response;
    }
}
