<?php
/**
 * This class uses the factory design pattern
 * To instantiate an object of type Dog, we should pass the attributes variable which contains the breed of the dog, and potentially, other attributes (e.g. id, hair color, etc)
 * We want to support only two breeds for now, which are Chihuahua AND Bernese
 */
class Dog{
	private static $supportedBreeds = array();//Those are the only two supported breeds for now, we can simply add another one (Beagle)
	private $id = null;
	private $hairColor = "";//Instead of using a public attribute for the hair color, we'll use a private attribute with public getters and setters
	private $lastFed = null;
	const FEEDING_FREQUENCY = 4;//This means the dog will feel hungy if we don't feed him once every 4 hours
	
	public static function addSupportedBreeds(){
		self::$supportedBreeds = array("Chihuahua", "Bernese");
		foreach (self::$supportedBreeds as $oneBreedType){
			require_once __DIR__ . "/{$oneBreedType}.php";
		}
	}
	
	/************Getters and Setters Start************/
	public function getId(){return $this->id;}
	public function setId($v){$this->id = $v;}
	
	public function getHairColor(){return $this->hairColor;}
	public function setHairColor($v){$this->hairColor = $v;}
	/************Getters and Setters End************/
	/************Constructor and Factory Start************/
	protected function __construct($params){
		if (isset($params->id)){
			$this->id = $params->id;
		}
		if (isset($params->hair_color)){
			$this->hairColor = $params->hair_color;
		}
		if (isset($params->last_fed)){
			$this->lastFed = $params->last_fed;
		}
	}
	
	public static function factory($attributes){
		$breed = isset($attributes->breed) ? $attributes->breed : "";
		//If $breed is empty, or if it is not supported, we'll simply use a generic Dog object
		if (in_array($breed, self::$supportedBreeds)){
			return new $breed($attributes);
		}
		else{
			return new Dog($attributes);
		}
	}
	
	/**
	 * @return Dog[]
	 * This method returns all the dogs in the database (the file data/data.php simulates a database table for now. It returns JSON for the tables representation)
	 * This method calls the factory method. So it returns an array of Dog, or its subclasses
	 */
	public static function getAllDogs(){
		$json = DatabaseSimulator::getData();
		$data = json_decode($json);
		$array = array();
		foreach ($data as $oneRow){
			$array[] = self::factory($oneRow);
		}
		return $array;
	}
	/************Constructor and Factory End************/
	/************Dog Methods Start************/
	
	/**
	 * @return boolean
	 * This method returns true if the dog is barking. The dog will bark if he's hungry, or 50% chance when he's not 
	 */
	public function isBarking(){
		if ($this->isHungry()){
			return true;
		}
		return mt_rand(0,1) == 1;
	}
	
	/**
	 * @return boolean
	 * This method returns true if the dog is hungry. The dog will be hungry if he has not been fed in the last (FEEDING_FREQUENCY) hours 
	 */
	public function isHungry(){
		if ($this->lastFed === null){//This dog has never been fed
			return true;
		}
		$now = new DateTime();
		$diff = $now->diff($this->lastFed);
		$hours = $diff->h + $diff->days * 24;
		return $hours >= self::FEEDING_FREQUENCY;
	}
	
	/**
	 * @return void
	 * This method feeds the dog (it sets the "lastFed" attribute to the time now) 
	 */
	public function feed(){
		$this->lastFed = new DateTime();
	}
	/************Dog Methods End************/
	
	/**
	 * This method converts the attributes of the Dog object to array
	 */
	public function toArray(){
		return array("id" => $this->getId(), "hair_color" => $this->getHairColor(), "breed" => $this->getBreed());
	}
	public function getBreed(){
		return "Generic Dog";
	}
}
Dog::addSupportedBreeds();
