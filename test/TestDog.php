<?php
require_once 'PHPUnit/Autoload.php';
require_once __DIR__ . "/../app/models/Dog.php";
require_once __DIR__ . "/../app/models/ToBeWalked.php";
require_once __DIR__ . "/../data/data.php";
require_once __DIR__ . "/../locale/Captions.php";

class TestDog extends PHPUnit_Framework_TestCase{
	public function testFirstTest(){
		$this->assertTrue(true, "testing 1");
	}
	
	public function testSecondTest(){
		$this->assertFalse(false, "testing 2");
	}
}
