<?php

declare(strict_types=1);

namespace App\Providers;

use PrismServer;
use EchoLabs\Prism\Prism;
use EchoLabs\Prism\Text\Generator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use EchoLabs\Prism\Enums\Provider as PrismProvider;
use Illuminate\Support\Facades\{App, DB, URL, Vite};

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (App::isLocal()) {
            App::register(\Laravel\Telescope\TelescopeServiceProvider::class);
            App::register(TelescopeServiceProvider::class);
        }
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
        $this->configurePrisms();
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

    /**
     * Configure the application's Prisms.
     */
    private function configurePrisms(): void
    {
        PrismServer::register(
            'larasonic',
            fn (): Generator => Prism::text()->using(PrismProvider::Groq, 'llama3-8b-8192')
        );
    }
}
