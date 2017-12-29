<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    const INTERFACE_REPOSITORY_DIRECTORY = "App\Repositories\Interfaces";
    const REPOSITORY_DIRECTORY = "App\Repositories";
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
        
        $this->app->bind('App\Repositories\Interfaces\UserRepositoryInterface', 'App\Repositories\UserRepository');
        $this->app->bind('App\Repositories\Interfaces\ItemRepositoryInterface', 'App\Repositories\ItemRepository');
        $this->app->bind('App\Repositories\Interfaces\PdfRepositoryInterface', 'App\Repositories\PdfRepository');
//        $this->app->bind( INTERFACE_REPOSITORY_DIRECTORY+'\UserRepositoryInterface', REPOSITORY_DIRECTORY+'\UserRepository');
//        $this->app->bind(INTERFACE_REPOSITORY_DIRECTORY+'\ItemRepositoryInterface', REPOSITORY_DIRECTORY+'\ItemRepository');
//        $this->app->bind(INTERFACE_REPOSITORY_DIRECTORY+'\PdfRepositoryInterface', REPOSITORY_DIRECTORY+'\PdfRepository');
    }
}
