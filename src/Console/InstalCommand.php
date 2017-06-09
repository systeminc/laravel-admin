<?php

namespace SystemInc\LaravelAdmin\Console;

use Artisan;
use File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use SystemInc\LaravelAdmin\Admin;
use SystemInc\LaravelAdmin\Database\Seeds\DatabaseSeeder as DatabaseSeeder;

class InstalCommand extends Command
{
    protected $name = 'laravel-admin:instal';
    protected $description = 'Instal Laravel Administration Essentials';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-admin:instal {prefix?} {admin?} {email?} {password?}';

    public function handle()
    {
        if (!empty(config('laravel-admin'))) {
            $this->error('Laravel Admin already installed');

            return false;
        }

        $this->line('');
        $this->line('');
        $this->line('');
        $this->line(' ////.           `/////      -/////////:.       -////-   `////.     :///: :///////////  .////       ');
        $this->line(' NNNN/           yNNNNN+     oNNNNNNNNNNNs     `mNNNNN.   yNNNh    .NNNN- yNNNNNNNNNNN  +NNNN       ');
        $this->line(' MMMM/          +NMMdMMN-    oMMMm```+MMMM.    hMMmmMMd`  `mMMN/   hMMMo  yMMMh.......  +MMMN       ');
        $this->line(' MMMM/         -NMMy.NMMd`   oMMMNoosdMMNy    oMMM//MMMs   -NMMm` /NMMh   yMMMNdddddd/  +MMMN       ');
        $this->line(' MMMM/        `mMMN-`oMMMy   oMMMNhNMMMd:    :NMMd..dMMN/   +MMMs`mMMm.   yMMMmyyyyyy:  +MMMN       ');
        $this->line(' MMMM+......  yMMMNmmNMMMN+  oMMMm`.dMMNd-  `mMMMNmmNMMMN.   yMMNhMMN:    yMMMh```````  +MMMN.......');
        $this->line(' MMMMNmmmmmm.+NMMdoooosNMMN- oMMMm  `hMMMm- hMMMyooooyMMMd`  `mMMMMMo     yMMMNmmmmmmm. +MMMMmmmmmmy');
        $this->line(' yyyyyyyyyyy.yyyy-     oyyyo /yyys   `syyys:yyyy`    `yyyy:   -yyyys`     +yyyyyyyyyyy. :yyyyyyyyyyo');
        $this->line('                                                                                                    ');
        $this->line('                                                                                                    ');
        $this->line('                  -////.      ///////:-`     :////:    :////:  `////`  -///-    `///:               ');
        $this->line('                 -NMMMMd`    `MMMMMMMMMMd:   mMMMMM-  -MMMMMm  .MMMM-  yMMMMs   :MMMd               ');
        $this->line('                `mMMmNMMs    `MMMM+::sNMMN:  mMMmMMh  hMMmMMm  .MMMM-  yMMMMMd. :MMMd               ');
        $this->line('                yMMN-sMMM/   `MMMM:   sMMMh  mMMyhMM::MMhyMMm  .MMMM-  yMMMNMMN/:MMMd               ');
        $this->line('               +MMMs `mMMN.  `MMMM:   oMMMd  mMMy-MMddMM-yMMm  .MMMM-  yMMMosMMMdMMMd               ');
        $this->line('              -NMMMMMMMMMMd` `MMMM:  -mMMMs  mMMy hMMMMh yMMm  .MMMM-  yMMM+ :NMMMMMd               ');
        $this->line('             `mMMMsoooodMMMs `MMMMNNNMMMNs   mMMy -MMMM- yMMm  .MMMM-  yMMM+  .hMMMMd               ');
        $this->line('             /yyys     .yyyy.`yyyyyyyso/`    syy+  oyyo  +yys  `yyyy.  +yyy:    oyyyo               ');
        $this->line('                                                                                                    ');
        $this->line('');
        $this->line(' __________________________________________________________________________________________________ ');
        $this->line('');
        $this->line('Configure...');

        $config = require __DIR__.'/../config/laravel-admin.php';

        $prefix = '';

        if (!empty($this->argument('prefix'))) {
            $prefix = trim(preg_replace('/[^a-z-]/', '', $this->argument('prefix')), '-');
        } else {
            while (str_replace('-', '', $prefix) == '') {
                $prefix = $this->ask('Route prefix', $config['route_prefix']);
                $prefix = trim(preg_replace('/[^a-z-]/', '', $prefix), '-');
            }
        }

        $name = !empty($this->argument('admin')) ? $this->argument('admin') : $this->ask('Admin name', 'Admin');

        $email = !empty($this->argument('email')) ? $this->argument('email') : $this->ask('Admin email', 'admin@example.com');

        $password = '';

        if (!empty($this->argument('password'))) {
            $prefix = $this->argument('password');
        } else {
            while (empty($password)) {
                $password = $this->ask('Admin password');
            }
        }

        $config_file = File::get(__DIR__.'/../config/laravel-admin.php');
        $config_file = str_replace($config['route_prefix'], $prefix, $config_file);

        $this->line('Configuration Saved!');
        $this->line('');
        $this->line('***');
        $this->line('');
        $this->line('Migrating...');

        $migrate = Artisan::call('migrate', [
            '--path'  => 'vendor/systeminc/laravel-admin/src/database/migrations',
            '--quiet' => true,
            ]);

        $this->line('Migrating Done!');
        $this->line('');
        $this->line('***');
        $this->line('');
        $this->line('Seeding...');

        Admin::create([
            'name'     => $name,
            'email'    => $email,
            'password' => Hash::make($password),
        ]);

        $seeder = new DatabaseSeeder();
        $seeder->run();

        $this->line('Seeding Done!');
        $this->line('');
        $this->line('***');
        $this->line('');
        $this->line('Publishing...');

        File::put(base_path('config/laravel-admin.php'), $config_file);

        $this->line('Publishing Done!');
        $this->line('');
        $this->line('***');
        $this->line('');
        $this->info('Successfully installed!');
        $this->line(' _________________________________________________________________________________________________ ');
    }
}
