<?php

declare(strict_types=1);

namespace App\Enums;

enum OauthProvider: string
{
    case GITHUB = 'github';
    case GOOGLE = 'google';
    case X = 'x';
}
