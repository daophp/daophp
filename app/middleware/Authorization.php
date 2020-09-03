<?php

namespace app\middleware;

use Swift\Contracts\Middleware;
use Swift\Http\Request;
use Swift\Http\Response;

/**
 * Class Authorization
 * @package app\middleware
 */
class Authorization implements Middleware
{
    /**
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function process(Request $request, callable $next): Response
    {
        $session = $request->session();

        if ($session->has('auth')) {
            // check auth rule
        }

        return $next($request);
    }
}