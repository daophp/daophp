<?php

use Swift\Routing\Route;

Route::any('/admin', function ($request) {
    return redirect('/console');
});
