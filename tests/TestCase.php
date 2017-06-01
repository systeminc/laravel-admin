<?php

class TestCase extends Orchestra\Testbench\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        $this->getEnvironmentSetUp($app);
        $this->getPackageProviders($app);
        $this->getPackageAliases($app);

        return $app;
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'mysql',
            'host'     => 'localhost',
            'port'     => '3306',
            'database' => 'laravel-admin-test',
            'username' => 'homestead',
            'password' => 'secret',
            'charset'  => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',            
        ]);
    }    
    
    protected function getPackageProviders($app)
    {
        return ['SystemInc\LaravelAdmin\AdminServiceProvider'];
    }

    protected function getPackageAliases($app)
    {
        return [
            'SLA' => SystemInc\LaravelAdmin\Facades\SLA::class
        ];
    }

    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--path'  => '/vendor/systeminc/laravel-admin/src/database/migrations',
            '--quiet' => true,
        ]);

        $seeder = new DatabaseSeeder();
        $seeder->run(__DIR__.'/../src/database/seeds/DatabaseSeeder.php');

        $this->withFactories(__DIR__.'/../src/database/factories');
    }

    public function testAplicationTests()
    {
    	$this->assertTrue(true);
    }
}
