<?php

namespace app\controller;

use Swift\Http\Request;

/**
 * Class User
 * @package app\controller
 */
class UserController extends Controller
{
    public function index(Request $request)
    {
        return response('hello user');
    }
}
