<?php

declare(strict_types=1);

use App\Enums\OauthProvider;
use App\Models\{OauthConnection, User};
use Illuminate\Support\Facades\{DB, Queue};
use App\Actions\User\HandleOauthCallbackAction;
use App\Jobs\User\UpdateUserProfileInformationJob;
use Laravel\Socialite\Two\User as SocialiteUser;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->socialiteUser = tap(new SocialiteUser, function ($user) {
        $user->map([
            'id' => '12345',
            'nickname' => 'johndoe',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'avatar' => 'https://example.com/avatar.jpg',
            'token' => 'oauth-token',
            'refreshToken' => 'refresh-token',
            'expiresIn' => 3600,
        ]);
    });
});

test('it creates new user when handling unauthenticated user', function () {
    $result = (new HandleOauthCallbackAction())->handle(OauthProvider::GITHUB, $this->socialiteUser);

    expect($result)
        ->toBeInstanceOf(User::class)
        ->and($result->name)->toBe('John Doe')
        ->and($result->email)->toBe('john@example.com');

    assertDatabaseHas('oauth_connections', [
        'user_id' => $result->id,
        'provider' => OauthProvider::GITHUB->value,
        'provider_id' => '12345',
    ]);
});

test('it creates new user when handling unauthenticated user and pushes update user profile information job', function () {
    Queue::fake();
    $result = (new HandleOauthCallbackAction())->handle(OauthProvider::GITHUB, $this->socialiteUser);

    expect($result)
        ->toBeInstanceOf(User::class)
        ->and($result->name)->toBe('John Doe')
        ->and($result->email)->toBe('john@example.com');

    Queue::assertPushed(UpdateUserProfileInformationJob::class);
});

test('it links oauth account to authenticated user with matching email', function () {
    $user = User::factory()->create(['email' => 'john@example.com']);

    $result = (new HandleOauthCallbackAction())->handle(OauthProvider::GITHUB, $this->socialiteUser, $user);

    expect($result->id)->toBe($user->id);

    assertDatabaseHas('oauth_connections', [
        'user_id' => $user->id,
        'provider' => OauthProvider::GITHUB->value,
        'provider_id' => '12345',
    ]);
});

test('it throws exception when emails do not match for authenticated user', function () {
    $user = User::factory()->create(['email' => 'different@example.com']);

    expect(fn () => (new HandleOauthCallbackAction())->handle(OauthProvider::GITHUB, $this->socialiteUser, $user))
        ->toThrow(
            InvalidArgumentException::class,
            'The email address from this github does not match your account email.'
        );

    $this->assertDatabaseMissing('oauth_connections', [
        'provider' => OauthProvider::GITHUB->value,
        'provider_id' => '12345',
    ]);
});

test('it handles existing user with oauth connection', function () {
    $user = User::factory()->create(['email' => 'john@example.com']);

    OauthConnection::factory()->create([
        'user_id' => $user->id,
        'provider' => OauthProvider::GITHUB->value,
        'provider_id' => '12345',
    ]);

    $result = (new HandleOauthCallbackAction())->handle(OauthProvider::GITHUB, $this->socialiteUser);

    expect($result->id)->toBe($user->id);

    $this->assertDatabaseCount('oauth_connections', 1);
});

test('it throws exception when oauth connection exists for different user', function () {
    $existingUser = User::factory()->create();
    $newUser = User::factory()->create(['email' => 'john@example.com']);

    OauthConnection::factory()->create([
        'user_id' => $existingUser->id,
        'provider' => OauthProvider::GITHUB->value,
        'provider_id' => '12345',
    ]);

    expect(fn () => (new HandleOauthCallbackAction())->handle(OauthProvider::GITHUB, $this->socialiteUser, $newUser))
        ->toThrow(InvalidArgumentException::class);
});
