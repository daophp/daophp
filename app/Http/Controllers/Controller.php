<?php

namespace App\Http\Controllers;

use App\Api\JsonResponse;
use App\Api\JwtTrait;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
abstract class Controller
{
    use JsonResponse, JwtTrait;
}
