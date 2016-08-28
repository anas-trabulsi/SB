<?php
/**
 * Te class diagram shows that class Dog depends on class ToBeWalked, however, I think it should be the opposite where class ToBeWalked depends on class Dog, not the other way around
 * The reason is that class ToBeWalked needs to know which particular dog to walk, which implies that it depends on class Dog
 * As for class Dog, it does not need to know anything about class ToBeWalked, because the walk method is declared in class ToBeWalked
 * 
 * However, to make the system simpler, the methods hasBeenWalked, and walk were added to class Dog 
 * The only reason is so that we use the same logic when calling the actions from the GUI
 * So that we don't have to build another interface for the ToBeWalked list
 * This means that both classes depend on each other
 */
class ToBeWalked{
	const WALK_FREQUENCY = 24;//This means dogs should be walked once every 24 hours
	private function getDogLastWalk(Dog $dog){
		$json = DatabaseSimulator::getToBeWalkedData();
		$data = json_decode($json);
		$lastWalk = null;
		foreach ($data as $oneRow){
			if ($oneRow->dog_id == $dog->getId()){
				$walkTime = new DateTime($oneRow->walk_time);
				if ($lastWalk === null || $lastWalk < $walkTime){
					$lastWalk = $walkTime;
				}
			}
		}
		return $lastWalk;
	}
	public function walk(Dog $dog){
		//To be able to test the error handling, we'll throw an exception 25% of the times, indicating that we don't have enough food
		if (mt_rand(0,3) == 1){
			throw new Exception(Captions::CANNOT_WALK_DOG);
		}
		return true;
	}
	
	public function hasBeenWalked(Dog $dog){
		$lastWalk = $this->getDogLastWalk($dog);
		if ($lastWalk === null){//This dog has never been walked
			return false;
		}
		$now = new DateTime();
		$diff = $now->diff($lastWalk);
		$hours = $diff->h + $diff->days * 24;
		return $hours <= self::WALK_FREQUENCY;
	}
	
}
