<?php

namespace App\Providers;

use App\Service\KeyGenerator;
use App\Service\KeyGeneratorInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(KeyGeneratorInterface::class, KeyGenerator::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
