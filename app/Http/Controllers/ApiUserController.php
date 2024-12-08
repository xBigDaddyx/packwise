<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Auth\Access\AuthorizationException;
use App\Actions\Fortify\UpdateUserProfileInformation;

/**
 * @group User management
 *
 * APIs for managing users
 */
final class ApiUserController extends Controller
{
    /**
     * Display a paginated list of users.
     *
     * @return Collection<int, User>|null
     *
     * @throws AuthorizationException
     *
     * @authenticated
     */
    public function index(): ?Collection
    {
        Gate::authorize('view', User::class);

        return type(Auth::user())->as(User::class)->currentTeam?->users;
    }

    /**
     * Create a new user.
     *
     * @throws AuthorizationException
     *
     * @authenticated
     */
    public function store(Request $request): User
    {
        Gate::authorize('create', User::class);

        return app(CreateNewUser::class)->create([
            'name' => (string) $request->string('name'),
            'email' => (string) $request->string('email'),
            'password' => (string) $request->string('password'),
            'terms' => 'true',
        ]);
    }

    /**
     * Get a specific user by ID.
     */
    public function show(User $user): User
    {
        Gate::authorize('view', $user);

        return $user;
    }

    /**
     * Update user profile information.
     *
     * @authenticated
     *
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user): User
    {
        Gate::authorize('update', $user);

        app(UpdateUserProfileInformation::class)->update($user, [
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return $user;
    }

    /**
     * Delete a user.
     *
     * @authenticated
     *
     * @throws AuthorizationException
     */
    public function destroy(User $user): Response
    {
        Gate::authorize('delete', $user);
        app(DeleteUser::class)->delete($user);

        return response()->noContent();
    }
}
