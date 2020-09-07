<?php

namespace App\Exception;

use Swift\Foundation\Exception\ExceptionHandler;
use Swift\Http\Request;
use Swift\Http\Response;
use Throwable;

/**
 * Class Handler
 * @package App\Exception
 */
class Handler extends ExceptionHandler
{
    /**
     * @var string[]
     */
    public $dontReport = [
        BusinessException::class,
    ];

    /**
     * @param Throwable $exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     */
    public function render(Request $request, Throwable $exception): Response
    {
        return parent::render($request, $exception);
    }
}