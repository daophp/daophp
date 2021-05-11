<?php

namespace App\Api;

use Swift\Http\Response;

/**
 * Trait JsonResponse
 * @package App\Api
 */
trait JsonResponse
{
    /**
     * @var int
     */
    protected int $errorCode = 0;

    /**
     * @return int
     */
    protected function getErrorCode(): int
    {
        return $this->errorCode;
    }

    /**
     * @param $errorCode
     * @return $this
     */
    protected function setErrorCode($errorCode): JsonResponse
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    /**
     * 返回封装后的API数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param array $header 发送的Header信息
     * @return Response
     */
    protected function succeed($data, array $header = []): Response
    {
        return $this->response([
            'status' => 'success',
            'data' => $data,
        ])->withHeaders($header);
    }

    /**
     * 返回异常数据到客户端
     * @param $message
     * @return Response
     */
    protected function failed($message): Response
    {
        return $this->response([
            'status' => 'failed',
            'errors' => [
                'code' => $this->getErrorCode(),
                'message' => $message,
            ],
        ]);
    }

    /**
     * 返回 Json 数据格式
     * @param $data
     * @param string $client_name
     * @return Response
     */
    protected function response($data, string $client_name = 'X-Client-Id'): Response
    {
        $client_id = request()->header($client_name);

        if (empty($client_id)) {
            $client_id = md5(request()->session()->getId());
        }

        return json($data)->withHeaders([$client_name => $client_id]);
    }
}
