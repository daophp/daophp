<?php

namespace App\Http\Controller;

use Swift\Http\Request;

/**
 * Class User
 * @package App\Http\Controller
 */
class UserController extends Controller
{
    public function index(Request $request)
    {
        return response('hello user');
    }
}
