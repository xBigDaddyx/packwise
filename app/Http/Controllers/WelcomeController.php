<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\{Inertia, Response};
use Illuminate\Support\Facades\Route;

final class WelcomeController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }
}
