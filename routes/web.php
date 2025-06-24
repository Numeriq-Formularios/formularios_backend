<?php

use Illuminate\Support\Facades\Route;

Route::get('/loca', function () {
    return response()->json(['message' => 'API Laravel funcionando']);
});