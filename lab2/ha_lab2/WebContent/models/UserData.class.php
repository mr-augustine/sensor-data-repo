<?php
include_once ("Messages.class.php");
class UserData {
	private static $MIN_USERNAME_LENGTH = 6;
	public static $SKILL_LEVELS = array("novice", "advanced", "expert");
	public static $SKILL_AREAS = array("system-design", "programming", "machining",
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
			
			// Handle leaf-values and array-values differently
			if (!is_array($this->formInput[$valueName])) {
				$value = trim($this->formInput[$valueName]);
				$value = stripslashes ($value);
				$value = htmlspecialchars ($value);
			} else {
				$value = array();
				
				foreach ($this->formInput[$valueName] as $arrayValue) {
					$tempValue = trim($arrayValue);
					$tempValue = stripslashes ($arrayValue);
					$tempValue = htmlspecialchars ($arrayValue);
					
					array_push($value, $tempValue);
				}
			}
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
		return $this->phone;
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
	
	public function getSkillLevel() {
		return $this->skill_level;
	}
	
	public function getStartedHobby() {
		return $this->started_hobby;
	}
	
	public function getUrl() {
		return $this->url;
	}
	
	public function getUserName() {
		return $this->user_name;
	}
	
	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("user_name" => $this->user_name, "skill_level" => $this->skill_level,
			"skill_areas" => $this->skill_areas, "profile_pic" => $this->profile_pic,
			"started_hobby" => $this->started_hobby, "fav_color" => $this->fav_color,
			"url" => $this->url, "phone" => $this->phone
		);
		
		return $paramArray;
	}
	
	private function validateFavColor() {
		// The favorite color should be a valid hex code, prefixed with a '#' {#0123ab}
		$this->fav_color = $this->extractForm('fav_color');
		
		if (empty($this->fav_color)) {
			$this->setError('fav_color', 'FAV_COLOR_EMPTY');
		} elseif (!filter_var($this->fav_color, FILTER_VALIDATE_REGEXP,
			array("options"=>array("regexp" =>"/^#[0-9a-f]{6}$/")) )) {
			$this->setError('fav_color', 'FAV_COLOR_INVALID');
		}
	}
	
	private function validatePhone() {
		// If set, the phone number must contain valid characters
		$this->phone = $this->extractForm('phone');
		
		if (!empty($this->phone)) {
			// TODO: relax the formatting constraint; normalize then check

			// remove spaces then check formatting
			$this->phone = str_replace(' ', '', $this->phone);
			if(!filter_var($this->phone, FILTER_VALIDATE_REGEXP,
					array("options"=>array("regexp" =>"/^\d{3}[-.]?\d{3}[-.]?\d{4}$/")) )) {
				$this->setError('phone', 'PHONE_NUMBER_INVALID');
			}
		}
	}
	
	private function validateProfilePic() {
		// If set, the profile pic should be a picture filetype
		$this->profile_pic = $this->extractForm('profile_pic');
		
		if (!empty($this->profile_pic)) {
			if(!filter_var($this->profile_pic, FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp" =>"/\.(bmp|jpg|jpeg|png|gif|tif)$/")) )) {
					$this->setError('profile_pic', 'PROFILE_PIC_WRONG_TYPE');
			}
			
			// TODO: figure out a better way of verifying filetype
			/*$finfo = new finfo;
			
			$fileinfo = $finfo->file($file, FILEINFO_MIME);
			
			// Verify that the mime type specifies an image
			if (!(strpos($fileinfo, "image/") == 0)) {
				$this->setError('profile_pic', 'PROFILE_PIC_WRONG_TYPE');
			}*/
		}
	}
	
	private function validateSkillAreas() {
		// If set, skill areas should only be from the available options
		$this->skill_areas = $this->extractForm('skill_areas');
		
		if (!empty($this->skill_areas)) {
			$numSkillAreas = count($this->skill_areas);
			
			for ($i = 0; $i < $numSkillAreas; $i++) {
				if (!in_array($this->skill_areas[$i], UserData::$SKILL_AREAS)) {
					$this->setError('skill_areas', 'SKILL_AREA_INVALID');
					
					// error out if at least one skill area is invalid
					break;
				}
			}
		}
	}
	
	private function validateSkillLevel() {
		// Skill level should only be one of the available options {novice, advanced, expert}
		$this->skill_level = $this->extractForm('skill_level');
		
		if (empty($this->skill_level)) {
			$this->setError('skill_level', 'SKILL_LEVEL_NOT_SET');
		} elseif (!in_array($this->skill_level, UserData::$SKILL_LEVELS)) {
			$this->setError('skill_level', 'SKILL_LEVEL_INVALID');
		}
	}
	
	private function validateStartedHobby() {
		// Hobby start date should be a valid year-month combination between epoch and current month
		$this->started_hobby = $this->extractForm('started_hobby');
		
		if (empty($this->started_hobby)) {
			$this->setError('started_hobby', 'HOBBY_DATE_EMPTY');
		}
		
		// Use a simple regex to check date format {yyyy-dd}
		elseif (!filter_var($this->started_hobby, FILTER_VALIDATE_REGEXP,
			array("options"=>array("regexp" =>"/^[12]\d{3}-[012]\d$/")) )) {
			$this->setError('started_hobby', 'HOBBY_DATE_FORMAT_INVALID');
			break;
		}
		
		// Verify that the date range is appropriate {epoch .. current date}
		else {
			list($startYear, $startMonth) = explode("-", $this->started_hobby, 2);
			$currentYear = date("Y");
			$currentMonth = date("m");
			
			// Convert all date fields to integers
			$currentYear += 0;
			$currentMonth += 0;
			$startYear += 0;
			$startMonth += 0;
			
			if ( !($startYear >= 1970 && $startYear <= $currentYear) || 
					!($startMonth >= 1 && $startMonth <= $currentMonth) ) {
				$this->setError('started_hobby', 'HOBBY_DATE_INVALID');
			}
		}
		
	}
	
	private function validateUrl() {
		// If set, URL should be in valid format
		$this->url = $this->extractForm('url');
		
		if (!empty($this->url)) {
			if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
				$this->setError('url', 'URL_INVALID');
			}
		}
	}
	
	private function validateUserName() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->user_name = $this->extractForm('user_name');
		
		if (empty($this->user_name)) {
			$this->setError('user_name', 'USER_NAME_EMPTY');
		} elseif (strlen($this->user_name) < self::$MIN_USERNAME_LENGTH) {
			$this->setError('user_name', 'USER_NAME_TOO_SHORT');
		} elseif (!filter_var($this->user_name, FILTER_VALIDATE_REGEXP,
			array("options"=>array("regexp" =>"/^([a-zA-Z0-9\-\_])+$/i")) )) {
			$this->setError('user_name', 'USER_NAME_HAS_INVALID_CHARS');
		}
	}
	
	public function __toString() {
		$str = "[UserData] {user_name: ".$this->user_name."; skill_level: ".$this->skill_level
			."; skill_areas: ".print_r($this->getSkillAreas(),true)."; profile_pic: ".$this->getProfilePic()
			."; started_hobby: ".$this->getStartedHobby()."; fav_color: ".$this->getFavColor()
			."; url: ".$this->getUrl()."; phone: ".$this->getPhone()."; robots: ".$this->getRobots()
			."}";
		
		return $str;
	}
}
?>