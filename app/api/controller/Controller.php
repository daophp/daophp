<?php

namespace app\api\controller;

use app\api\component\JsonTrait;
use app\api\component\JwtTrait;

/**
 * Class Controller
 * @package app\api\controller
 */
abstract class Controller
{
    use JsonTrait, JwtTrait;
}
