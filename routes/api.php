<?php

use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::apiResource('/image', ImageController::class)
            ->only(['index', 'store', 'destroy']);
    });
