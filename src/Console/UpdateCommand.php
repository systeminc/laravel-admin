<?php

namespace SystemInc\LaravelAdmin\Console;

use Artisan;
use File;
use Illuminate\Console\Command;

class UpdateCommand extends Command
{
    protected $name = 'laravel-admin:update';
    protected $description = 'Update Laravel Administration Essentials';

    public function handle()
    {
        if (empty(config('laravel-admin'))) {
            $this->error('Instal first Laravel Admin with laravel-admin:instal');

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
        $this->line('Migrating...');

        $migrate = Artisan::call('migrate', [
            '--path'  => 'vendor/systeminc/laravel-admin/src/database/migrations',
            '--quiet' => true,
            ]);

        $this->line('Migrating Done!');
        $this->line('');
        $this->line('***');
        $this->line('');
        $this->line('Updating Configuration...');

        $package_config = require __DIR__.'/../config/laravel-admin.php';
        $client_config = require base_path('config/laravel-admin.php');

        $replaceConfig = array_replace_recursive(require __DIR__.'/../config/laravel-admin.php', config('laravel-admin'));

        foreach ($package_config as $key => $value) {
            if (!isset($client_config[$key])) {
                File::put(base_path('config/laravel-admin.php'), ("<?php \r\n\r\nreturn ".preg_replace(['/$([ ])/', '/[ ]([ ])/'], '	', var_export($replaceConfig, true)).';'));
                $this->info('Config file ("config/laravel-admin.php") is merged, please see changes for new feature');
            }
        }

        $this->line('Updating Configuration Done!');
        $this->line('');
        $this->line('***');
        $this->line('');
        $this->info('Successfully update!');
        $this->line(' _________________________________________________________________________________________________ ');
    }
}
