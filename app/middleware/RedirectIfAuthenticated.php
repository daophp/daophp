<?php

namespace app\middleware;

use Swift\Contracts\Middleware;
use Swift\Http\Request;
use Swift\Http\Response;

/**
 * Class RedirectIfAuthenticated
 * @package app\middleware
 */
class RedirectIfAuthenticated implements Middleware
{
    /**
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function process(Request $request, callable $next): Response
    {
        // TODO: Implement process() method.
    }
}
