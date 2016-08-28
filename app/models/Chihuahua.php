<?php
class Chihuahua extends Dog{
	private $hasStraightEars = false;
	protected function __construct($params){
		parent::__construct($params);
		if (isset($params->has_straight_ears)){
			$this->hasStraightEars = $params->has_straight_ears;
		}
	}
	public function getHasStraightEars(){return $this->hasStraightEars;}
	public function setHasStraightEars($v){$this->hasStraightEars = $v;}
	
	public function toArray(){
		$array = parent::toArray();
		$array["has_straight_ears"] = $this->getHasStraightEars();
		return $array;
	}
	public function getBreed(){
		return "Chihuahua";
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
}
