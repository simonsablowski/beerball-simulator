<?php

abstract class Object {
	public function __call($method, $parameters) {
		preg_match_all('/(^|[A-Z]{1})([a-z0-9]*)/', $method, $methodParts);
		if (!isset($methodParts[0][0]) || !isset($methodParts[0][1])) throw new Exception('Invalid method format: ' . $method);
		
		$operation = $methodParts[0][0];
		array_shift($methodParts[0]);
		
		$propertyCapitalized = implode('', $methodParts[0]);
		$property = strtolower(substr($propertyCapitalized, 0, 1)) . substr($propertyCapitalized, 1);
		
		if (property_exists($this, $propertyCapitalized)) {
			$property = $propertyCapitalized;
		} else if (!property_exists($this, $property)) {
			throw new Exception('Property does not exist: ' . $property);
		}
		
		switch ($operation) {
			case 'get':
				return $this->$property;
			case 'is':
				return $this->$property === TRUE;
			case 'set':
				return $this->$property = $parameters[0];
		}
	}
}