<?php

error_reporting(E_ALL);

include_once 'Game.php';
include_once 'Beerball.php';
include_once 'RockPaperScissors.php';
include_once 'Team.php';
include_once 'BeerballTeam.php';
include_once 'Player.php';
include_once 'BeerballPlayer.php';
include_once 'Simulator.php';
include_once 'BeerballSimulator.php';
include_once 'Skill.php';

$autoRun = isset($_REQUEST['autoRun']) ? (bool)$_REQUEST['autoRun'] : TRUE;
$playersPerTeam = isset($_REQUEST['playersPerTeam']) ? (int)$_REQUEST['playersPerTeam'] : 1;

foreach (BeerballSimulator::getSkills() as $skill) {
	include_once $skill . 'Skill.php';
}

$Simulator = new BeerballSimulator($playersPerTeam);

$postedSkills = NULL;
if ($submitted = isset($_POST['submit'])) {
	$postedSkills = array();
	
	for ($i = 0; $i < $playersPerTeam; $i++) {
		foreach ($_POST['skills'][1][$i] as $name => $value) {
			$skillName = $name . 'Skill';
			$Skill = new $skillName;
			$postedSkills[1][$i][$name] = min($Skill->getMaximum(), max($Skill->getMinimum(), (int)$value));
		}
		
		foreach ($_POST['skills'][2][$i] as $name => $value) {
			$skillName = $name . 'Skill';
			$Skill = new $skillName;
			$postedSkills[2][$i][$name] = min($Skill->getMaximum(), max($Skill->getMinimum(), (int)$value));
		}
	}
}

$Simulator->setPostedSkills($postedSkills);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.ddd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type"/>
		<title>Beerball Simulator</title>
	</head>
	<body>
		<div>
			<? if ($autoRun || $submitted): ?>
			<pre><? $Simulator->run(); ?></pre>
			<? else: ?>
			<form action="index.php" method="post">
				<? foreach ($skills as $skill): ?>
				<fieldset>
					<legend>
						<? echo $skill; ?>
					</legend>
					<p>
						<strong>Team 1</strong>:
						<? for ($i = 0; $i < $playersPerTeam; $i++): ?>
						<input type="text" name="skills[1][0][<? echo $skill; ?>]" value=""/>
						<? endfor; ?>
					</p>
					<p>
						<strong>Team 2</strong>:
						<? for ($i = 0; $i < $playersPerTeam; $i++): ?>
						<input type="text" name="skills[2][0][<? echo $skill; ?>]" value=""/>
						<? endfor; ?>
					</p>
				</fieldset>
				<? endforeach; ?>
				<div>
					<p>
						<input type="submit" name="submit" value="Submit"/>
					</p>
				</div>
			</form>
			<? endif; ?>
		</div>
	<body>
</html>