<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Actions\Fortify\UpdateUserProfileInformation;

final class ApiUserController extends Controller
{
    /**
     * Display a paginated list of users.
     *
     * @return LengthAwarePaginator<User>
     */
    public function index(): LengthAwarePaginator
    {
        return User::query()->paginate();
    }

    /**
     * Create a new user.
     */
    public function store(Request $request): User
    {
        return app(CreateNewUser::class)->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'terms' => true,
        ]);
    }

    /**
     * Get a specific user by ID.
     */
    public function show(User $user): User
    {
        return $user;
    }

    /**
     * Update user profile information.
     */
    public function update(Request $request, User $user): User
    {
        app(UpdateUserProfileInformation::class)->update($user, [
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return $user;
    }

    /**
     * Delete a user.
     */
    public function destroy(User $user): Response
    {
        app(DeleteUser::class)->delete($user);

        return response()->noContent();
    }
}
