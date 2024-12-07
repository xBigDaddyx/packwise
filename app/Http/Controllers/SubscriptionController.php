<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Laravel\Cashier\Checkout;

final class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $request->user()->redirectToBillingPortal(route('subscriptions.create'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        return Inertia::render('Subscriptions/Index', [
            'activeSubscriptions' => $user->subscriptions()->active()->get(),
            'availableSubscriptions' => config('subscriptions.subscriptions'),
            'activeInvoices' => Inertia::defer(fn () => $user->invoices()),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $subscription): Checkout
    {
        abort_unless(in_array($subscription, collect(config('subscriptions.subscriptions'))->pluck('price_id')->toArray()), 404);

        /** @var User $user */
        $user = request()->user();
        $name = collect(config('subscriptions.subscriptions'))->firstWhere('price_id', $subscription)['plan'];

        return $user
            ->newSubscription($name, $subscription)
            ->checkout([
                'success_url' => route('subscriptions.index'),
                'cancel_url' => route('subscriptions.create'),
            ]);
    }
}
