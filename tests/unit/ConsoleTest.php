<?php

namespace SystemInc\LaravelAdmin\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use SystemInc\LaravelAdmin\Tests\LaravelAdminTestCase;

class ConsoleTest extends LaravelAdminTestCase
{
    public function tearDown()
    {
        parent::tearDown();
    }

    public function testInstall()
    {
        $this->assertTrue(0 < $this->artisan('laravel-admin:instal', ['prefix' => 'administration', 'admin' => 'admin', 'email' => 'admin@example.com', 'password' => '123']));
    }
    
    public function testUpdate()
    {
		Artisan::call('laravel-admin:update');
		$console_output = trim( Artisan::output() );

        $this->assertEquals('Instal first Laravel Admin with laravel-admin:instal', $console_output);
    }
}