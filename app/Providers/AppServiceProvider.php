<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Http\Services\Interfaces\ITaskInterface::class, \App\Http\Services\Repositories\TaskRepository::class);
        $this->app->bind(\App\Http\Services\Interfaces\IPlanInterface::class, \App\Http\Services\Repositories\PlanRepository::class);
        $this->app->bind(\App\Http\Services\Interfaces\IDeveloperInterface::class, \App\Http\Services\Repositories\DeveloperRepository::class);

        $this->app->bind(\App\Managers\Provider\IProviderManager::class, function ($app) {
            return new \App\Managers\Provider\ProviderManager($app);
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
