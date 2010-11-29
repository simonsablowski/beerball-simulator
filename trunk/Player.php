<?php

class Player extends Object {
	protected $skills = array();
	protected $number;
	
	public function __construct($skills = NULL) {
		if (is_array($skills)) $this->setSkills($skills);
	}
	
	protected function getActionsResult($skillName, $minimum, $maximum) {
		$Skill = new $skillName;
		$gradient = ($maximum - $minimum) / ($Skill->getMaximum() - $Skill->getMinimum());
		$intercept = $minimum - $gradient * $Skill->getMinimum();
		
		return $gradient * $this->getSkill($skillName) + $intercept;
	}
	
	public function delay() {
		$delay = $this->getActiosResult('ReactionTime', 0.5, 1);
		$delay += $delay * 0.2 * (rand(0, 1) - 0.5);
		
		return $delay;
	}
	
	public function getSkill($skill) {
		return isset($this->skills[$skill]) ? $this->skills[$skill] : NULL;
	}
	
	public function setSkill($skill, $value) {
		$this->skills[$skill] = $value;
	}
}