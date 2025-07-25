<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/storage/posters/{filename}', function ($filename) {
    $path = storage_path('app/public/posters/' . urldecode($filename));

    if (!file_exists($path)) {
        abort(404);
    }

    return Response::file($path);
})->where('filename', '.*');
