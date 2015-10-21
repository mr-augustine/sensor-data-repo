<?php
include_once ("Messages.class.php");

class SkillAssocs {
	
	private $errorCount;
	private $errors;
	
	private $skillAssocId;
	private $skillId;
	private $userDataId;
	
	public function __construct($userDataId = null, $skillId = null) {
		$this->userDataId = $userDataId;
		$this->skillId = $skillId;
		
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
		$this->errors[$errorName] = Messages::getError($errorValue);
		$this->errorCount++;
	}
	
	public function getErrorCount() {
		return $this->errorCount;
	}
	
	public function getErrors() {
		return $this->errors;
	}
	
	public function getUserDataId() {
		return $this->userDataId;
	}
	
	public function getSkillId() {
		return $this->skillId;
	}
	
	public function getSkillAssocId() {
		return $this->skillAssocId;
	}
	
	public function setSkillAssocId($id) {
		$this->skillAssocId = $id;
	}
	
	private function initialize() {
		$this->errorCount = 0;
		$errors = array();
		
		if (is_null($this->userDataId) || is_null($this->skillId))
			$this->initializeEmpty();
		else {
			$this->userDataId = trim($this->userDataId);
			$this->userDataId = stripslashes($this->userDataId);
			$this->userDataId = htmlspecialchars($this->userDataId);
			$this->skillId = trim($this->skillId);
			$this->skillId = stripslashes($this->skillId);
			$this->skillId = htmlspecialchars($this->skillId);
			
			$this->validateSkillId();
			$this->validateUserDataId();
		}
	}
	
	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
		$this->skillId = "";
		$this->userDataId = "";
	}
	
	private function validateSkillId() {
		if (!is_numeric($this->skillId) || $this->skillId < 0)
			$this->setError('skillId', 'SKILL_ID_INVALID');
		elseif (empty($this->skillId))
			$this->setError('skillId', 'SKILL_ID_EMPTY');
	}
	
	private function validateUserDataId() {
		if (!is_numeric($this->userDataId) || $this->userDataId < 0)
			$this->setError('userDataId', 'USER_DATA_ID_INVALID');
		elseif (empty($this->userDataId))
			$this->setError('userDataId', 'USER_DATA_ID_EMPTY');
	}
}
?>