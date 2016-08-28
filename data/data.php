<?php
class DatabaseSimulator{
	public static function getData(){
		$date = new DateTime();
		
		$array = array();
		$array[] = array("id" => 1, "breed" => "Chihuahua", "hair_color" => "white", "last_fed" => null, "has_straight_ears" => true, "last_time_dog_was_petted" => null);
		$array[] = array("id" => 2, "breed" => "Chihuahua", "hair_color" => "black", "last_fed" => $date->format("Y-m-d H:i:s"), "has_straight_ears" => true, "last_time_dog_was_petted" => $date->format("Y-m-d H:i:s"));
		$array[] = array("id" => 3, "breed" => "Chihuahua", "hair_color" => "white", "last_fed" => null, "has_straight_ears" => false, "last_time_dog_was_petted" => $date->format("Y-m-d H:i:s"));
		
		$date->sub(new DateInterval('PT2H'));
		$array[] = array("id" => 4, "breed" => "Chihuahua", "hair_color" => "brown", "last_fed" => $date->format("Y-m-d H:i:s"), "has_straight_ears" => true, "last_time_dog_was_petted" => null);
		
		$date->sub(new DateInterval('PT3H'));
		$array[] = array("id" => 5, "breed" => "Chihuahua", "hair_color" => "gray", "last_fed" => $date->format("Y-m-d H:i:s"), "has_straight_ears" => false, "last_time_dog_was_petted" => null);
		
		$array[] = array("id" => 6, "breed" => "Bernese", "hair_color" => "white", "last_fed" => null, "like_to_be_groomed" => true, "tail_color" => "black");
		$array[] = array("id" => 7, "breed" => "Bernese", "hair_color" => "black", "last_fed" => $date->format("Y-m-d H:i:s"), "like_to_be_groomed" => false, "tail_color" => "black");
		$array[] = array("id" => 8, "breed" => "Bernese", "hair_color" => "white", "last_fed" => null, "like_to_be_groomed" => true, "tail_color" => "white");
		
		$date->add(new DateInterval('PT2H'));
		$array[] = array("id" => 9, "breed" => "Bernese", "hair_color" => "brown", "last_fed" => $date->format("Y-m-d H:i:s"), "like_to_be_groomed" => false, "tail_color" => "white");
		
		return json_encode($array);
	}

	public static function getToBeWalkedData(){
		$date = new DateTime();
		
		/*
		 * Dogs with IDS 6 and 7 were walked twice, once now and once two days ago
		 * but dogs with IDs 8 and 9 were only walked two days ago
		 */
		$array = array();
		$array[] = array("id" => 1, "dog_id" => 6, "walk_time" => $date->format("Y-m-d H:i:s"));
		$array[] = array("id" => 2, "dog_id" => 7, "walk_time" => $date->format("Y-m-d H:i:s"));
		
		$date->sub(new DateInterval('P2D'));
		$array[] = array("id" => 3, "dog_id" => 6, "walk_time" => $date->format("Y-m-d H:i:s"));
		$array[] = array("id" => 4, "dog_id" => 7, "walk_time" => $date->format("Y-m-d H:i:s"));
		$array[] = array("id" => 5, "dog_id" => 8, "walk_time" => $date->format("Y-m-d H:i:s"));
		$array[] = array("id" => 6, "dog_id" => 9, "walk_time" => $date->format("Y-m-d H:i:s"));
		return json_encode($array);
	}
}
