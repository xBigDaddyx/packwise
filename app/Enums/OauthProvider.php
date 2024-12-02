<?php

declare(strict_types=1);

namespace App\Enums;

enum OauthProvider: string
{
    case GITHUB = 'github';
    case GOOGLE = 'google';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(fn (OauthProvider $provider) => $provider->value, OauthProvider::cases());
    }
}
