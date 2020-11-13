<?php

namespace Swift\Foundation\Exception;

use Psr\Log\LoggerInterface;
use Swift\Http\Request;
use Swift\Http\Response;
use Throwable;

/**
 * Class ExceptionHandler
 * @package Swift\Foundation\Exception
 */
class ExceptionHandler implements ExceptionHandlerInterface
{
    /**
     * @var LoggerInterface
     */
    protected $_logger = null;

    /**
     * @var bool
     */
    protected $_debug = false;

    /**
     * @var array
     */
    public $dontReport = [

    ];

    /**
     * ExceptionHandler constructor.
     * @param $logger
     * @param $debug
     */
    public function __construct($logger, $debug)
    {
        $this->_logger = $logger;
        $this->_debug = $debug;
    }

    /**
     * @param Throwable $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        if ($this->shouldntReport($exception)) {
            return;
        }

        $this->_logger->error($exception->getMessage(), ['exception' => (string)$exception]);
    }

    /**
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     */
    public function render(Request $request, Throwable $exception): Response
    {
        if (\method_exists($exception, 'render')) {
            return $exception->render();
        }
        $code = $exception->getCode();
        if ($request->expectsJson()) {
            $json = ['code' => $code ? $code : 500, 'msg' => $exception->getMessage()];
            $this->_debug && $json['traces'] = (string)$exception;
            return new Response(200, ['Content-Type' => 'application/json'],
                json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        $error = $this->_debug ? nl2br((string)$exception) : 'Server internal error';
        return new Response(500, [], $error);
    }

    /**
     * @param Throwable $e
     * @return bool
     */
    protected function shouldntReport(Throwable $e)
    {
        foreach ($this->dontReport as $type) {
            if ($e instanceof $type) {
                return true;
            }
        }
        return false;
    }
}