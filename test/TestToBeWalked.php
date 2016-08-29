<?php
require_once __DIR__ . "/../app/models/Dog.php";
require_once __DIR__ . "/../app/models/ToBeWalked.php";
require_once __DIR__ . "/../data/data.php";
require_once __DIR__ . "/../locale/Captions.php";

class TestToBeWalked extends PHPUnit_Framework_TestCase{
	public function testWalkingADog(){
		$attributes = new stdClass();
		$attributes->id = 1;
		$attributes->breed = "Bernese";
		$dog = Dog::factory($attributes);
		
		$toBeWalked = new ToBeWalked();
		$this->assertFalse($toBeWalked->hasBeenWalked($dog), "This dog was never walked");
		
		try{
			$result = $toBeWalked->walk($dog);
			$this->assertTrue($result, "This dog was walked successfully");
		}
		catch (Exception $e){
			$this->assertEquals(Captions::CANNOT_WALK_DOG, $e->getMessage(), "The walk method did not work. It threw an exception, but that is OK, it is supposed to do that 25% of the times");
		}
	}
}
