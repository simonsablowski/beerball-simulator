<?php

class RockPaperScissors extends Game {
	protected $options = array(
		'Rock' => 'Scissors',
		'Paper' => 'Rock',
		'Scissors' => 'Paper'
	);
	
	protected function playRound() {
		$this->setRound($this->getCurrentRound(), 1, $option1 = $this->getRandomOption());
		$this->setRound($this->getCurrentRound(), 2, $option2 = $this->getRandomOption());
		
		if ($option1 != $option2) $this->setWinner($option2 == $this->getOption($option1) ? $this->getTeam1() : $this->getTeam2());
	}
	
	protected function getRandomOption() {
		$options = array_keys($this->getOptions());
		return $options[rand(0, count($options) - 1)];
	}
	
	protected function getOption($option) {
		return isset($this->options[$option]) ? $this->options[$option] : NULL;
	}
}