<?php

namespace App\Api\Controller;

use App\Api\Component\JsonResponse;
use App\Api\Component\JwtTrait;

/**
 * Class Controller
 * @package App\Api\Controller
 */
abstract class Controller
{
    use JsonResponse, JwtTrait;
}
