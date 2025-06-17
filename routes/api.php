<?php

use App\Http\Controllers\Dashboard\RaceEngineerController;
use App\Http\Controllers\Dashboard\SetupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request)
{
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'prefix' => 'setups'
], function ()
{
    Route::post('generate', [RaceEngineerController::class, 'generate'])
        ->name('api.setups.generate');

    Route::post('setups', [SetupController::class, 'store'])
        ->name('api.setups.store');
});
