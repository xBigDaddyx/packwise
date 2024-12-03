<?php

declare(strict_types=1);

namespace App\Enums;

enum OauthProvider: string
{
    case GITHUB = 'github';
    case GITLAB = 'gitlab';
}
