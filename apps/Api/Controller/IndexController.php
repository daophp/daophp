<?php

namespace App\Api\Controller;

/**
 * Class IndexController
 * @package App\Api\Controller
 */
class IndexController extends Controller
{
    public function index()
    {
        return $this->succeed(['api server']);
    }
}
