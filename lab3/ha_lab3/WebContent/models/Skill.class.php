<?php
include_once ("Messages.class.php");

class Skill {
	public static $SKILL_AREAS = array("system-design", "programming", "machining",
			"soldering", "wiring", "circuit-design", "power-systems", "computer-vision",
			"ultrasonic", "infrared", "gps", "compass");
	private $errorCount;
	private $errors;
	private $formInput;
	
	private $skillId;
	private $skill_name;
	
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
		$this->errors[$errorName] = Messages::getError($errorValue);
		$this->errorCount++;
	}
	
	public function getErrorCount() {
		return $this->errorCount;
	}
	
	public function getErrors() {
		return $this->errors;
	}
	
	public function getSkillName() {
		return $this->skill_name;
	}
	
	public function getSkillId() {
		return $this->skillId;
	}
	
	public function setSkillId($id) {
		$this->skillId = $id;
	}
	
	public function getParameters() {
		$paramArray = array("skillId" => $this->skillId, "skill_name" => $this->skill_name);
		
		return $paramArray;
	}
	
	public function __toString() {
		$str = "[Skill] {skillId: ".$this->skillId.", skill_name: ".$this->skill_name."}";
		return $str;
	}
	
	private function extractForm($valueName) {
		$value = "";
		
		if (isset($this->formInput[$valueName])) {
			$value = trim($this->formInput[$valueName]);
			$value = stripslashes($value);
			$value = htmlspecialchars($value);
			
			return $value;
		}
	}
	
	private function initialize() {
		$this->errorCount = 0;
		$errors = array();
		
		if (is_null($this->formInput))
			$this->initializeEmpty();
		else {
			$this->validateSkillName();
		}
	}
	
	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
		$this->skillName = "";
	}
	
	private function validateSkillName() {
		$this->skill_name = $this->extractForm('skill_name');
		
		if (empty($this->skill_name))
			$this->setError('skill_name', 'SKILL_NAME_EMPTY');
		elseif (!in_array($this->skill_name, Skill::$SKILL_AREAS)) {
			$this->setError('skill_name', 'SKILL_AREA_INVALID');
		}
	}
}
?>