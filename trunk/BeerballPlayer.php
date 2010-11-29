<?php

class BeerballPlayer extends Player {
	protected $beerLevel = 100;
	protected $numberThrows = 0;
	protected $numberHits = 0;
	
	public function throwBall() {
		$this->increaseNumberThrows();
		if ($success = $this->getSkill('ThrowingAccuracy') / 100 >= rand(0, 1)) $this->increaseNumberHits();
		return $success;
	}
	
	public function runForBall() {
		$time = 7 - 0.0404 * ($this->getSkill('RunningSpeed') - 1);
		$time += $this->delay() + $time * 0.2 * (rand(0, 1) - 0.5);
		return $time;
	}
	
	public function drinkBeer($time) {
		if ($this->hasEmptyBottle()) return 0;
		
		$time = $time - $this->delay() - (1 + (-0.5 / 99) * ($this->getSkill('DrinkingSpeed') - 1));
		$decrease = 3.33 + 0.0786 * ($this->getSkill('DrinkingSpeed') - 1) * $time;
		$decrease *= 0.5 + $this->getBeerLevel() / 100;
		
		$this->decreaseBeerLevel($decrease);
		return $decrease;
	}
	
	public function hasEmptyBottle() {
		return $this->getBeerLevel() <= 0;
	}
	
	protected function decreaseBeerLevel($amount) {
		$this->setBeerLevel($this->getBeerLevel() - $amount);
	}
	
	protected function increaseNumberHits() {
		$this->setNumberHits($this->getNumberHits() + 1);
	}
	
	protected function increaseNumberThrows() {
		$this->setNumberThrows($this->getNumberThrows() + 1);
	}
}