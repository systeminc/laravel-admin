<?php

namespace SystemInc\LaravelAdmin\Console;

use Artisan;
use File;
use Illuminate\Console\Command;
use SystemInc\LaravelAdmin\Traits\HelpersTrait;

class UpdateCommand extends Command
{
    use HelpersTrait;

    protected $name = 'laravel-admin:update';
    protected $description = 'Update Laravel Administration Essentials';

    public function handle()
    {
        if (empty(config('laravel-admin'))) {
            $this->error('First instal Laravel Admin with laravel-admin:instal');

            return false;
        }

        $this->consoleSignature();

        $this->line('Migrating...');

        $migrate = Artisan::call('migrate', [
            '--path' => 'vendor/systeminc/laravel-admin/src/database/migrations',
            ]);

        $this->line('Migration Done!');
        $this->line('');
        $this->line('***');
        $this->line('');
        $this->line('Updating Configuration...');

        $package_config = require __DIR__.'/../config/laravel-admin.php';
        $client_config = require base_path('config/laravel-admin.php');

        $replaceConfig = array_replace_recursive(require __DIR__.'/../config/laravel-admin.php', config('laravel-admin'));

        foreach ($package_config as $key => $value) {
            if (!isset($client_config[$key])) {
                File::put(base_path('config/laravel-admin.php'), ("<?php \r\n\r\nreturn ".preg_replace(['/$([ ])/', '/[ ]([ ])/'], '    ', var_export($replaceConfig, true)).';'));
                $this->info('Config file ("config/laravel-admin.php") is merged, please see changes for new feature');
            }
        }

        $this->line('Updating Configuration Done!');
        $this->line('');
        $configureFolder = Artisan::call('storage:link', []);
        $this->line('***');
        $this->line('');
        $this->info('Successfully update!');
        $this->line(' _________________________________________________________________________________________________ ');
    }
}
