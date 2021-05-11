<?php

namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use Swift\Http\Response;

/**
 * Class IndexController
 * @package App\Api\Controllers
 */
class IndexController extends Controller
{
    public function index(): Response
    {
        return $this->succeed(['api server']);
    }
}
