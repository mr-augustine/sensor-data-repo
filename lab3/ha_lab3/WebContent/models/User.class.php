<?php
include_once ("Messages.class.php");
class User {
	private static $MIN_PASSWORD_LENGTH = 8;
	private $errorCount;
	private $errors;
	private $formInput;
	
	private $email;
	private $password;
	
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

	public function getPassword() {
		return $this->password;
	}
	
	public function __toString() {
		$str = "[User] {Email: ".$this->email."}";
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
		   	$this->validateEmail();
		   	$this->validatePassword();
		}
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
	 	$this->userName = "";
	}

	private function validateEmail() {
		$this->email = $this->extractForm('email');
		
		if (empty($this->email))
			$this->setError('email', 'EMAIL_EMPTY');
		elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
			$this->setError('email', 'EMAIL_INVALID');
	}
	
	private function validatePassword() {
		$this->password = $this->extractForm('password');
	
		if (empty($this->password))
			$this->setError('password', 'PASSWORD_EMPTY');
		elseif (strlen($this->password) < self::$MIN_PASSWORD_LENGTH)
			$this->setError('password', 'PASSWORD_TOO_SHORT');
	}
}
?>