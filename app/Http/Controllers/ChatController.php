<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\{Inertia, Response};
use PrismServer;

final class ChatController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Chat/Index', [
            'systemPrompt' => view('prompts.system')->render(),
            'models' => PrismServer::prisms()->pluck('name'),
        ]);
    }
}
