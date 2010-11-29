<?php

abstract class Game {
	protected $Team1;
	protected $Team2;
	protected $Beginner;
	protected $Winner;
	protected $rounds = array();
	protected $currentRound = 1;
	
	public function __construct($Team1, $Team2) {
		$this->setTeam1($Team1);
		$this->setTeam2($Team2);
	}
	
	public function start() {
		while (!$this->isOver()) {
			$this->playRound();
			$this->increaseCurrentRound();
		}
	}
	
	abstract protected function playRound();
	
	protected function isOver() {
		return !is_null($this->getWinner());
	}
	
	public function getTeams() {
		return array(1 => $this->getTeam1(), 2 => $this->getTeam2());
	}
	
	public function getTeam1() {
		return $this->Team1;
	}
	
	public function getTeam2() {
		return $this->Team2;
	}
	
	public function getBeginner() {
		return $this->Beginner;
	}
	
	public function getWinner() {
		return $this->Winner;
	}
	
	public function getLoser() {
		return $this->getWinner() == $this->getTeam1() ? $this->getTeam2() : $this->getTeam1();
	}
	
	public function getRound($round, $team = NULL) {
		if (!is_null($team)) return isset($this->rounds[$round][$team]) ? $this->rounds[$round][$team] : NULL;
		else return isset($this->rounds[$round]) ? $this->rounds[$round] : NULL;
	}
	
	public function getRounds() {
		return $this->rounds;
	}
	
	public function getCurrentRound() {
		return $this->currentRound;
	}
	
	protected function increaseCurrentRound() {
		$this->setCurrentRound($this->getCurrentRound() + 1);
	}
	
	protected function setTeam1($Team1) {
		$this->Team1 = $Team1;
	}
	
	protected function setTeam2($Team2) {
		$this->Team2 = $Team2;
	}
	
	public function setBeginner($Beginner) {
		$this->Beginner = $Beginner;
	}
	
	protected function setWinner($Winner) {
		$this->Winner = $Winner;
	}
	
	protected function setRound($round, $team, $data) {
		$this->rounds[$round][$team] = isset($this->rounds[$round][$team]) ? array_merge_recursive($this->rounds[$round][$team], $data) : $data;
	}
	
	protected function setRounds($rounds) {
		$this->rounds = $rounds;
	}
	
	protected function setCurrentRound($currentRound) {
		$this->currentRound = $currentRound;
	}
}