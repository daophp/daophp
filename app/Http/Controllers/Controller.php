<?php

namespace App\Http\Controllers;

use App\Http\Component\JsonResponse;
use App\Http\Component\JwtTrait;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
abstract class Controller
{
    use JsonResponse, JwtTrait;
}
