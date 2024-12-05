<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * This enum is used to define the OAuth providers that are supported by the application.
 * Just add the provider you want to support to the enum both backend and frontend will be compatible.
 * Curretly this supports only following providers :- github, gitlab, x, google, and bitbucket and discord.
 *
 * Also don't forget to update the .env and `config/services.php` file with the new provider credentials.
 *
 * @see https://laravel.com/docs/11.x/socialite#registering-providers
 *
 * The frontend uses this enum to map the providers to the icons.
 * @uses resources/js/lib/oauthProvider.js
 */
enum OauthProvider: string
{
    case GITHUB = 'github';
    case GITLAB = 'gitlab';
}
