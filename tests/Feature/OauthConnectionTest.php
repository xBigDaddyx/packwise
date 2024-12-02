<?php

declare(strict_types=1);

use App\Enums\OauthProvider;
use App\Models\{OauthConnection, User};
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\{Auth, Queue};
use App\Jobs\User\UpdateUserProfileInformationJob;
use Laravel\Socialite\Two\{InvalidStateException, User as SocialiteUser};

use function Pest\Laravel\assertDatabaseCount;

beforeEach(function () {
    $this->mockSocialite = Mockery::mock('Laravel\Socialite\Contracts\Provider');
    Socialite::shouldReceive('driver')->andReturn($this->mockSocialite);

    $this->socialiteUser = tap(new SocialiteUser, function ($user) {
        $user->map([
            'id' => '121212',
            'nickname' => 'johndoe',
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'avatar' => 'https://github.com/avatar.jpg',
            'user' => ['id' => '123456'],
            'token' => '123456',
            'refresh_token' => null,
        ]);
    });
});

describe('oauth redirect', function () {
    test('redirects to provider oauth page', function () {
        foreach (OauthProvider::cases() as $provider) {
            $this->mockSocialite->shouldReceive('redirect')
                ->once()
                ->andReturn(redirect('https://test.com/url'));

            $response = $this->get(route('oauth.redirect', ['provider' => $provider->value]));

            $response->assertRedirect();
            expect($response->headers->get('Location'))
                ->toContain('https://test.com/url');
        }
    });

    test('throws exception if provider is not supported', function () {
        $this->get(route('oauth.redirect', ['provider' => 'unsupported']))
            ->assertStatus(404);
    });
});

describe('oauth callback', function () {
    test('handles invalid state', function () {
        $this->mockSocialite->shouldReceive('user')
            ->once()
            ->andThrow(new InvalidStateException);

        $response = $this->get(route('oauth.callback', ['provider' => 'github']));

        $response->assertRedirect(route('login'))
            ->assertSessionHas('error', 'The request timed out. Please try again.');
    });

    test('creates new user from oauth data', function () {
        Queue::fake();
        $this->mockSocialite->shouldReceive('user')->andReturn($this->socialiteUser);

        $response = $this->getJson(route('oauth.callback', ['provider' => 'github']));

        $user = User::where('email', 'john@test.com')->first();

        expect($user)->not->toBeNull()
            ->and(Auth::id())->toBe($user->id)
            ->and(Auth::check())->toBeTrue();

        Queue::assertPushed(UpdateUserProfileInformationJob::class);
        $response->assertRedirect(config('fortify.home'));
    });

    test('creates new user from oauth data and oauth connection', function () {
        $this->mockSocialite->shouldReceive('user')->andReturn($this->socialiteUser);
        $response = $this->getJson(route('oauth.callback', ['provider' => 'github']));
        $user = User::where('email', 'john@test.com')->first();

        expect($user)->not->toBeNull()
            ->and(Auth::id())->toBe($user->id)
            ->and(Auth::check())->toBeTrue();

        $connection = OauthConnection::first();
        assertDatabaseCount('oauth_connections', 1);
        expect($connection)->not->toBeNull()
            ->and($connection->user_id)->toBe($user->id)
            ->and($connection->provider)->toBe(OauthProvider::GITHUB->value);

        $response->assertRedirect(config('fortify.home'));
    });

    test('creates new user from oauth data and oauth connection without needing email verification', function () {
        $this->mockSocialite->shouldReceive('user')->andReturn($this->socialiteUser);
        $response = $this->getJson(route('oauth.callback', ['provider' => 'github']));
        /** @var User $user */
        $user = User::query()->where('email', 'john@test.com')->first();

        expect($user)->not->toBeNull()
            ->and(Auth::id())->toBe($user->id)
            ->and(Auth::check())->toBeTrue();

        $connection = OauthConnection::first();
        assertDatabaseCount('oauth_connections', 1);
        expect($connection)->not->toBeNull()
            ->and($connection->user_id)->toBe($user->id)
            ->and($connection->provider)->toBe(OauthProvider::GITHUB->value);

        $response->assertRedirect(config('fortify.home'));
        $this->actingAs($user)
            ->get(config('fortify.home'))
            ->assertStatus(200);
    });

    test('logs in existing oauth connected user', function () {
        Queue::fake();
        $user = User::factory()->create(['email' => 'john@test.com']);
        OauthConnection::factory()->withProvider(OauthProvider::GITHUB)->create([
            'user_id' => $user->id,
        ]);

        $this->mockSocialite->shouldReceive('user')->once()->andReturn($this->socialiteUser);

        $response = $this->get(route('oauth.callback', ['provider' => 'github']));

        expect(Auth::check())->toBeTrue()
            ->and(Auth::id())->toBe($user->id);

        Queue::assertPushed(UpdateUserProfileInformationJob::class);
        $response->assertRedirect(config('fortify.home'));
    });

    test('prevents login with different provider for existing email', function () {
        User::factory()->create(['email' => 'john@test.com']);
        $this->mockSocialite->shouldReceive('user')->once()->andReturn($this->socialiteUser);

        $response = $this->get(route('oauth.callback', ['provider' => 'github']));

        expect(Auth::check())->toBeFalse();
        $response->assertRedirect(route('login'))
            ->assertSessionHas('error', 'Please login with existing auth provider and then link account');
    });

    test('prevents login with different provider for existing email with different provider', function () {
        $user = User::factory()->create(['email' => 'john@test.com']);
        OauthConnection::factory()->withProvider(OauthProvider::GOOGLE)->create([
            'user_id' => $user->id,
        ]);

        $this->mockSocialite->shouldReceive('user')->once()->andReturn($this->socialiteUser);

        $response = $this->get(route('oauth.callback', ['provider' => 'github']));
        expect(Auth::check())->toBeFalse();
        $response->assertRedirect(route('login'))
            ->assertSessionHas('error', 'Please login with existing auth provider and then link account');
    });

    test('handles general authentication errors', function () {
        $this->mockSocialite->shouldReceive('user')
            ->once()
            ->andThrow(new Exception('Something went wrong'));

        $response = $this->get(route('oauth.callback', ['provider' => 'github']));

        $response->assertRedirect(route('login'))
            ->assertSessionHas('error', 'An error occurred during authentication. Please try again.');
    });
});
