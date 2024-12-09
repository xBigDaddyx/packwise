<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\OauthConnection;
use Illuminate\Support\Collection;
use App\Actions\User\ActiveOauthProviderAction;

covers(OauthConnection::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

describe('oauth connection model tests', function () {
    test('oauth connection belongs to a user', function () {
        $connection = OauthConnection::factory()->create([
            'user_id' => $this->user->id,
        ]);

        expect($connection->user)
            ->toBeInstanceOf(User::class)
            ->id->toBe($this->user->id);
    });

    test('oauth connection casts data to collection only', function () {
        $connection = OauthConnection::factory()->create([
            'data' => ['name' => 'John Doe'],
        ]);

        expect($connection->data)
            ->toBeInstanceOf(Collection::class);

        expect($connection->data)->not->toBeInstanceOf(ArrayObject::class);
    });

    test('oauth connection can create oauth provider connection', function () {
        foreach ((new ActiveOauthProviderAction())->handle() as $provider) {
            $connection = OauthConnection::factory()->withProvider($provider['slug'])->create();

            expect($connection)
                ->provider->toBe($provider['slug'])
                ->data->toBeInstanceOf(Collection::class)
                ->data->toHaveKeys([
                    'id',
                    'name',
                    'email',
                ]);
        }
    });

    test('oauth connection can mark connection as expired', function () {
        $connection = OauthConnection::factory()->expired()->create();

        expect($connection)
            ->token->toBeNull()
            ->refresh_token->toBeNull();
    });

    test('oauth connection cascades on user deletion', function () {
        $user = User::factory()->create();
        $connection = OauthConnection::factory()->create([
            'user_id' => $user->id,
        ]);

        $user->delete();
        expect(OauthConnection::find($connection->id))->toBeNull();
    });
});
