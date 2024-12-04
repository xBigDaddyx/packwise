<?php

declare(strict_types=1);

use App\Models\User;
use App\Enums\OauthProvider;
use App\Models\OauthConnection;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\User\OauthController;
use App\Exceptions\OAuthAccountLinkingException;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\User as SocialiteUser;

use function Pest\Laravel\get;
use function Pest\Laravel\delete;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;

covers(OauthController::class);

beforeEach(function () {
    test()->socialiteUser = tap(new SocialiteUser, function ($user) {
        $user->map([
            'id' => '1',
            'nickname' => 'test',
            'name' => 'Test User',
            'email' => 'test@test.com',
            'avatar' => 'https://github.com/avatar.jpg',
            'user' => ['id' => '123456'],
            'token' => 'test-token',
            'refreshToken' => 'test-refresh-token',
            'expiresIn' => 3600,
        ]);
    });
});

function mockSocialiteForRedirect()
{
    $mockSocialite = Mockery::mock('Laravel\Socialite\Contracts\Provider');
    $mockSocialite->shouldReceive('redirect')->andReturn(redirect('https://example.com'));
    Socialite::shouldReceive('driver')->andReturn($mockSocialite);

    return $mockSocialite;
}

function mockSocialiteForCallback()
{
    $mockSocialite = Mockery::mock('Laravel\Socialite\Contracts\Provider');
    Socialite::shouldReceive('driver')->andReturn($mockSocialite);
    $mockSocialite->shouldReceive('user')->andReturn(test()->socialiteUser);

    return $mockSocialite;
}

test('it redirects to oauth provider', function () {
    foreach (OauthProvider::cases() as $provider) {
        mockSocialiteForRedirect();
        $response = get(route('oauth.redirect', ['provider' => $provider]));

        $response->assertRedirect();
        $response->assertStatus(302);
    }
});

test('it fails to redirect to oauth provider with invalid provider', function () {
    $response = get(route('oauth.redirect', ['provider' => 'invalid-provider']));

    $response->assertStatus(404);
});

test('it handles oauth callback for new user without authenticated user', function () {
    mockSocialiteForCallback();

    assertDatabaseCount('users', 0);
    assertDatabaseCount('oauth_connections', 0);

    $response = get(route('oauth.callback', ['provider' => OauthProvider::GITHUB]));

    $response->assertRedirect(config('fortify.home'));
    assertDatabaseCount('users', 1);
    assertDatabaseCount('oauth_connections', 1);

    $connection = OauthConnection::first();
    expect($connection->provider)->toBe(OauthProvider::GITHUB->value)
        ->and($connection->provider_id)->toBe('1')
        ->and($connection->token)->toBe('test-token')
        ->and($connection->refresh_token)->toBe('test-refresh-token');
});

test('it handles oauth callback for existing user without authenticated user', function () {
    User::factory()->create(['email' => 'test@test.com']);
    mockSocialiteForCallback();

    assertDatabaseCount('oauth_connections', 0);
    assertDatabaseCount('users', 1);

    $response = get(route('oauth.callback', ['provider' => OauthProvider::GITHUB]));

    $response->assertRedirect(route('login'))
        ->assertSessionHas('error', OAuthAccountLinkingException::EXISTING_CONNECTION_ERROR_MESSAGE);

    assertDatabaseCount('oauth_connections', 0);
    assertDatabaseCount('users', 1);
});

test('it handles oauth callback for existing user without authenticated user and other provider', function () {
    $user = User::factory()->create(['email' => 'test@test.com']);
    mockSocialiteForCallback();
    $existingConnection = OauthConnection::factory()
        ->for($user)
        ->withProvider(OauthProvider::GITHUB)
        ->create(['provider_id' => '1']);

    assertDatabaseCount('oauth_connections', 1);
    assertDatabaseCount('users', 1);

    $response = get(route('oauth.callback', ['provider' => OauthProvider::GITLAB]));

    $response->assertRedirect(route('login'))
        ->assertSessionHas('error', OAuthAccountLinkingException::EXISTING_CONNECTION_ERROR_MESSAGE);

    assertDatabaseCount('oauth_connections', 1);
    assertDatabaseCount('users', 1);
});

test('it handles invalid state exception without authenticated user', function () {
    Socialite::shouldReceive('driver')
        ->with('github')
        ->andThrow(new InvalidStateException);

    $response = get(route('oauth.callback', ['provider' => OauthProvider::GITHUB]));

    $response->assertRedirect(route('login'))
        ->assertSessionHas('error', 'The request timed out. Please try again.');
});

test('it handles oauth callback with existing connection and without authenticated user', function () {
    $user = User::factory()->create(['email' => 'test@test.com']);
    mockSocialiteForCallback();

    $existingConnection = OauthConnection::factory()
        ->for($user)
        ->withProvider(OauthProvider::GITHUB)
        ->create(['provider_id' => '1']);

    assertDatabaseCount('oauth_connections', 1);
    assertDatabaseCount('users', 1);

    $response = get(route('oauth.callback', ['provider' => OauthProvider::GITHUB]));

    $response->assertRedirect(config('fortify.home'));

    assertDatabaseCount('oauth_connections', 1);
    assertDatabaseCount('users', 1);

    $connection = OauthConnection::first();
    expect($connection->id)->toBe($existingConnection->id)
        ->and($connection->provider)->toBe(OauthProvider::GITHUB->value)
        ->and($connection->provider_id)->toBe('1')
        ->and($connection->user_id)->toBe($user->id)
        ->and($connection->token)->toBe('test-token')
        ->and($connection->refresh_token)->toBe('test-refresh-token');
});

test('it handles linking account with same email for authenticated user', function () {
    $user = User::factory()->create(['email' => 'test@test.com']);
    mockSocialiteForCallback();

    assertDatabaseCount('oauth_connections', 0);
    assertDatabaseCount('users', 1);

    $response = actingAs($user)
        ->get(route('oauth.callback', ['provider' => OauthProvider::GITHUB]))
        ->assertRedirect(route('profile.show'))
        ->assertSessionHas('success', 'Your github account has been linked.');

    assertDatabaseCount('oauth_connections', 1);
    assertDatabaseCount('users', 1);
});

test('it handles oauth callback with mismatched emails for authenticated user', function () {
    $user = User::factory()->create(['email' => 'different@example.com']);
    mockSocialiteForCallback();

    assertDatabaseCount('oauth_connections', 0);
    assertDatabaseCount('users', 1);

    $response = actingAs($user)
        ->get(route('oauth.callback', ['provider' => OauthProvider::GITHUB]))
        ->assertRedirect(route('profile.show'))
        ->assertSessionHas('error', 'The email address from this github does not match your account email.');

    assertDatabaseCount('oauth_connections', 0);
    assertDatabaseCount('users', 1);
});

test('it can not unlink oauth connection without authenticated user', function () {
    $user = User::factory()->create();
    $connection = OauthConnection::factory()
        ->for($user)
        ->withProvider(OauthProvider::GITHUB)
        ->create();

    delete(route('oauth.destroy', ['provider' => OauthProvider::GITHUB]))
        ->assertRedirect(route('login'));

    assertDatabaseCount('oauth_connections', 1);
    assertDatabaseCount('users', 1);
});

test('it can unlink oauth connection with authenticated user', function () {
    $user = User::factory()->create();
    $connection = OauthConnection::factory()
        ->for($user)
        ->withProvider(OauthProvider::GITHUB)
        ->create();

    actingAs($user)
        ->delete(route('oauth.destroy', ['provider' => OauthProvider::GITHUB]))
        ->assertRedirect(route('profile.show'))
        ->assertSessionHas('success', 'Your github account has been unlinked.');

    assertDatabaseCount('oauth_connections', 0);
    assertDatabaseCount('users', 1);
});
