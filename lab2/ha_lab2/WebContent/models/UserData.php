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
// 		$this->errorCount = 0;
// 		$errors = array();
// 		if (is_null($this->formInput))
// 			$this->initializeEmpty();
// 		else {
// 			$this->validateEmail();
// 			$this->validatePassword();
// 		}
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