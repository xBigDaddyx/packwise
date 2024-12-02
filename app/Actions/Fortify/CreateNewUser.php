<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Models\{Team, User};
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\{Arr, Str};
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\{DB, Hash, Validator};

final class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => Arr::get($input, 'password') ? $this->passwordRules() : 'sometimes',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(fn () => tap(User::query()->create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Arr::get($input, 'password') ? Hash::make($input['password']) : Str::random(12),
        ]), function (User $user): void {
            $this->createTeam($user);
        }));
    }

    /**
     * Create a personal team for the user.
     */
    private function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::query()->forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }
}
