<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PositionCatalogController;
use App\Http\Controllers\TeamController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth:api'])->group(function () {

    /**
     * Logout Endpoint
     */
    Route::post('logout', [AuthController::class, 'logout']);

    /**
     * Teams Endpoint
     */
    Route::controller(TeamController::class)->group(function () {
        Route::get('/teams', 'index');
        Route::post('/team', 'store');
        Route::get('/team/{team}', 'show');
        Route::put('/team/{team}', 'update');
        Route::delete('/team/{team}', 'destroy');
    });

    /**
     * Positions Endpoint
     */
    Route::controller(PositionCatalogController::class)->group(function () {
        Route::get('/positions', 'index');
    });
});
