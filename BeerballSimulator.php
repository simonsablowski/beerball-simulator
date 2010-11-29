<?php

class BeerballSimulator extends Simulator {
	protected $skills = array(
		'ThrowingAccuracy',
		'RunningSpeed',
		'DrinkingSpeed',
		'ReactionTime',
		'Dexterity'
	);
	protected $RockPaperScissorsSimulator;
	
	public function run() {
		$this->setGame(new Beerball($this->getTeam1(), $this->getTeam2()));
		
		$this->printHeadline('Teams');
		foreach ($this->getGame()->getTeams() as $number => $Team) {
			$this->printData(sprintf('Team %d', $number));
			foreach ($Team->getPlayers() as $number => $Player) {
				$this->printData(sprintf('Player %d (', $Player->getNumber()), FALSE);
				$nsk = count($Player->getSkills());
				$m = 1;
				foreach ($Player->getSkills() as $name => $value) {
					$Skill = new $name;
					$this->printData(sprintf('%s: %03d/%03d%s', $name, $value, $Skill->getMaximum(), $m < $nsk ? ', ' : ''), FALSE);
					$m++;
				}
				$this->printData(')');
			}
			$this->printBreak();
		}
		$this->printBreak();
		
		$this->setRockPaperScissorsSimulator(new RockPaperScissorsSimulator);
		$this->getRockPaperScissorsSimulator()->run();
		$Winner = $this->getRockPaperScissorsSimulator()->getGame()->getWinner();
		
		$this->getGame()->setBeginner($Winner->getNumber() == 1 ? $this->getTeam1() : $this->getTeam2());	
		$this->printData(sprintf('Team %d will perform the first attack in the Beerball match.', $Winner->getNumber()));
		$this->printBreak(2);
		
		$this->printHeadline('Beerball');
		$this->getGame()->start();
		
		foreach ($this->getGame()->getRounds() as $number => $round) {
			$this->printData(sprintf('Round %d', $number));
			$hit = $round['attacker']['throw'];
			$runningTime = $hit ? $round['defender']['runningTime'] : NULL;
			$this->printData(sprintf('Team %d is the attacking team.', $round['attacker']['Team']->getNumber()));
			$this->printData(sprintf('Player %d/%d %s the target.',
				$round['attacker']['Team']->getNumber(), $round['attacker']['Player']->getNumber(), $hit ? 'hits' : 'misses'));
			if ($hit) {
				$this->printData(sprintf('Player %d/%d runs for the ball which takes him %.2f seconds.',
					$round['defender']['Team']->getNumber(), $round['defender']['Player']->getNumber(), $runningTime));
				$this->printData(sprintf('Within these %.2f seconds, the players of Team %d decrease their beer: ',
					$runningTime, $round['defender']['Team']->getNumber()));
				foreach ($round['attacker']['drinking'] as $playerNumber => $amount) {
					$this->printData(sprintf('Player %d/%d: %.2f%% (leaving %.2f%%)',
						$round['attacker']['Team']->getNumber(), $playerNumber, $amount,
						max(0, $round['attacker']['Team']->getPlayer($playerNumber)->getBeerLevel())));
				}
			}
			$this->printBreak();
		}
		$this->printBreak();
		
		$this->printHeadline('Winner Team');
		$this->printData(sprintf('Team %d is the glorious winner!', $this->getGame()->getWinner()->getNumber()));
		$this->printBreak(2);
		
		$this->printHeadline('Statistics');
		foreach ($this->getGame()->getTeams() as $number => $Team) {
			$this->printData(sprintf('Team %d', $number));
			foreach ($Team->getPlayers() as $number => $Player) {
				$this->printData(sprintf('Player %d: %d throw%s, %d hit%s',
					$Player->getNumber(), $throws = $Player->getNumberThrows(), $throws != 1 ? 's' : '',
					$hits = $Player->getNumberHits(), $hits != 1 ? 's' : ''));
			}
			$this->printBreak();
		}
		$this->printBreak();
		
		$this->printHeadline('Beer Levels of Loser Team');
		foreach ($this->getGame()->getLoser()->getPlayers() as $number => $Player) {
			$this->printData(sprintf('Player %d/%d: %.2f%%',
				$this->getGame()->getLoser()->getNumber(), $Player->getNumber(), max(0, $Player->getBeerLevel())));
		}
	}
	
	protected function getSetUpTeam($number) {
		$Team = new BeerballTeam($number);
		
		for ($i = 0; $i < $this->getPlayersPerTeam(); $i++) {
			$skills = !is_null($this->getPostedSkill($number, $i)) ? $this->getPostedSkill($number, $i) : $this->getRandomSkill($number, $i);
			$Team->addPlayer(new BeerballPlayer($skills));
		}
		
		return $Team;
	}
}