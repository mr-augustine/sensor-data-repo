<?php
include ("Messages.class.php");
class UserData {
	private static $SKILL_LEVELS = array("novice", "advanced", "expert");
	private static $SKILL_AREAS = array("system-design", "programming", "machining",
			"soldering", "wiring", "circuit-design", "power-systems", "computer-vision",
			"ultrasonic", "infrared", "gps", "compass");
	private $errorCount;
	private $errors;
	private $formInput;
	
	private $user_name;
	private $skill_level;
	private $skill_areas;
	private $profile_pic;
	private $started_hobby;
	private $fav_color;
	private $url;
	private $phone;
	
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
	
	private function initialize() {
		$this->errorCount = 0;
		$errors = array();
		
		if (is_null($this->formInput))
			$this->initializeEmpty();
		else {
			$this->validateUserName();
			$this->validateSkillLevel();
			$this->validateSkillAreas();
			$this->validateProfilePic();
			$this->validateStartedHobby();
			$this->validateFavColor();
			$this->validateUrl();
			$this->validatePhone();
		}
	}
	
	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
		$this->user_name = "";
		$this->skill_areas = array();
		$this->profile_pic = "";
		$this->started_hobby = "";
		$this->fav_color = "";
		$this->url = "";
		$this->phone = "";
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
	
	public function getFavColor() {
		return $this->fav_color;
	}
	
	public function getPhone() {
		$this->phone;
	}
	
	public function getProfilePic() {
		return $this->profile_pic;
	}
	
	public function getRobots() {
		return null;
	}
	
	public function getSkillAreas()  {
		return $this->skill_areas;
	}
	
	public function getStartedHobby() {
		return $this->started_hobby;
	}
	
	public function getUrl() {
		return $this->url;
	}
	
	private function validateSkillLevel() {
		// Skill level should only be one of the available options {novice, advanced, exper}
		$this->skill_level = $this->extractForm('skill_level');
		
		if (empty($this->skill_level)) {
			$this->setError('skill_level', 'SKILL_LEVEL_NOT_SET');
			$this->errorCount ++;
		} elseif (!in_array($this->skill_level, $SKILL_LEVELS)) {
			$this->setError('skill_level', 'SKILL_LEVEL_INVALID');
			$this->errorCount ++;
		}
	}
	
	private function validateUserName() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->user_name = $this->extractForm('user_name');
		
		if (empty($this->user_name)) {
			$this->setError('user_name', 'USER_NAME_EMPTY');
			$this->errorCount ++;
		} elseif (!filter_var($this->userName, FILTER_VALIDATE_REGEXP,
			array("options"=>array("regexp" =>"/^([a-zA-Z0-9\-\_])+$/i")) )) {
			$this->setError('user_name', 'USER_NAME_HAS_INVALID_CHARS');
			$this->errorCount ++;
		}
	}
	
	public function __toString() {
		$str = "[UserData] {user_name: ".$this->user_name."; skill_level: ".$this->skill_level
			."; skill_areas: ".$this->getSkillAreas()."; profile_pic: ".$this->getProfilePic()
			."; started_hobby: ".$this->getStartedHobby()."; fav_color: ".$this->getFavColor()
			."; url: ".$this->getUrl()."; phone: ".$this->getPhone()."; robots: ".$this->getRobots()
			."}";
		
		return $str;
	}
}
?>