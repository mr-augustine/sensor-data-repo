<?php
include_once ("Messages.class.php");
class RobotData {
	public static $ROBOT_STATUSES = array("design", "in-development", "retired");
	
	private $errorCount;
	private $errors;
	private $formInput;
	
	private $robotId;
	private $robot_name;
	private $creators;
	private $status;
	
	public function __construct($formInput = null) {
		$this->formInput = $formInput;
		Messages::reset();
		$this->initialize();
	}

	public function getError($errorName) {
		if (isset($this->errors[$errorName]))
			return $this->errors[$errorName];
		else
			return "";
	}

	public function setError($errorName, $errorValue) {
		// Sets a particular error value and increments error count
		$this->errors[$errorName] =  Messages::getError($errorValue);
		$this->errorCount ++;
	}

	public function setRobotId($id) {
		$this->robotId = $id;
	}
	
	public function setCreators($creators) {
		$this->creators = $creators;
	}
	
	public function getRobotId() {
		return $this->robotId;
	}
	
	public function getErrorCount() {
		return $this->errorCount;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function getCreators() {
		return $this->creators;
	}
	
	public function getRobotName() {
		return $this->robot_name;
	}
	
	public function getStatus() {
		return $this->status;
	}
	
	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("robotId" => $this->robotId,
				"robot_name" => $this->robot_name,
				"creators" => $this->creators,
				"status" => $this->status
		);
		
		return $paramArray;
	}

	public function __toString() {
		$str = "[RobotData] {Name: ".$this->robot_name.", Creators: ".$this->creators.", Status: ".$this->status."}";
		return $str;
	}
	
	private function extractForm($valueName) {
		// Extract a stripped value from the form array
		$value = "";
		if (isset($this->formInput[$valueName])) {
			
			if (!is_array($this->formInput[$valueName])) {
				$value = trim($this->formInput[$valueName]);
				$value = stripslashes ($value);
				$value = htmlspecialchars ($value);
			} else {
				$value = array();
				
				foreach ($this->formInput[$valueName] as $arrayValue) {
					$tempValue = trim($arrayValue);
					$tempValue = stripslashes($arrayValue);
					$tempValue = htmlspecialchars($arrayValue);
					
					array_push($value, $tempValue);
				}
			}
			
			return $value;
		}
	}
	
	private function initialize() {
		$this->errorCount = 0;
		$errors = array();
		if (is_null($this->formInput))
			$this->initializeEmpty();
		else { 	 
		   	$this->validateName();
		   	$this->validateCreators();
		   	$this->validateStatus();
		}
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
	 	$this->robot_name = "";
	 	$this->creators = array();
	 	$this->status = "";
	}

	private function validateName() {
		$this->robot_name = $this->extractForm('robot_name');
		
		if (empty($this->robot_name))
			$this->setError('robot_name', 'ROBOT_NAME_EMPTY');
	}
	
	private function validateCreators() {
		$this->creators = $this->extractForm('creators');
	
		foreach ($this->creators as $creatorId) {
			if (empty($creatorId))
				$this->setError('creator', 'ROBOT_CREATOR_EMPTY');
			elseif (!is_numeric($creatorId) || $creatorId <= 0)
				$this->setError('creator', 'ROBOT_CREATOR_INVALID');
		}
	}
	
	private function validateStatus() {
		$this->status = $this->extractForm('status');
	
		if (empty($this->status))
			$this->setError('status', 'ROBOT_STATUS_EMPTY');
		elseif (!in_array($this->status, RobotData::$ROBOT_STATUSES))
			$this->setError('status', 'ROBOT_STATUS_INVALID');
	}
}
?>