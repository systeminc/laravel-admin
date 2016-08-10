<?php

namespace SystemInc\LaravelAdmin;

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
        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Http/routes.php';
        }

        // Merge auth configurations
        $auth_config = array_merge_recursive($this->app['config']['auth'], require __DIR__.'/config/auth.php');
        $this->app['config']->set('auth', $auth_config);

        //Gracefull push
        $this->publishes([
            //IMAGES
            __DIR__.'/resources/images/' => public_path('images'),
            //VIEWS
            __DIR__.'/resources/views/' => resource_path('views'),
            //STYLES AND JS
            __DIR__.'/resources/assets/' => resource_path('assets'),
            //MIGRATIONS
            __DIR__.'/database/migrations/' => database_path('migrations'),
            //SEEDS
            __DIR__.'/database/seeds/' => database_path('seeds'),
        ], 'laravel-admin');

        //Force push
        $this->publishes([
            //IMAGES
            __DIR__.'/resources/images/' => public_path('images'),
            //VIEWS
            __DIR__.'/resources/views/' => resource_path('views'),
            //STYLES AND JS
            __DIR__.'/resources/assets/' => resource_path('assets'),
            //MIGRATIONS
            __DIR__.'/database/migrations/' => database_path('migrations'),
            //SEEDS
            __DIR__.'/database/seeds/' => database_path('seeds'),
            //GULP JS
            __DIR__.'/resources/gulpfile.js' => base_path('gulpfile.js'),
        ], 'laravel-admin-force');
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
