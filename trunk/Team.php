<?php

class Team extends Object {
	protected $number;
	protected $players = array();
	
	public function __construct($number) {
		$this->setNumber($number);
	}
	
	public function __clone() {
		foreach ($this->players as $number => $Player) {
			$this->players[$number] = clone $Player;
		}
	}
	
	public function getPlayer($number) {
		return isset($this->players[$number]) ? $this->players[$number] : NULL;
	}
	
	public function getNumberPlayers() {
		return count($this->getPlayers());
	}
	
	public function addPlayer($Player) {
		$this->players[$number = $this->getNumberPlayers() + 1] = $Player;
		$this->getPlayer($number)->setNumber($number);
	}
}