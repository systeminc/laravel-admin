<?php

namespace SystemInc\LaravelAdmin\Console;

use Artisan;
use Illuminate\Console\Command;

class InstalCommand extends Command
{
    protected $name = 'laravel-admin:instal';
    protected $description = 'Instal Laravel Administration Essentials';

    public function handle()
    {        
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


        $prefix = $this->ask('Route prefix', $this->laravel->app->config['laravel-admin']['route_prefix']);
        
        $email = $this->ask('Admin email', $this->laravel->app->config['laravel-admin']['email']);

        $pass = $this->ask('Admin password', $this->laravel->app->config['laravel-admin']['password']);


		$this->line('Configuration Saved!');
		$this->line('');
		$this->line('***');
        $this->line('');
        $this->line('Migrating...');
		$this->line('');

        $migrate = Artisan::call('migrate', [
        	'--path' => 'vendor/systeminc/laravel-admin/src/database/migrations',
        	'--quiet' => true,
        	]);

		$this->line('Migrating Done!');
		$this->line('');
		$this->line('***');
        $this->line('');
        $this->line('Seeding...');
		$this->line('');
        
        require __DIR__.'/../database/seeds/DatabaseSeeder.php';
        // $seeding = Artisan::call('db:seed', [
        // 	'--class' => \DatabaseSeeder::class,
        // 	'--quiet' => true,
        // 	]);

		$this->line('Seeding Done!');
		$this->line('');
		$this->info('Successfully installed!');
		$this->line(' _________________________________________________________________________________________________ ');
        
    }
}
