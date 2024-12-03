<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\OauthProvider;
use App\Models\{OauthConnection, User};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OauthConnection>
 */
final class OauthConnectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<model-property<OauthConnection>, mixed>
     */
    public function definition(): array
    {
        /** @var OauthProvider $provider */
        $provider = fake()->randomElement(OauthProvider::cases());

        return [
            'user_id' => User::factory(),
            'provider' => $provider->value,
            'provider_id' => (string) fake()->randomNumber(8),
            'data' => $this->generateProviderData($provider),
            'token' => fake()->uuid(),
            'refresh_token' => fake()->uuid(),
            'expires_at' => fake()->dateTimeBetween('+1 day', '+1 week'),
        ];
    }

    /**
     * Indicate that the connection is for GitHub.
     */
    public function withProvider(OauthProvider $provider): static
    {
        return $this->state(fn (array $attributes): array => [
            'provider' => $provider->value,
            'data' => $this->generateProviderData($provider),
        ]);
    }

    /**
     * Indicate that the connection has an expired token.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes): array => [
            'token' => null,
            'refresh_token' => null,
        ]);
    }

    /**
     * Generate the data for the provider.
     *
     * @return array<string, mixed>
     */
    private function generateProviderData(OauthProvider $provider): array
    {
        return match ($provider) {
            OauthProvider::GITHUB => [
                'login' => fake()->userName(),
                'id' => fake()->randomNumber(8),
                'node_id' => 'MDQ6VXNlcj'.fake()->regexify('[A-Za-z0-9]{8}'),
                'avatar_url' => fake()->imageUrl(),
                'gravatar_id' => '',
                'url' => 'https://api.github.com/users/'.fake()->userName(),
                'html_url' => 'https://github.com/'.fake()->userName(),
                'name' => fake()->name(),
                'company' => '@'.fake()->company(),
                'blog' => fake()->url(),
                'location' => fake()->city().', '.fake()->country(),
                'email' => fake()->safeEmail(),
                'hireable' => fake()->boolean(),
                'bio' => fake()->sentence(),
                'twitter_username' => fake()->userName(),
                'public_repos' => fake()->numberBetween(0, 100),
                'public_gists' => fake()->numberBetween(0, 50),
                'followers' => fake()->numberBetween(0, 1000),
                'following' => fake()->numberBetween(0, 1000),
                'created_at' => fake()->dateTimeThisDecade()->format('Y-m-d\TH:i:s\Z'),
                'updated_at' => fake()->dateTimeThisYear()->format('Y-m-d\TH:i:s\Z'),
            ],
            OauthProvider::GITLAB => [
                'id' => fake()->uuid(),
                'name' => fake()->name(),
                'username' => fake()->userName(),
                'picture' => fake()->imageUrl(),
                'email' => fake()->safeEmail(),
                'email_verified' => true,
                'locale' => fake()->locale(),
            ],
        };
    }
}
