<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Foundation\AliasLoader;
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


        $this->loadViewsFrom(__DIR__.'/resources/views/', 'admin');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sla', 'SystemInc\LaravelAdmin\SLA');

        $this->app->singleton('command.laravel-admin.instal', function () {
            return new Console\InstalCommand();
        });

        $this->app->singleton('command.laravel-admin.update', function () {
            return new Console\UpdateCommand();
        });

        $this->commands(['command.laravel-admin.instal']);
        $this->commands(['command.laravel-admin.update']);

        $this->app->register(\Intervention\Image\ImageServiceProvider::class);
        $this->app->register(\Barryvdh\DomPDF\ServiceProvider::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Image', \Intervention\Image\Facades\Image::class);
        $loader->alias('PDF', \Barryvdh\DomPDF\Facade::class);
    }


}
