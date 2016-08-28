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
	
	/**
	 * @param Array $attributes
	 * @return Dog
	 * This method returns an object of type Dog or of its subclasses (Chihuahua or Bernese)
	 * The attributes argument is an stdClass, it may have an attribute  `breed`. If it does not have the attribute `breed", the method will return a generic `Dog` object
	 * If it has the attribute `breed`, but its value is not supported by our system yet (meaning it is not Chihuahua or Bernese), it will also return a generic `Dog` object
	 * If it has the attribute `breed` and it is supported by our system, the method will return an object of the corresponding subclass
	 */
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
		return array("id" => $this->getId(),
					"hair_color" => $this->getHairColor(),
					"breed" => $this->getBreed(),
					"is_barking" => $this->isBarking(),
					"is_hungry" => $this->isHungry(),
		);
	}
	public function getBreed(){
		return "Generic Dog";
	}
	
	/**
	 * @return string
	 * This method returns the details view file
	 * When inheriting this class, each one of the sub classes can add additional details to be displayed to the user in the "Details" section
	 * The default view file is details.html. The sub classes can override that value and define their own way to display the details
	 */
	public function viewDetailsFile(){
		return "details.html";
	}
	
	/**
	 * This method will return the Dog object based on its ID.
	 * Since we don't have a database, we'll simply search in ALL the records for the right ID, and then use the factory method on it.
	 * @return Dog|NULL
	 */
	public static function loadById($id){
		//Usually, we'll use the mysqli::real_escape_string to escape the $id value, or use prepared statements, to prevent SQL injection
		//For now, we'll just use the (int) method
		$id = (int)$id;
		$json = DatabaseSimulator::getData();
		$data = json_decode($json);
		$array = array();
		foreach ($data as $oneRow){
			if ($oneRow->id == $id){
				return self::factory($oneRow);
			}
		}
		return null;
	}
}
Dog::addSupportedBreeds();
