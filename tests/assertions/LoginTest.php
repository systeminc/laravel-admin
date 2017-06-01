<?php 

use SystemInc\LaravelAdmin\Admin;

class LoginTest extends TestCase
{
    public function testRedirectToLogin()
    {
        $this->visit('/administration')
        	->seePageIs('/administration/login');
    }

    public function testLoginFailEmptyPost()
    {
        $this->visit('/administration')
        	->seePageIs('/administration/login')
        	->makeRequest('post', '/administration/login')
        	->seePageIs('/administration/login');
    }

    public function testLoginFailWrongPassword()
    {
    	$admin = factory(SystemInc\LaravelAdmin\Admin::class)->create();

        $this->visit('/administration')
        	->seePageIs('/administration/login')
        	->makeRequest('post', '/administration/login', ['email' => $admin->email, 'password' => 'secret123'])
        	->seePageIs('/administration/login');
    }

    public function testLoginFailWrongEmail()
    {
    	$admin = factory(SystemInc\LaravelAdmin\Admin::class)->create();

        $this->visit('/administration')
        	->seePageIs('/administration/login')
        	->makeRequest('post', '/administration/login', ['email' => 'ascaf@lll.com', 'password' => 'secret'])
        	->seePageIs('/administration/login');
    }

    public function testLogin()
    {
    	$admin = factory(SystemInc\LaravelAdmin\Admin::class)->create();

        $this->visit('/administration')
        	->seePageIs('/administration/login')
        	->makeRequest('post', '/administration/login', ['email' => $admin->email, 'password' => 'secret'])
        	->seePageIs('/administration');
    }
}