<?php

use App\Http\Controllers\Dashboard\CommunityController;
use App\Http\Controllers\Dashboard\RaceEngineerController;
use App\Http\Controllers\Dashboard\SetupController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function ()
{
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';

Route::group([
    'prefix' => 'dashboard',
    'middlware' => ['auth', 'verified'],
    'as' => 'dashboard.'
], function ()
{
    Route::get('race-engineer', [RaceEngineerController::class, 'index'])->name('race-engineer');
    Route::get('setups', [SetupController::class, 'index'])->name('setups.index');
    Route::get('setups/create', [SetupController::class, 'create'])->name('setups.create');
    Route::get('setups/{setup}', [SetupController::class, 'view'])->name('setups.view');
    Route::get('community', [CommunityController::class, 'index'])->name('community');
});
