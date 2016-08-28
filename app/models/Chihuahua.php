<?php
class Chihuahua extends Dog{
	private $hasStraightEars = false;
	private $lastTimeDogWasPetted = null;
	protected function __construct($params){
		parent::__construct($params);
		if (isset($params->has_straight_ears)){
			$this->hasStraightEars = $params->has_straight_ears;
		}
		if (isset($params->last_time_dog_was_petted)){
			$this->lastTimeDogWasPetted = new DateTime($params->last_time_dog_was_petted);
		}
	}
	public function getHasStraightEars(){return $this->hasStraightEars;}
	public function setHasStraightEars($v){$this->hasStraightEars = $v;}
	
	public function toArray(){
		$array = parent::toArray();
		$array["has_straight_ears"] = $this->getHasStraightEars();
		$array["is_excited"] = $this->isExcited();
		return $array;
	}
	public function getBreed(){
		return Captions::CHIHUAHUA;
	}
	
	/**
	 * @return string
	 * This method returns the details view file
	 * When inheriting this class, each one of the sub classes can add additional details to be displayed to the user in the "Details" section
	 * The default view file is details.html. The sub classes can override that value and define their own way to display the details
	 */
	public function viewDetailsFile(){
		return "breeds/chihuahua.html";
	}
	
	public function getAvailableActions(){
		$actions = parent::getAvailableActions();
		if (isset($actions["walk"])){//We don't walk Chihuahua dogs!
			unset($actions["walk"]);
		}
		$actions["pet"] = Captions::PET;
		return $actions;
	}
	
	protected function pet(){
		//To be able to test the error handling, we'll throw an exception 25% of the times, indicating that the dog has bitten our hand
		if (mt_rand(0,3) == 1){
			throw new Exception(Captions::DOG_BIT_HAND);
		}
		$this->lastTimeDogWasPetted = new DateTime();
		return true;
	}
	
	/**
	 * @return boolean
	 * This method returns true if the dog has been petted in the last hour, and false otherwise
	 */
	protected function isExcited(){
		if ($this->lastTimeDogWasPetted === null){//This dog has never been petted
			return false;
		}
		$now = new DateTime();
		$diff = $now->diff($this->lastTimeDogWasPetted);
		$hours = $diff->h + $diff->days * 24;
		return $hours <= 1;
	}
}
