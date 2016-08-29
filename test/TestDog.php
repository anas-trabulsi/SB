<?php
require_once __DIR__ . "/../app/models/Dog.php";
require_once __DIR__ . "/../app/models/ToBeWalked.php";
require_once __DIR__ . "/../data/data.php";
require_once __DIR__ . "/../locale/Captions.php";

class TestDog extends PHPUnit_Framework_TestCase{
	public function testAddingGenericDog(){
		$attributes = new stdClass();
		$attributes->id = 1;
		$attributes->breed = "Some breed that is not supported";
		$attributes->hair_color = "white";
		$attributes->last_fed = null;
		$dog = Dog::factory($attributes);
		
		$this->assertEquals(Captions::GENERIC_DOG, $dog->getBreed(), "The dog should be a generic dog because the breed is not supported");
		$this->assertEquals("white", $dog->getHairColor(), "The dog hair color should be white, because we just set it to white");
		$this->assertTrue($dog->isHungry(), "The dog should be hungry because he was never fed");
		$this->assertTrue($dog->isBarking(), "The dog should bark because he's hungry");
		
		try{
			$dog->executeAction("feed");
			$this->assertFalse($dog->isHungry(), "The dog should not be hungry because we just fed him");
		}
		catch (Exception $e){
			$this->assertEquals(Captions::NO_FOOD_LEFT, $e->getMessage(), "The feed method did not work. It threw an exception, but that is OK, it is supposed to do that 25% of the times");
		}
	}
	public function testAddingChihuahua(){
		$date = new DateTime();
		$attributes = new stdClass();
		$attributes->id = 1;
		$attributes->breed = "Chihuahua";
		$attributes->hair_color = "black";
		$attributes->last_fed = $date->format("Y-m-d H:i:s");//We just fed the dog, it shouldn't be hungry now
		$attributes->has_straight_ears = true;
		
		$dog = Dog::factory($attributes);
		$this->assertEquals(Captions::CHIHUAHUA, $dog->getBreed(), "The dog should be Chihuahua");
		$this->assertEquals("black", $dog->getHairColor(), "The dog hair color should be black, because we just set it to black");
		$this->assertFalse($dog->isHungry(), "The dog should not be hungry because we just fed him");
		$this->assertTrue($dog->getHasStraightEars(), "The dog should have stright ears");
		$this->assertFalse($dog->isExcited(), "The dog should not be excited because we never pet him");
		
		try{
			$dog->executeAction("pet");
			$this->assertTrue($dog->isExcited(), "The dog should be excited because we just petted him");
		}
		catch (Exception $e){
			$this->assertEquals(Captions::DOG_BIT_HAND, $e->getMessage(), "The pet method did not work. It threw an exception, but that is OK, it is supposed to do that 25% of the times");
		}
	}
	public function testAddingBernese(){
		$date = new DateTime();
		$attributes = new stdClass();
		$attributes->id = 1;
		$attributes->breed = "Bernese";
		$attributes->hair_color = "gray";
		$attributes->like_to_be_groomed = true;
		
		$dog = Dog::factory($attributes);
		$this->assertEquals(Captions::BERNESE_MOUNTAIN_DOG, $dog->getBreed(), "The dog should be Bernese Mountain Dog");
		$this->assertEquals("gray", $dog->getHairColor(), "The dog hair color should be black, because we just set it to black");
		$this->assertTrue($dog->getLikeToBeGroomed(), "The dog should like to be groomed");
		$dog->executeAction("playWith");
	}
}
