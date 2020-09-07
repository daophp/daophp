<?php

namespace App\Console\Controller;

use Swift\Http\Request;

/**
 * Class IndexController
 * @package App\Console\Controller
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
