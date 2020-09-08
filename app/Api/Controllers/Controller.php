<?php

namespace App\Api\Controllers;

use App\Api\Component\JsonResponse;
use App\Api\Component\JwtTrait;

/**
 * Class Controller
 * @package App\Api\Controllers
 */
abstract class Controller
{
    use JsonResponse, JwtTrait;
}
