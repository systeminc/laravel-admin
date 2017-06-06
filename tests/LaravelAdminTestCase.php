<?php 

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;
use Illuminate\Support\Facades\Schema;

abstract class LaravelAdminTestCase extends Orchestra\Testbench\TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database
    }    
    
    protected function getPackageProviders($app)
    {
        return ['SystemInc\LaravelAdmin\AdminServiceProvider'];
    }

    protected function getPackageAliases($app)
    {
        return [
            'SLA' => SystemInc\LaravelAdmin\Facades\SLA::class,
            'config' => Illuminate\Config\Repository::class
        ];
    }

    public function setUp()
    {
        parent::setUp();

        Schema::defaultStringLength(191);

        Artisan::call('migrate', [
            '--path'  => '../../../../src/database/migrations', 
        ]);
        
        dump(__DIR__.'/../src/database/seeds/DatabaseSeeder.php');

        require_once __DIR__.'/../src/database/seeds/DatabaseSeeder.php';
        $seeder = new \DatabaseSeeder();
        $seeder->run();

        $this->withFactories(__DIR__.'/../src/database/factories');
    }

    public function tearDown()
    {
        Artisan::call('migrate:reset',[
            '--path'  => '../../../../src/database/migrations', 
        ]);

        parent::tearDown();
    }    
}
