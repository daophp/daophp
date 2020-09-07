<?php

namespace app\api\controller;

/**
 * Class IndexController
 * @package app\api\controller
 */
class IndexController extends Controller
{
    public function index()
    {
        return $this->succeed(['api server']);
    }
}
