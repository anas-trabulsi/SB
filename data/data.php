<?php
class DatabaseSimulator{
	public static function getData(){
		$date = new DateTime();
		
		$array = array();
		$array[] = array("id" => 1, "breed" => "Chihuahua", "hair_color" => "white", "last_fed" => null, "has_straight_ears" => true);
		$array[] = array("id" => 2, "breed" => "Chihuahua", "hair_color" => "black", "last_fed" => $date->format("Y-m-d H:i:s"), "has_straight_ears" => true);
		$array[] = array("id" => 3, "breed" => "Chihuahua", "hair_color" => "white", "last_fed" => null, "has_straight_ears" => false);
		
		$date->sub(new DateInterval('PT2H'));
		$array[] = array("id" => 4, "breed" => "Chihuahua", "hair_color" => "brown", "last_fed" => $date->format("Y-m-d H:i:s"), "has_straight_ears" => true);
		
		$date->sub(new DateInterval('PT3H'));
		$array[] = array("id" => 5, "breed" => "Chihuahua", "hair_color" => "gray", "last_fed" => $date->format("Y-m-d H:i:s"), "has_straight_ears" => false);
		
		$array[] = array("id" => 6, "breed" => "Bernese", "hair_color" => "white", "last_fed" => null, "like_to_be_groomed" => true, "tail_color" => "black");
		$array[] = array("id" => 7, "breed" => "Bernese", "hair_color" => "black", "last_fed" => $date->format("Y-m-d H:i:s"), "like_to_be_groomed" => false, "tail_color" => "black");
		$array[] = array("id" => 8, "breed" => "Bernese", "hair_color" => "white", "last_fed" => null, "like_to_be_groomed" => true, "tail_color" => "white");
		
		$date->add(new DateInterval('PT2H'));
		$array[] = array("id" => 9, "breed" => "Bernese", "hair_color" => "brown", "last_fed" => $date->format("Y-m-d H:i:s"), "like_to_be_groomed" => false, "tail_color" => "white");
		
		return json_encode($array);
	}
}
