<?php
include_once("Messages.class.php");

class Dataset {
	public static $MAX_DESCRIPTION_LENGTH = 255;
	public static $MIN_DATASET_NAME_LENGTH = 4;
	public static $MAX_DATASET_NAME_LENGTH = 32;
	
	private $errorCount;
	private $errors;
	private $formInput;
	
	private $dataset_id;
	private $user_id;
	private $dataset_name;
	private $description;
	private $date_created;
	
	private $sensors;
	
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
	
	public function getDatasetId() {
		return $this->dataset_id;
	}
	
	public function setDatasetId($id) {
		$this->dataset_id = $id;
	}
	
	public function getUserId() {
		return $this->user_id;
	}
	
	public function getDatasetName() {
		return $this->dataset_name;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getDateCreated() {
		return $this->date_created;
	}
	
	public function setDateCreated($datetime) {
		$this->date_created = $datetime;
	}
	
	public function setSensors($sensorsArray) {
		$this->sensors = $sensorsArray;
	}
	
	public function getSensors() {
		return $this->sensors;
	}
	
	public function getParameters() {
		$paramArray = array('dataset_id' => $this->dataset_id,
							'user_id' => $this->user_id,
							'dataset_name' => $this->dataset_name,
							'description' => $this->description,
							'date_created' => $this->date_created,
							'sensors' => $this->sensors);
		
		return $paramArray;
	}
	
	public function __toString() {
		$objectString = "[Dataset] {dataset_id: ".$this->dataset_id.
			", user_id: ".$this->user_id.", name: ".
			$this->dataset_name.", date created: ".$this->date_created.
			", description: ".$this->description.", sensors: ".
			print_r($this->sensors, true)."}";
		
		return $objectString;
	}
	
	private function extractForm($valueName) {
		$value = "";
	
		if (isset($this->formInput[$valueName])) {
			$value = trim($this->formInput[$valueName]);
			$value = stripslashes($value);
			$value = htmlspecialchars($value);
		}
	
		return $value;
	}
	
	private function initialize() {
		$this->errorCount = 0;
		$this->errors = array();
		
		if (!is_null($this->formInput)) {
			$this->dataset_id = "";
			$this->sensors = array();
			$this->date_created = "";
			
			$this->validateUserId();
			$this->validateDatasetName();
			$this->validateDescription();
		} else {
			$this->initializeEmpty();
		}
	}
	
	private function initializeEmpty() {
		$this->errorCount = 0;
		$this->errors = array();
		$this->dataset_id = "";
		$this->user_id = "";
		$this->dataset_name = "";
		$this->description = "";
		$this->date_created = "";
		$this->sensors = array();
	}
	
	private function validateUserId() {
		$this->user_id = $this->extractForm('user_id');
		
		// Not empty
		if (empty($this->user_id))
			$this->setError('user_id', 'USER_ID_EMPTY');
		// Numeric and greater than 0
		else if (!is_numeric($this->user_id) || $this->user_id < 1)
			$this->setError('user_id', 'USER_ID_INVALID');
	}
	
	private function validateDatasetName() {
		$this->dataset_name = $this->extractForm('dataset_name');
		
		// Not empty
		if (empty($this->dataset_name))
			$this->setError('dataset_name', 'DATASET_NAME_EMPTY');
		// Within length constraints
		else if (strlen($this->dataset_name) < self::$MIN_DATASET_NAME_LENGTH)
			$this->setError('dataset_name', 'DATASET_NAME_TOO_SHORT');
		else if (strlen($this->dataset_name) > self::$MAX_DATASET_NAME_LENGTH)
			$this->setError('dataset_name', 'DATASET_NAME_TOO_LONG');
		// Valid chars
		else if (!filter_var($this->dataset_name, FILTER_VALIDATE_REGEXP,
				array('options' => array('regexp' => "/^([a-zA-Z0-9\-\_. ])+$/i")) )) {
			$this->setError('dataset_name', 'DATASET_NAME_INVALID_CHARS');	
		}
	}
	
	private function validateDescription() {
		$this->description = $this->extractForm('description');
		
		// Within length constraint
		if (!empty($this->description)) {
			if (strlen($this->description) > self::$MAX_DESCRIPTION_LENGTH)
				$this->setError('description', 'DATASET_DESCRIPTION_TOO_LONG');
		}
	}
}
?>