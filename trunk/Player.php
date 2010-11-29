<?php

class Player {
	protected $skills;
	protected $number;
	
	public function __construct($skills = NULL) {
		if (is_array($skills)) $this->setSkills($skills);
	}
	
	public function delay() {
		$delay = 1 - 0.0091 * ($this->getSkill('ReactionTime') - 1);
		$delay += $delay * 0.2 * (rand(0, 1) - 0.5);
		return $delay;
	}
	
	public function getSkills() {
		return $this->skills;
	}
	
	public function getSkill($skill) {
		return isset($this->skills[$skill]) ? $this->skills[$skill] : NULL;
	}
	
	public function getNumber() {
		return $this->number;
	}
	
	public function setSkills($skills) {
		$this->skills = $skills;
	}
	
	public function setSkill($skill, $value) {
		$this->skills[$skill] = $value;
	}
	
	public function setNumber($number) {
		$this->number = $number;
	}
}