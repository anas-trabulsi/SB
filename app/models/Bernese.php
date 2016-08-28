<?php
class Bernese extends Dog{
	private $likeToBeGroomed = false;
	private $tailColor = "";
	protected function __construct($params){
		parent::__construct($params);
		if (isset($params->like_to_be_groomed)){
			$this->likeToBeGroomed = $params->like_to_be_groomed;
		}
		if (isset($params->tail_color)){
			$this->tailColor = $params->tail_color;
		}
	}
	public function getLikeToBeGroomed(){return $this->likeToBeGroomed;}
	public function setLikeToBeGroomed($v){$this->likeToBeGroomed = $v;}
	
	public function getTailColor(){return $this->tailColor;}
	public function setTailColor($v){$this->tailColor = $v;}
	
	public function toArray(){
		$array = parent::toArray();
		$array["like_to_be_groomed"] = $this->getLikeToBeGroomed();
		$array["tail_color"] = $this->getTailColor();
		return $array;
	}
	public function getBreed(){
		return "Bernese Mountain Dog";
	}
}
