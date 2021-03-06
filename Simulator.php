<?php

abstract class Simulator extends Object {
	protected $skills = array(
		'ReactionTime'
	);
	protected $playersPerTeam = 1;
	protected $Team1;
	protected $Team2;
	protected $Game;
	protected $randomSkills = array();
	protected $postedSkills = array();
	
	public function __construct($playersPerTeam = 1, $postedSkills = NULL) {
		$this->setPlayersPerTeam($playersPerTeam);
		
		if (is_array($postedSkills)) {
			$this->setPostedSkills($postedSkills);
		} else {
			foreach ($this->getSkills() as $name) {
				$Skill = new $name;
				for ($i = 1; $i <= $this->getPlayersPerTeam(); $i++) {
					$this->setRandomSkill(1, $i, array($name => rand($Skill->getMinimum(), $Skill->getMaximum())));
					$this->setRandomSkill(2, $i, array($name => rand($Skill->getMinimum(), $Skill->getMaximum())));
				}
			}
		}
		
		$this->setTeam1($this->getSetUpTeam(1));
		$this->setTeam2($this->getSetUpTeam(2));
	}
	
	abstract public function run();
	
	public function getRandomSkill($team, $player = NULL, $skill = NULL) {
		if (is_null($player)) return isset($this->randomSkills[$team]) ? $this->randomSkills[$team] : NULL;
		else if (is_null($skill)) return isset($this->randomSkills[$team][$player]) ? $this->randomSkills[$team][$player] : NULL;
		else return isset($this->randomSkills[$team][$player][$skill]) ? $this->randomSkills[$team][$player][$skill] : NULL;
	}
	
	public function getPostedSkill($team, $player = NULL, $skill = NULL) {
		if (is_null($player)) return isset($this->postedSkills[$team]) ? $this->postedSkills[$team] : NULL;
		else if (is_null($skill)) return isset($this->postedSkills[$team][$player]) ? $this->postedSkills[$team][$player] : NULL;
		else return isset($this->postedSkills[$team][$player][$skill]) ? $this->postedSkills[$team][$player][$skill] : NULL;
	}
	
	public function getSetUpTeam($number) {
		$Team = new Team($number);
		
		for ($i = 1; $i <= $this->getPlayersPerTeam(); $i++) {
			$skills = !is_null($this->getPostedSkill($number, $i)) ? $this->getPostedSkill($number, $i) : $this->getRandomSkill($number, $i);
			$Team->addPlayer(new Player($skills));
		}
		
		return $Team;
	}
	
	protected function setRandomSkill($team, $player, $skill) {
		if (!isset($this->randomSkills[$team][$player])) {
			$this->randomSkills[$team][$player] = $skill;
		} else {
			$this->randomSkills[$team][$player] = array_merge_recursive($this->randomSkills[$team][$player], $skill);
		}
	}
	
	protected function setPostedSkill($team, $player, $skill) {
		if (!isset($this->postedSkills[$team][$player])) {
			$this->postedSkills[$team][$player] = $skill;
		} else {
			$this->postedSkills[$team][$player] = array_merge_recursive($this->postedSkills[$team][$player], $skill);
		}
	}
	
	protected function printHeadline($headline) {
		print $headline . ':';
		$this->printBreak();
		print str_repeat('-', strlen($headline) + 1);
		$this->printBreak();
	}
	
	protected function printData($data, $break = TRUE) {
		print $data;
		if ($break) $this->printBreak();
	}
	
	protected function printBreak($number = 1) {
		print str_repeat("\n", $number);
	}
}