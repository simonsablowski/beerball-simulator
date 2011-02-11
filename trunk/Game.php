<?php

abstract class Game extends Object {
	protected $Team1;
	protected $Team2;
	protected $Beginner;
	protected $Winner;
	protected $rounds = array();
	protected $currentRound = 1;
	
	public function __construct(Team $Team1, Team $Team2) {
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
	
	public function getLoser() {
		return $this->getWinner() == $this->getTeam1() ? $this->getTeam2() : $this->getTeam1();
	}
	
	public function getRound($round, $team = NULL) {
		if (!is_null($team)) return isset($this->rounds[$round][$team]) ? $this->rounds[$round][$team] : NULL;
		else return isset($this->rounds[$round]) ? $this->rounds[$round] : NULL;
	}
	
	protected function increaseCurrentRound() {
		$this->setCurrentRound($this->getCurrentRound() + 1);
	}
	
	protected function setRound($round, $team, $data) {
		$this->rounds[$round][$team] = isset($this->rounds[$round][$team]) ? array_merge_recursive($this->rounds[$round][$team], $data) : $data;
	}
}