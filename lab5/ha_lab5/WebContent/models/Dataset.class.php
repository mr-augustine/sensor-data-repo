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
	
	public function getParameters() {
		$paramArray = array('dataset_id' => $this->dataset_id,
							'dataset_name' => $this->dataset_name,
							'description' => $this->description,
							'date_created' => $this->date_created,
							'sensors' => $this->sensors);
		
		return $paramArray;
	}
	
	public function __toString() {
		$objectString = "[Dataset] {id: ".$this->dataset_id.", name: ".
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
		$this->dataset_name = "";
		$this->description = "";
		$this->date_created = "";
		$this->sensors = array();
	}
	
	private function validateDatasetName() {
		$this->dataset_name = $this->getFormInput('dataset_name');
		
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
				array('options' => array('regexp' => "/^([a-zA-Z0-9\-\_.])+$/i")) )) {
			$this->setError('dataset_name', 'DATASET_NAME_INVALID_CHARS');	
		}
	}
	
	private function validateDescription() {
		$this->description = $this->getFormInput('description');
		
		// Within length constraint
		if (!empty($this->description)) {
			if (strlen($this->description) > self::$MAX_DESCRIPTION_LENGTH)
				$this->setError('description', 'DATASET_DESCRIPTION_TOO_LONG');
		}
	}
}
?>