<?php

namespace App\Console\Controllers;

use Swift\Http\Request;
use Swift\Http\Response;

/**
 * Class AuthController
 * @package App\Console\Controllers
 */
class AuthController
{
    /**
     * @param Request $request
     * @return Response|string
     */
    public function login(Request $request)
    {
        if ($request->method() === 'POST') {
            // save auth
            $request->session()->set('auth', [
                'user_id' => 1
            ]);

            return redirect('/console');
        }

        return view('auth/login');
    }

    /**
     * @param Request $request
     * @return Response|string
     */
    public function forgot(Request $request)
    {
        if ($request->isAjax()) {
            // do action
        }

        return view('auth/forgot');
    }

    /**
     * @param Request $request
     * @return Response|string
     */
    public function reset(Request $request)
    {
        if ($request->isAjax()) {
            // do action
        }

        return view('auth/reset');
    }
}
