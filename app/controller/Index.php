<?php

namespace app\controller;

use Swift\Http\Request;
use Swift\Http\Response;

/**
 * Class Index
 * @package app\controller
 */
class Index extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('index');
    }

    /**
     * @param Request $request
     * @return Response|string
     */
    public function view(Request $request)
    {
        return view('view', ['name' => 'daophp']);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function json(Request $request)
    {
        return $this->succeed(['msg' => 'ok']);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function file(Request $request)
    {
        $file = $request->file('upload');
        if ($file && $file->isValid()) {
            $file->move(public_path() . '/files/myfile.' . $file->getUploadExtension());
            return $this->succeed(['msg' => 'upload success']);
        }
        return $this->succeed(['msg' => 'file not found']);
    }
}
