<?php

return [
    'key' => env('JWT_KEY', ''),
    'payload' => [
        'iss' => 'daophp', // jwt签发者
        // 'aud' => '', // 接收jwt的一方
        // 'sub' => '', // jwt所面向的用户
        // 'iat' => '', // jwt的签发时间
        // 'exp' => '', // jwt的过期时间，这个过期时间必须要大于签发时间
        // 'nbf' => '', // 定义在什么时间之前，该jwt都是不可用的 .
        // 'jti' => '', // jwt的唯一身份标识，主要用来作为一次性token,从而回避重放攻击。
    ],
    'expires' => 30
];
