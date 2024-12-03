<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\{Inertia, Response};

final class ChatController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Chat/Index');
    }

    public function store(Request $request): void
    {
        //
    }
}
