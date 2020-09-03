<?php

use Swift\Routing\Route;

Route::any('/test', function ($request) {
    return response('test');
});
