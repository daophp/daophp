<?php

namespace Swift\Foundation\Exception;

use Swift\Http\Request;
use Swift\Http\Response;
use Throwable;

/**
 * Interface ExceptionHandlerInterface
 * @package Swift\Foundation\Exception
 */
interface ExceptionHandlerInterface
{
    /**
     * @param Throwable $e
     * @return mixed
     */
    public function report(Throwable $e);

    /**
     * @param Request $request
     * @param Throwable $e
     * @return Response
     */
    public function render(Request $request, Throwable $e): Response;
}