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
            include __DIR__.'/Http/routes.php';
        }

        // Merge auth configurations
        $auth_config = array_merge_recursive($this->app['config']['auth'], include __DIR__.'/config/auth.php');
        $this->app['config']->set('auth', $auth_config);

        // Merge filesystems configurations
        $filesystems_config = array_merge_recursive($this->app['config']['filesystems'], include __DIR__.'/config/filesystems.php');
        $this->app['config']->set('filesystems', $filesystems_config);

        // Set default config to uploads
        if (config('filesystems.default') === 'local') {
            config(['filesystems.default' => 'uploads']);
        }

        $this->loadViewsFrom(__DIR__.'/resources/views/', 'admin');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sla', 'SystemInc\LaravelAdmin\SLA');

        $this->app->singleton(
            'command.laravel-admin.instal',
            function () {
                return new Console\InstalCommand();
            }
        );

        $this->app->singleton(
            'command.laravel-admin.update',
            function () {
                return new Console\UpdateCommand();
            }
        );

        $this->app->singleton(
            'command.laravel-admin.dump',
            function () {
                return new Console\DumpCommand();
            }
        );

        $this->app->singleton(
            'command.laravel-admin.restore',
            function () {
                return new Console\RestoreCommand();
            }
        );

        $this->commands(['command.laravel-admin.instal']);
        $this->commands(['command.laravel-admin.update']);
        $this->commands(['command.laravel-admin.dump']);
        $this->commands(['command.laravel-admin.restore']);

        $this->app->register(\Intervention\Image\ImageServiceProvider::class);
        $this->app->register(\Barryvdh\DomPDF\ServiceProvider::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Image', \Intervention\Image\Facades\Image::class);
        $loader->alias('PDF', \Barryvdh\DomPDF\Facade::class);
    }
}
