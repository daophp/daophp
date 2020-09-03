<?php

namespace app\api\controller;

/**
 * Class Index
 * @package app\api\controller
 */
class Index extends Controller
{
    public function index()
    {
        return $this->succeed(['api server']);
    }
}
