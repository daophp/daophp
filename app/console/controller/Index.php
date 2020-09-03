<?php

namespace app\console\controller;

use Swift\Http\Request;

/**
 * Class Index
 * @package app\console\controller
 */
class Index extends Controller
{
    public function index(Request $request)
    {
        $session = $request->session();
        $session->set('name', 'daophp');

        return view('index/index');
    }
}
