<?php

abstract class Simulator {
	protected $skills = array(
		'ReactionTime'
	);
	protected $playersPerTeam = 1;
	protected $Team1;
	protected $Team2;
	protected $randomSkills = array();
	protected $postedSkills = array();
	
	public function __construct($playersPerTeam = 1, $postedSkills = NULL) {
		$this->setPlayersPerTeam($playersPerTeam);
		if (is_array($postedSkills)) $this->setPostedSkills($postedSkills);
		
		foreach ($this->getSkills() as $name) {
			$skillName = $name . 'Skill';
			$Skill = new $skillName;
			
			for ($i = 0; $i < $this->getPlayersPerTeam(); $i++) {
				$this->setRandomSkill(1, $i, array($name => rand($Skill->getMinimum(), $Skill->getMaximum())));
				$this->setRandomSkill(2, $i, array($name => rand($Skill->getMinimum(), $Skill->getMaximum())));
			}
		}
		
		$this->setTeam1($this->getSetUpTeam(1));
		$this->setTeam2($this->getSetUpTeam(2));
	}
	
	abstract public function run();
	
	public function getSkills() {
		return $this->skills;
	}
	
	protected function getPlayersPerTeam() {
		return $this->playersPerTeam;
	}
	
	protected function getTeam1() {
		return $this->Team1;
	}
	
	protected function getTeam2() {
		return $this->Team2;
	}
	
	protected function getRandomSkills() {
		return $this->randomSkills;
	}
	
	public function getRandomSkill($team, $player = NULL, $skill = NULL) {
		if (is_null($player)) return isset($this->randomSkills[$team]) ? $this->randomSkills[$team] : NULL;
		else if (is_null($skill)) return isset($this->randomSkills[$team][$player]) ? $this->randomSkills[$team][$player] : NULL;
		else return isset($this->randomSkills[$team][$player][$skill]) ? $this->randomSkills[$team][$player][$skill] : NULL;
	}
	
	protected function getPostedSkills() {
		return $this->postedSkills;
	}
	
	public function getPostedSkill($team, $player = NULL, $skill = NULL) {
		if (is_null($player)) return isset($this->postedSkills[$team]) ? $this->postedSkills[$team] : NULL;
		else if (is_null($skill)) return isset($this->postedSkills[$team][$player]) ? $this->postedSkills[$team][$player] : NULL;
		else return isset($this->postedSkills[$team][$player][$skill]) ? $this->postedSkills[$team][$player][$skill] : NULL;
	}
	
	protected function getSetUpTeam($number) {
		$Team = new Team($number);
		
		for ($i = 0; $i < $this->getNumberPlayersPerTeam(); $i++) {
			$skills = !is_null($this->getPostedSkill($number, $i)) ? $this->getPostedSkill($number, $i) : $this->getRandomSkill($number, $i);
			$Team->addPlayer(new Player($skills));
		}
		
		return $Team;
	}
	
	protected function setPlayersPerTeam($playersPerTeam) {
		$this->playersPerTeam = $playersPerTeam;
	}
	
	protected function setTeam1($Team1) {
		$this->Team1 = $Team1;
	}
	
	protected function setTeam2($Team2) {
		$this->Team2 = $Team2;
	}
	
	protected function setRandomSkills($randomSkills) {
		$this->randomSkills = $randomSkills;
	}
	
	protected function setRandomSkill($team, $player, $skill) {
		if (!isset($this->randomSkills[$team][$player])) {
			$this->randomSkills[$team][$player] = $skill;
		} else {
			$this->randomSkills[$team][$player] = array_merge_recursive($this->randomSkills[$team][$player], $skill);
		}
	}
	
	public function setPostedSkills($postedSkills) {
		$this->postedSkills = $postedSkills;
	}
	
	protected function setPostedSkill($team, $player, $Skill) {
		if (!isset($this->postedSkills[$team][$player])) {
			$this->postedSkills[$team][$player] = $Skill;
		} else {
			$this->postedSkills[$team][$player] = array_merge_recursive($this->postedSkills[$team][$player], $Skill);
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
	
	protected function printBreak($numberBreaks = 1) {
		print str_repeat("\n", $numberBreaks);
	}
}