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
	
	/**
	 * @return string
	 * This method returns the details view file
	 * When inheriting this class, each one of the sub classes can add additional details to be displayed to the user in the "Details" section
	 * The default view file is details.html. The sub classes can override that value and define their own way to display the details
	 */
	public function viewDetailsFile(){
		return "breeds/bernese.html";
	}
}