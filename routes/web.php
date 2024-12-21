<?php

declare(strict_types=1);

use App\Http\Controllers\CartonBoxController;
use App\Http\Controllers\CartonBoxValidationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\User\OauthController;
use App\Http\Controllers\SubscriptionController;

Route::get('/', [WelcomeController::class, 'home'])->name('home');

Route::get('/auth/redirect/{provider}', [OauthController::class, 'redirect'])->name('oauth.redirect');

Route::get('/auth/callback/{provider}', [OauthController::class, 'callback'])->name('oauth.callback');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/carton-boxes/search', [CartonBoxController::class, 'search'])->name('carton-boxes.search');
    Route::post('/carton-boxes/{cartonBox}/validate', [CartonBoxController::class, 'validate'])->name('carton-boxes.validate');
    Route::get('/carton-boxes/{cartonBox}/verified', [CartonBoxController::class, 'verified'])->name('carton-boxes.verified');

    Route::delete('/auth/destroy/{provider}', [OauthController::class, 'destroy'])->name('oauth.destroy');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');

    Route::resource('/subscriptions', SubscriptionController::class)->names('subscriptions')->only(['index', 'create', 'store', 'show']);
});
