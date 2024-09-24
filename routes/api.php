<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LineupController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PositionCatalogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\VerificationController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

/**
 * Google Login
 */
Route::get('oauth/google', [GoogleController::class, 'handleRedirect']);
Route::get('google-callback', [GoogleController::class, 'handleCallback']);

Route::middleware(['auth:api', 'verified'])->group(function () {
    
    /**
     * User Endpoint
     */
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('/user', [UserController::class, 'update']);
    Route::delete('/user', [UserController::class, 'destroy']);
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

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

    /**
     * Players Endpoint
     */
    Route::controller(PlayerController::class)->group(function () {
        Route::post('/player', 'store');
        Route::get('/player/{player}', 'show');
        Route::put('/player/{player}', 'update');
        Route::delete('/player/{player}', 'destroy');
    });

    /**
     * Lineups Endpoint
     */
    Route::controller(LineupController::class)->group(function () {
        Route::get('/team/{team}/lineup', 'index');
        Route::post('/team/{team}/lineup', 'store');
        Route::get('/lineup/{lineup}', 'show');
    });
});
