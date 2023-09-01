<?php

namespace App\Providers;

use App\Repositories\LinkRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\LinkService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthService::class, function ($app) {
            return new AuthService(
                new UserRepository()
            );
        });

        $this->app->bind(LinkService::class, function ($app) {
            return new LinkService(
                new LinkRepository()
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
