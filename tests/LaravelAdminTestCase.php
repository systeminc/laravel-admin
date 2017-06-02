<?php 

abstract class LaravelAdminTestCase extends \PHPUnit_Framework_TestCase
{
	public $faker = "";

	protected function setUp()
    {
    	require_once 'vendor/fzaninotto/faker/src/autoload.php';
    	$this->faker = Faker\Factory::create();
    }
}