<?php

namespace SystemInc\LaravelAdmin\Console;

use File;
use Illuminate\Console\Command;
use SystemInc\LaravelAdmin\Traits\HelpersTrait;

class RestoreCommand extends Command
{
    use HelpersTrait;

    protected $name = 'laravel-admin:restore-database';
    protected $description = 'Drop DB and restore latest backup';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-admin:restore-database';

    public function handle()
    {
        if (empty(config('laravel-admin'))) {
            $this->error('First install Laravel Admin with laravel-admin:install');

            return false;
        }

        $this->consoleSignature();

        $path = app_path('../database/sla_dumps');

        $migrations = array_sort(File::allFiles($path), function ($file) {
            return $file->getFilename();
        });

        if (count($migrations) == 0) {
            $this->error('No migrations in: '.$path);

            $this->consoleLastLine();
        } else {
            $latest_migration = end($migrations);

            $this->info('Latest migration is: '.$latest_migration->getFilename());

            $proceed = $this->ask('Database will be droped! Do you want to proceed?', 'No');
            $this->isInArray($proceed);

            $drop = $this->ask('Drop database and restore latest migration?', 'No');
            $this->isInArray($drop);

            $this->info('You will be prompted for MySQL database password for three actions.');

            $db_table = env('DB_DATABASE');

            $this->line('Collecting tables...');
            $this->line('');
            exec('mysql -u '.env('DB_USERNAME').' -p --silent --skip-column-names -e "SHOW TABLES" '.$db_table, $tables, $response);

            if ($response != 0) {
                $this->error('Mysql Error');

                $this->consoleLastLine();
            }

            $this->line('');
            $this->line('Collecting tables done');

            $query = '';

            foreach ($tables as $key => $value) {
                $query .= 'SET FOREIGN_KEY_CHECKS = 0; DROP TABLE `'.$value.'`; SET FOREIGN_KEY_CHECKS = 1;';
            }

            $this->line('');
            $this->line('Dropping...');
            $this->line('');
            exec('mysql -u '.env('DB_USERNAME').' -p -v '.$db_table." -e '".$query."'", $output, $response2);

            if ($response2 != 0) {
                $this->error('Mysql Error');

                $this->consoleLastLine();
            }

            $this->line('');
            $this->line('Dropping done');

            $this->line('');
            $this->line('Restoring database...');
            $this->line('');
            exec('mysql -u '.env('DB_USERNAME').' -p '.$db_table.' < '.$latest_migration->getRealPath(), $output, $response3);

            if ($response3 != 0) {
                $this->error('Mysql Error');

                $this->consoleLastLine();
            }

            $this->line('');
            $this->line('Restored');

            $this->consoleLastLine();
        }
    }

    private function consoleLastLine()
    {
        $this->line('');
        $this->line('***');
        $this->line('');
        $this->info('Done!');
        $this->line(' _________________________________________________________________________________________________ ');

        exit;
    }

    private function isInArray($value)
    {
        $needle = in_array(strtolower($value), ['y', 'yes']);

        if (!$needle) {
            $this->consoleLastLine();

            exit;
        }
    }
}
