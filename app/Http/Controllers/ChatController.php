<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use PrismServer;
use Inertia\Inertia;
use Inertia\Response;

final class ChatController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Chat/Index', [
            'subscriptionEnabled' => request()->user()->subscribed('Larasonic Pro ✨'),
            'systemPrompt' => view('prompts.system')->render(),
            'models' => PrismServer::prisms()->pluck('name'),
        ]);
    }
}
