<?php

declare(strict_types=1);

use App\Providers\{AppServiceProvider, FortifyServiceProvider, JetstreamServiceProvider, TelescopeServiceProvider};

return [
    AppServiceProvider::class,
    FortifyServiceProvider::class,
    JetstreamServiceProvider::class,
    TelescopeServiceProvider::class,
];
