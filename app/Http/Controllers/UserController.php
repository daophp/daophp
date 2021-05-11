<?php

namespace App\Http\Controllers;

use Swift\Http\Request;
use Swift\Http\Response;

/**
 * Class Index
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('user');
    }
}
