<?php

namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Region;

/**
 * Class RegionController
 * @package App\Api\Controllers
 */
class RegionController extends Controller
{
    public function index()
    {
        $data = Region::limit(100)->get();
        return $this->succeed($data);
    }
}
