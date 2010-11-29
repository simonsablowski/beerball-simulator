<?php

class Beerball extends Game {
	protected $AttackingTeam;
	protected $DefendingTeam;
	
	public function start() {
		$this->setAttackingTeam($this->getBeginner());
		$this->setDefendingTeam($this->getAttackingTeam() == $this->getTeam1() ? $this->getTeam2() : $this->getTeam1());
		
		parent::start();
	}
	
	protected function playRound() {
		$this->setRound($this->getCurrentRound(), 'attacker', array(
			'hit' => $hit = $this->getAttackingPlayer()->throwBall()
		));
		$this->setRound($this->getCurrentRound(), 'defender', array(
			'Team' => clone $this->getDefendingTeam(),
			'Player' => clone $this->getDefendingPlayer()
		));
		
		if ($hit) {
			$this->setRound($this->getCurrentRound(), 'defender', array(
				'runningTime' => $runningTime = $this->getDefendingPlayer()->runForBall()
			));
			
			foreach ($this->getAttackingTeam()->getPlayers() as $number => $Player) {
				$this->setRound($this->getCurrentRound(), 'attacker', array(
					'drinking' => array(
						$number => $Player->drinkBeer($runningTime)
					)
				));
			}
		}
		
		$this->setRound($this->getCurrentRound(), 'attacker', array(
			'Team' => clone $this->getAttackingTeam(),
			'Player' => clone $this->getAttackingPlayer()
		));
		
		$team1Status = array();
		$team2Status = array();
		
		foreach ($this->getTeam1()->getPlayers() as $number => $Player) {
			$team1Status[$number] = $Player->hasEmptyBottle();
		}
		
		foreach ($this->getTeam2()->getPlayers() as $number => $Player) {
			$team2Status[$number] = $Player->hasEmptyBottle();
		}
		
		if (array_values(array_unique($team1Status)) == array(TRUE)) $this->setWinner($this->getTeam1());
		else if (array_values(array_unique($team2Status)) == array(TRUE)) $this->setWinner($this->getTeam2());
		
		$this->swapTeamRoles();
	}
	
	protected function getAttackingPlayerNumber() {
		return (ceil($this->getCurrentRound() / 2) - 1) % $this->getAttackingTeam()->getNumberPlayers() + 1;
	}
	
	protected function getAttackingPlayer() {
		return $this->getAttackingTeam()->getPlayer($this->getAttackingPlayerNumber());
	}
	
	protected function getDefendingPlayerNumber() {
		return (ceil($this->getCurrentRound() / 2) - 1) % $this->getDefendingTeam()->getNumberPlayers() + 1;
	}
	
	protected function getDefendingPlayer() {
		return $this->getDefendingTeam()->getPlayer($this->getDefendingPlayerNumber());
	}
	
	protected function swapTeamRoles() {
		$AttackingTeam = $this->getAttackingTeam();
		$this->setAttackingTeam($this->getDefendingTeam());
		$this->setDefendingTeam($AttackingTeam);
	}
}