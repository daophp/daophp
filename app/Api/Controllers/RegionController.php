<?php

namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Region;
use Swift\Http\Response;

/**
 * Class RegionController
 * @package App\Api\Controllers
 */
class RegionController extends Controller
{
    public function index(): Response
    {
        $data = Region::limit(100)->get();
        return $this->succeed($data);
    }
}
