<?php

abstract class Skill {
	protected $minimum = 1;
	protected $maximum = 100;
	
	public function getMinimum() {
		return $this->minimum;
	}
	
	public function getMaximum() {
		return $this->maximum;
	}
}