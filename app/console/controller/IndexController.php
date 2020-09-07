<?php

namespace app\console\controller;

use Swift\Http\Request;

/**
 * Class IndexController
 * @package app\console\controller
 */
class IndexController extends Controller
{
    public function index(Request $request)
    {
        $session = $request->session();
        $session->set('name', 'daophp');

        return view('index/index');
    }
}
