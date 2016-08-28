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
}
