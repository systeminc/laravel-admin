<?php

namespace SystemInc\LaravelAdmin;

use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require __DIR__.'/../vendor/autoload.php';

        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Http/routes.php';
        }

        $this->mergeConfigFrom(__DIR__.'/config/auth.php', 'admin.auth');

        Auth::extend('system-admin', function ($app, $name, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...
            return new Guard(Auth::createUserProvider($config['admin.auth']));
        });

        $this->loadViewsFrom(__DIR__.'/resources/views/admin', 'admin');

        //IMAGES
        $this->publishes([
            __DIR__.'/resources/images/' => public_path('images'),
        ], 'images');

        //VIEWS
        $this->publishes([
            __DIR__.'/resources/views/' => resource_path('views'),
        ], 'views');

        //STYLES AND JS
        $this->publishes([
            __DIR__.'/resources/assets/' => resource_path('assets'),
        ], 'assets');

        //GULP JS
        $this->publishes([
            __DIR__.'/resources/gulpfile.js' => base_path('gulpfile.js'),
        ], 'gulp');

        //MIGRATIONS
        $this->publishes([
            __DIR__.'/database/migrations/' => database_path('migrations'),
        ], 'migrations');

        //SEEDS
        $this->publishes([
            __DIR__.'/database/seeds/' => database_path('seeds'),
        ], 'seeds');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
