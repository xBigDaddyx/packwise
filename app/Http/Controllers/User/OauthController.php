<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use Throwable;
use App\Enums\OauthProvider;
use InvalidArgumentException;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use App\Actions\User\HandleOauthCallbackAction;
use Illuminate\Support\Facades\{Auth, Redirect};
use Laravel\Socialite\Two\{InvalidStateException, User as SocialiteUser};
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

final class OauthController extends Controller
{
    public function __construct(
        private readonly HandleOauthCallbackAction $handleOauthCallbackAction,
    ) {}

    public function redirect(OauthProvider $provider): SymfonyRedirectResponse
    {
        return Socialite::driver($provider->value)->redirect();
    }

    public function callback(OauthProvider $provider): RedirectResponse
    {
        try {
            /** @var SocialiteUser $socialiteUser */
            $socialiteUser = Socialite::driver($provider->value)->user();
            $authenticatedUser = Auth::user();
            $user = $this->handleOauthCallbackAction->handle($provider, $socialiteUser, $authenticatedUser);
        } catch (InvalidStateException) {
            return Redirect::intended(Auth::check() ? route('profile.show') : route('login'))->with('error', __('The request timed out. Please try again.'));
        } catch (InvalidArgumentException $invalidArgumentException) {
            return Redirect::intended(Auth::check() ? route('profile.show') : route('login'))->with('error', $invalidArgumentException->getMessage());
        } catch (Throwable $throwable) {
            report($throwable);

            return Redirect::intended(Auth::check() ? route('profile.show') : route('login'))->with('error', __('An error occurred during authentication. Please try again.'));
        }

        if (Auth::guest()) {
            Auth::login($user, true);
        }

        return Redirect::intended($authenticatedUser ? route('profile.show') : config('fortify.home'))->with('success', "Your {$provider->value} account has been linked.");
    }

    public function destroy(OauthProvider $provider): RedirectResponse
    {
        $user = Auth::user();

        $user?->oauthConnections()->where('provider', $provider)->delete();
        session()->flash('success', "Your {$provider->value} account has been unlinked.");

        return Redirect::route('profile.show');
    }
}
