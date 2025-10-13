<?php

use App\Http\Controllers\Admin\HomeSettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/home-settings', [HomeSettingsController::class, 'getHomeSettings']);
