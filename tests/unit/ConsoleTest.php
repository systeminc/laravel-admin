<?php

namespace SystemInc\LaravelAdmin\Tests\Unit;

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
}
