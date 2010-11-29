<?php

class BeerballPlayer extends Player {
	protected $beerLevel = 100;
	protected $throws = 0;
	protected $hits = 0;
	
	public function throwBall() {
		$this->increaseThrows();
		if ($hit = $this->getSkill('ThrowingAccuracy') >= rand(1, 100)) $this->increaseHits();
		
		return $hit;
	}
	
	public function runForBall() {
		$time = $this->getActionsResult('RunningSpeed', 3, 7);
		$time += $this->delay() + $time * 0.2 * (rand(0, 1) - 0.5);
		
		return $time;
	}
	
	public function drinkBeer($time) {
		if ($this->hasEmptyBottle()) return 0;
		
		$decrease = $this->getActionsResult('DrinkingSpeed', 0.33, 3.33) * $time;
		$decrease *= $time - $this->delay() - (1 + (-0.5 / 99) * ($this->getSkill('DrinkingSpeed') - 1));
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
	
	protected function increaseHits() {
		$this->setHits($this->getHits() + 1);
	}
	
	protected function increaseThrows() {
		$this->setThrows($this->getThrows() + 1);
	}
}