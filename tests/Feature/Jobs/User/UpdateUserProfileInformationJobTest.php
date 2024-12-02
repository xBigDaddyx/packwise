<?php

declare(strict_types=1);

use Carbon\Carbon;
use App\Enums\OauthProvider;
use App\Models\{OauthConnection, User};
use Laravel\Socialite\Two\User as SocialiteUser;
use App\Jobs\User\UpdateUserProfileInformationJob;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->socialiteUser = new SocialiteUser;
    $this->socialiteUser->map([
        'id' => '123456789',
        'name' => $this->user->name,
        'email' => $this->user->email,
        'avatar' => fake()->imageUrl(),
        'user' => [
            'id' => 123456789,
        ],
        'token' => 'test-token',
        'refreshToken' => 'test-refresh-token',
        'expiresIn' => null,
    ]);
});

test('it creates new oauth connection when none exists', function () {
    $job = new UpdateUserProfileInformationJob(
        $this->user,
        $this->socialiteUser,
        OauthProvider::GITHUB
    );

    $job->handle();

    assertDatabaseHas('oauth_connections', [
        'user_id' => $this->user->id,
        'provider' => OauthProvider::GITHUB->value,
        'provider_id' => '123456789',
        'token' => 'test-token',
        'refresh_token' => 'test-refresh-token',
    ]);

    $connection = OauthConnection::first();
    expect($connection->data)->toEqual(collect(['id' => '123456789']));
});

test('it updates existing oauth connection', function () {
    OauthConnection::factory()
        ->withProvider(OauthProvider::GITHUB)
        ->create([
            'user_id' => $this->user->id,
            'provider_id' => 'old-id',
            'token' => 'old-token',
            'refresh_token' => 'old-refresh-token',
        ]);

    $job = new UpdateUserProfileInformationJob(
        $this->user,
        $this->socialiteUser,
        OauthProvider::GITHUB
    );

    $job->handle();

    assertDatabaseHas('oauth_connections', [
        'user_id' => $this->user->id,
        'provider' => OauthProvider::GITHUB->value,
        'provider_id' => '123456789',
        'token' => 'test-token',
        'refresh_token' => 'test-refresh-token',
    ]);

    assertDatabaseCount('oauth_connections', 1);
});

test('it handles null expiration time correctly', function () {
    $socialiteUser = Mockery::mock(SocialiteUser::class);
    $socialiteUser->shouldReceive([
        'getId' => '123456789',
        'getRaw' => ['raw_data' => 'test'],
        'token' => 'test-token',
        'refreshToken' => 'test-refresh-token',
        'expiresIn' => null,
    ]);

    $job = new UpdateUserProfileInformationJob(
        $this->user,
        $socialiteUser,
        OauthProvider::GITHUB
    );

    $job->handle();

    $connection = OauthConnection::first();
    $this->assertNull($connection->expires_at);
});
