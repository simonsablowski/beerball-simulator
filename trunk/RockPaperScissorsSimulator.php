<?php

class RockPaperScissorsSimulator extends Simulator {
	public function run() {
		$this->setGame(new RockPaperScissors($this->getTeam1(), $this->getTeam2()));
		
		$this->printHeadline('Rock Paper Scissors');
		$this->getGame()->start();
		
		foreach ($this->getGame()->getRounds() as $number => $options) {
			$this->printData(sprintf('Round %d', $number));
			$this->printData(sprintf('Team 1: %s', $options[1]));
			$this->printData(sprintf('Team 2: %s', $options[2]));
			$this->printBreak();
		}
		
		$Winner = $this->getGame()->getWinner();
		$this->printData(sprintf('The winner of Rock Paper Scissors is Team %d.', $Winner->getNumber()));
	}
}