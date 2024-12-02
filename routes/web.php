<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\OauthController;
use App\Http\Controllers\{DashboardController, WelcomeController};

Route::get('/', WelcomeController::class);

Route::middleware(['guest'])->group(function () {
    Route::get('/auth/redirect/{provider}', [OauthController::class, 'redirect'])->name('oauth.redirect');

    Route::get('/auth/callback/{provider}', [OauthController::class, 'callback'])->name('oauth.callback');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});
