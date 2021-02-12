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
            $this->error('No database dumps in: ' . $path);
            $this->consoleLastLine();
        } else {
            $latest_migration = end($migrations);

            $this->info('Latest database dump is: ' . $latest_migration->getFilename());

            $proceed = $this->ask('Database will be droped! Do you want to proceed?', 'No');
            $this->exitIfRejected($proceed);

            $drop = $this->ask('Drop database and restore latest database dump?', 'No');
            $this->exitIfRejected($drop);

            $this->info('You will be prompted for MySQL database password for three actions.');
            $this->line('');

            $tables = $this->collectTables();

            $this->dropTables($tables);

            $this->restoreTables($latest_migration);

            $this->consoleLastLine();
        }

        exit;
    }

    private function collectTables()
    {
        $this->line('Collecting tables...');

        exec('mysql -u ' . env('DB_USERNAME') . ' -p' . env('DB_PASSWORD') . ' --silent --skip-column-names -e "SHOW TABLES" ' . env('DB_DATABASE') . " 2>/dev/null", $tables, $response);

        if ($response != 0) {
            $this->error('Mysql Error');
            $this->consoleLastLine();
        }

        $this->line('Collecting tables done');
        $this->line('');

        return $tables;
    }

    private function dropTables($tables)
    {
        $this->line('Dropping...');

        $query = [];

        foreach ($tables as $key => $value) {
            $query[] = 'SET FOREIGN_KEY_CHECKS = 0; DROP TABLE `' . $value . '`; SET FOREIGN_KEY_CHECKS = 1;';
        }

        exec('mysql -u ' . env('DB_USERNAME') . ' -p' . env('DB_PASSWORD') . ' -v ' . env('DB_DATABASE') . " -e '" . implode('', $query) . "' 2>/dev/null", $output, $response);

        if ($response != 0) {
            $this->error('Mysql Error');
            $this->consoleLastLine();
        }

        $this->line('Dropping done');
        $this->line('');
    }

    private function restoreTables($migration)
    {
        $this->line('Restoring database...');

        exec('mysql -u ' . env('DB_USERNAME') . ' -p' . env('DB_PASSWORD') . ' ' . env('DB_DATABASE') . ' < ' . $migration->getRealPath() . ' 2>/dev/null', $output, $response);

        if ($response != 0) {
            $this->error('Mysql Error');
            $this->consoleLastLine();
        }

        $this->line('Restored');
        $this->line('');
    }

    private function consoleLastLine()
    {
        $this->info('Done!');
        $this->line('');
    }

    private function exitIfRejected($value)
    {
        $needle = in_array(strtolower($value), ['y', 'yes']);

        if (!$needle) {
            $this->consoleLastLine();
            exit;
        }
    }
}
