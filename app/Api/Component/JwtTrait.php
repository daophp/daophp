<?php

namespace App\Api\Component;

use Exception;
use Firebase\JWT\JWT;
use Swift\Support\Carbon;

/**
 * Trait JwtTrait
 * @package App\Api\Component
 */
trait JwtTrait
{
    /**
     * 通过JWT加密用户数据
     * @param null $payload
     * @return string
     */
    public function JwtEncode($payload = null)
    {
        $key = config('jwt.key');

        $payload = $this->getPayload($payload);

        return JWT::encode($payload, $key);
    }

    /**
     * 通过JWT解密用户数据
     * @param $token
     * @param string $item
     * @return mixed
     */
    public function JwtDecode($token, $item = 'body')
    {
        if (is_null($token)) {
            return null;
        }

        $key = config('jwt.key');

        try {
            $data = JWT::decode($token, $key, ['HS256']);

            return collect($data)->get($item);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * 返回用户数据的属性
     * @param null $token
     * @param string $header
     * @return mixed
     */
    public function authorization($token = null, $header = 'Jwt-Token')
    {
        if (is_null($token)) {
            $token = request()->header($header);
        }

        return $this->JwtDecode($token);
    }

    /**
     * 设置JWT数据的有效期
     * @param null $data
     * @return array
     */
    protected function getPayload($data = null)
    {
        $jwt = config('jwt');

        $payload = $jwt['payload'];

        $payload['exp'] = Carbon::now()->addDays($jwt['expires'])->timestamp; // Add Token expires 过期时间

        return array_merge($payload, ['body' => $data]);
    }
}
