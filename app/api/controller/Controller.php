<?php

namespace app\api\controller;

use app\api\component\JsonResponse;
use app\api\component\JwtTrait;

/**
 * Class Controller
 * @package app\api\controller
 */
abstract class Controller
{
    use JsonResponse, JwtTrait;
}
