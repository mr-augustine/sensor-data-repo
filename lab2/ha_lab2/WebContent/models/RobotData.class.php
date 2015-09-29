<?php
include_once ("Messages.class.php");
class RobotData {
	public static $ROBOT_STATUSES = array("design", "in-development", "retired");
	
	private $errorCount;
	private $errors;
	private $formInput;
	
	private $robot_name;
	private $creator;
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

	public function getErrorCount() {
		return $this->errorCount;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function getEmail() {
		return $this->email;
	}
	
	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("email" => $this->email);
		
		return $paramArray;
	}

	public function __toString() {
		$str = "[RobotData] {Name: ".$this->robot_name.", Creator: ".$this->creator.", Status: ".$this->status."}";
		return $str;
	}
	
	private function extractForm($valueName) {
		// Extract a stripped value from the form array
		$value = "";
		if (isset($this->formInput[$valueName])) {
			$value = trim($this->formInput[$valueName]);
			$value = stripslashes ($value);
			$value = htmlspecialchars ($value);
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
		   	$this->validateCreator();
		   	$this->validateStatus();
		}
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
	 	$this->robot_name = "";
	 	$this->creator = "";
	 	$this->status = "";
	}

	private function validateName() {
		$this->robot_name = $this->extractForm('robot_name');
		
		if (empty($this->robot_name))
			$this->setError('robot_name', 'ROBOT_NAME_EMPTY');
	}
	
	private function validateCreator() {
		$this->creator = $this->extractForm('creator');
	
		if (empty($this->creator))
			$this->setError('creator', 'ROBOT_CREATOR_EMPTY');
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