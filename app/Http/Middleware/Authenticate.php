<?php

namespace App\Http\Middleware;

use Swift\Contracts\Middleware;
use Swift\Http\Request;
use Swift\Http\Response;

/**
 * Class Authenticate
 * @package App\Http\Middleware
 */
class Authenticate implements Middleware
{
    /**
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function process(Request $request, callable $next): Response
    {
        if (stripos($request->path(), '/console/auth') === false) {
            $session = $request->session();

            if (!$session->has('auth')) {
                return redirect('/console/auth/login');
            }
        }

        return $next($request);
    }
}