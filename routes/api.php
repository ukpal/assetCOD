<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\ModulePermissionController;
use App\Http\Controllers\Api\SubscriptionController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('admin')->group(function () {

    Route::prefix('subscription')->group(function () {
        Route::controller(SubscriptionController::class)->group(function () {
            Route::get('/', 'subscriptions')->name('subscription');
        });
    });
});