<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\{Inertia, Response};
use Illuminate\Support\Facades\Route;

final class WelcomeController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function pricing(): Response
    {
        return Inertia::render('Pricing', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }
}
