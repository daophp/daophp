<?php

namespace app\controller;

use Swift\Http\Request;

/**
 * Class User
 * @package app\controller
 */
class User extends Controller
{
    public function index(Request $request)
    {
        return response('hello user');
    }
}
