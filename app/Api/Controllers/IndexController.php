<?php

namespace App\Api\Controllers;

use App\Http\Controllers\Controller;

/**
 * Class IndexController
 * @package App\Api\Controllers
 */
class IndexController extends Controller
{
    public function index()
    {
        return $this->succeed(['api server']);
    }
}
