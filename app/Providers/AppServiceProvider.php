<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{App, DB, URL, Vite};

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureCommands();
        $this->configureModels();
        $this->configureUrl();
        $this->configureVite();
    }

    /**
     * Configure the application's commands.
     */
    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(App::isProduction());
    }

    /**
     * Configure the application's models.
     */
    private function configureModels(): void
    {
        Model::shouldBeStrict();

        Model::unguard();

        Model::preventSilentlyDiscardingAttributes(App::isLocal());
    }

    /**
     * Configure the application's URL.
     */
    private function configureUrl(): void
    {
        URL::forceHttps(App::isProduction());
    }

    /**
     * Configure the application's Vite.
     */
    private function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }
}
