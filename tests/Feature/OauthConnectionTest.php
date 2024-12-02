<?php

declare(strict_types=1);

use App\Enums\OauthProvider;
use Illuminate\Http\Response;
use App\Models\{OauthConnection, User};
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\{Auth, Queue};
use App\Jobs\User\UpdateUserProfileInformationJob;
use Laravel\Socialite\Two\{InvalidStateException, User as SocialiteUser};

use function Pest\Laravel\{assertDatabaseCount};

beforeEach(function () {
    $this->mockSocialite = Mockery::mock('Laravel\Socialite\Contracts\Provider');
    Socialite::shouldReceive('driver')->with('github')->andReturn($this->mockSocialite);
});

test('oauth redirects to provider oauth page', function () {
    $this->mockSocialite->shouldReceive('redirect')
        ->once()
        ->andReturn(redirect('https://github.com/login/oauth/authorize'));

    $response = $this->get(route('oauth.redirect', ['provider' => 'github']));

    $response->assertRedirect();
    expect($response->headers->get('Location'))
        ->toStartWith('https://github.com/login/oauth/authorize');
});

test('oauth callback handles invalid state', function () {
    $this->mockSocialite->shouldReceive('user')
        ->once()
        ->andThrow(new InvalidStateException);

    $response = $this->get(route('oauth.callback', ['provider' => 'github']));

    $response->assertRedirect(route('login'))
        ->assertSessionHas('error', 'The request timed out. Please try again.');
});

test('oauth callback creates new user from oauth data if user is not found', function () {
    Queue::fake();

    $socialiteUser = new SocialiteUser();
    $socialiteUser->map([
        'id' => '121212',
        'nickname' => 'johndoe',
        'name' => 'John Doe',
        'email' => 'john@test.com',
        'avatar' => 'https://github.com/avatar.jpg',
        'user' => [
            'id' => '123456',
        ],
        'token' => '123456',
        'refresh_token' => null,
    ]);
    $this->mockSocialite->shouldReceive('user')->andReturn($socialiteUser);

    /** @var Response $response */
    $response = $this->getJson(route('oauth.callback', ['provider' => 'github']));

    $user = User::where('email', 'john@test.com')->first();

    assertDatabaseCount((new User())->getTable(), 1);
    Queue::assertPushed(UpdateUserProfileInformationJob::class, 1);
    expect(Auth::check())->toBeTrue()
        ->and(Auth::id())->toBe($user->id);
    $response->assertRedirect(config('fortify.home'));
});

test('logs in existing oauth connected user', function () {
    Queue::fake();

    $user = User::factory()->create([
        'email' => 'john@example.com',
    ]);

    OauthConnection::factory()->withProvider(OauthProvider::GITHUB)->create([
        'user_id' => $user->id,
    ]);

    $socialiteUser = new SocialiteUser;
    $socialiteUser->map([
        'id' => '121212',
        'nickname' => 'johndoe',
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'avatar' => 'https://github.com/avatar.jpg',
        'user' => [
            'id' => '123456',
        ],
        'token' => '123456',
        'refresh_token' => null,
    ]);

    $this->mockSocialite->shouldReceive('user')->once()->andReturn($socialiteUser);

    $response = $this->get(route('oauth.callback', ['provider' => 'github']));

    expect(Auth::check())->toBeTrue()
        ->and(Auth::id())->toBe($user->id);

    Queue::assertPushed(UpdateUserProfileInformationJob::class, 1);
    $response->assertRedirect(config('fortify.home'));
});

test('prevents login with different provider for existing email', function () {
    $user = User::factory()->create([
        'email' => 'john@example.com',
    ]);

    $socialiteUser = new SocialiteUser;
    $socialiteUser->map([
        'id' => '123456',
        'nickname' => 'johndoe',
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'avatar' => 'https://github.com/avatar.jpg',
    ]);

    $this->mockSocialite->shouldReceive('user')->once()->andReturn($socialiteUser);

    $response = $this->get(route('oauth.callback', ['provider' => 'github']));

    expect(Auth::check())->toBeFalse();

    $response->assertRedirect(route('login'))
        ->assertSessionHas('error', 'Please login with existing auth provider and then link account');
});

test('handles general errors during authentication', function () {
    $this->mockSocialite->shouldReceive('user')
        ->once()
        ->andThrow(new Exception('Something went wrong'));

    $response = $this->get(route('oauth.callback', ['provider' => 'github']));

    $response->assertRedirect(route('login'))
        ->assertSessionHas('error', 'An error occurred during authentication. Please try again.');
});
