<?php

namespace App\Api\Component;

use Swift\Http\Response;

/**
 * Trait JsonResponse
 * @package App\Api\Component
 */
trait JsonResponse
{
    /**
     * @var int
     */
    protected $errorCode = 200;

    /**
     * @return int
     */
    protected function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param $errorCode
     * @return $this
     */
    protected function setErrorCode($errorCode)
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
    protected function succeed($data, array $header = [])
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
    protected function failed($message)
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
    protected function response($data, $client_name = 'X-Client-Id')
    {
        $client_id = request()->header($client_name);

        if (empty($client_id)) {
            $client_id = md5(request()->session()->getId());
        }

        return json($data)->withHeaders([$client_name => $client_id]);
    }
}
