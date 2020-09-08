<?php

namespace App\Http\Controllers;

use Swift\Http\Request;

/**
 * Class User
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    public function index(Request $request)
    {
        return response('hello user');
    }
}
