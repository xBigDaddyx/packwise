<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use Throwable;
use App\Models\User;
use App\Enums\OauthProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Actions\Fortify\CreateNewUser;
use Laravel\Socialite\Facades\Socialite;
use App\Jobs\User\UpdateUserProfileInformationJob;
use Illuminate\Support\Facades\{Auth, DB, Redirect};
use Laravel\Socialite\Two\{InvalidStateException, User as SocialiteUser};
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

final class OauthController extends Controller
{
    public function redirect(OauthProvider $provider): SymfonyRedirectResponse
    {
        return Socialite::driver($provider->value)->redirect();
    }

    public function callback(OauthProvider $provider): RedirectResponse
    {
        try {
            $socialiteUser = $this->getSocialiteUser($provider);
        } catch (InvalidStateException) {
            return Redirect::route('login')->with('error', __('The request timed out. Please try again.'));
        } catch (Throwable $throwable) {
            report($throwable);

            return Redirect::route('login')->with('error', __('An error occurred during authentication. Please try again.'));
        }

        try {
            $user = User::query()->where('email', $socialiteUser->getEmail())->first();

            return DB::transaction(function () use ($provider, $socialiteUser, $user): RedirectResponse {
                if ($user instanceof User) {
                    return $this->handleExistingUser($user, $provider, $socialiteUser);
                }

                return $this->createAndLoginNewUser($socialiteUser, $provider);
            });
        } catch (Throwable $throwable) {
            report($throwable);

            return Redirect::route('login')->with('error', __('An error occurred during authentication. Please try again.'));
        }
    }

    private function getSocialiteUser(OauthProvider $provider): SocialiteUser
    {
        /** @var SocialiteUser */
        return Socialite::driver($provider->value)->user();
    }

    private function handleExistingUser(User $user, OauthProvider $provider, SocialiteUser $socialiteUser): RedirectResponse
    {
        if ($user->oauthConnections()->where('provider', $provider)->exists()) {
            Auth::login($user, remember: true);
            dispatch(new UpdateUserProfileInformationJob($user, $socialiteUser, $provider))->afterCommit();

            return Redirect::intended(config('fortify.home'));
        }

        return Redirect::route('login')
            ->with('error', __('Please login with existing auth provider and then link account'));
    }

    private function createAndLoginNewUser(SocialiteUser $socialiteUser, OauthProvider $provider): RedirectResponse
    {
        $user = (new CreateNewUser())->create([
            'name' => (string) $socialiteUser->getName(),
            'email' => (string) $socialiteUser->getEmail(),
            'email_verified_at' => (string) true,
            'terms' => (string) true,
        ]);

        dispatch(new UpdateUserProfileInformationJob($user, $socialiteUser, $provider))->afterCommit();

        Auth::login($user, true);

        return Redirect::intended(config('fortify.home'));
    }
}
