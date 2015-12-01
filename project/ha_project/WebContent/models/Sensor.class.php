<?php
include_once("Messages.class.php");

class Sensor {
	public static $MAX_DESCRIPTION_LENGTH = 128;
	public static $MAX_SENSOR_NAME_LENGTH = 32;
	public static $MIN_SENSOR_NAME_LENGTH = 4;
	public static $VALID_SENSOR_TYPES = array('ALTITUDE', 'BINARY', 'COUNT',
		'DIRECTION', 'DISTANCE', 'HEADING', 'IMAGING', 'LATITUDE', 'LONGITUDE',
		'RANGE', 'RATE', 'TEMPERATURE');
	public static $VALID_SENSOR_UNITS = array('FEET', 'METERS', 'MILES', 'KILOMETERS',
		'INCHES', 'CENTIMETERS', 'YES-NO', 'TRUE-FALSE', '1-0', 'ON-OFF',
		'DEGREES', 'DMS', 'DDMS', 'COLOR', 'GRAYSCALE', 'INFRARED', 'MILES-PER-HOUR',
		'METERS-PER-SECOND', 'RADIANS', 'DEGREES-FAHRENHEIT', 'DEGREES-CELCIUS',
		'PER', 'FORWARD', 'BACKWARD', 'LEFT', 'RIGHT');
	public static $VALID_SENSOR_SEQUENCE_TYPES = array('TIME-CODED', 'SEQUENTIAL');
	
	private $errorCount;
	private $errors;
	private $formInput;
	
	private $sensor_id;
	private $dataset_id;
	private $sensor_name;
	private $sensor_type;
	private $sensor_units;
	private $sequence_type;
	private $description;
	
	private $measurments;
	
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
	
	public function getSensorId() {
		return $this->sensor_id;
	}
	
	public function setSensorId($id) {
		$this->sensor_id = $id;
	}
	
	public function getDatasetId() {
		return $this->dataset_id;
	}
	
	public function getSensorName() {
		return $this->sensor_name;
	}
	
	public function getSensorType() {
		return $this->sensor_type;
	}
	
	public function getSensorUnits() {
		return $this->sensor_units;
	}
	
	public function getSequenceType() {
		return $this->sequence_type;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getMeasurements() {
		return $this->measurements;
	}
	
	public function setMeasurements($measurements) {
		$this->measurements = $measurements;
	}
	
	public function requiresTimestampedMeasurements() {
		return ($this->sequence_type == 'TIME_CODED');
	}
	
	public function getParameters() {
		$paramArray = array('sensor_id' => $this->sensor_id,
							'dataset_id' => $this->dataset_id,
							'sensor_name' => $this->sensor_name,
							'sensor_type' => $this->sensor_type,
							'sensor_units' => $this->sensor_units,
							'sequence_type' => $this->sequence_type,
							'description' => $this->description,
							'measurements' => $this->measurements);
		
		return $paramArray;
	}
	
	public function __toString() {
		$objectString = "[Sensor] {id: ".$this->sensor_id.", dataset_id: ".
		$this->dataset_id.", name: ".
		$this->sensor_name.", type: ".$this->sensor_type.", units: ".
		$this->sensor_units.", sequence: ".$this->sequence_type.", description: ".
		$this->description.", measurements: ".print_r($this->measurements, true)."}";
		
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
			$this->sensor_id = "";
			$this->measurements = array();
			
			$this->validateDatasetId();
			$this->validateSensorName();
			$this->validateSensorType();
			$this->validateSensorUnits();
			$this->validateSequenceType();
			$this->validateDescription();
		} else {
			$this->initializeEmpty();
		}
	}
	
	private function initializeEmpty() {
		$this->errorCount = 0;
		$this->errors = array();
		$this->sensor_id = "";
		$this->dataset_id = "";
		$this->sensor_name = "";
		$this->sensor_type = "";
		$this->sensor_units = "";
		$this->sequence_type = "";
		$this->description = "";
		$this->measurements = array();
	}
	
	private function validateDatasetId() {
		$this->dataset_id = $this->extractForm('dataset_id');
		
		// Not empty
		if (empty($this->dataset_id))
			$this->setError('dataset_id', 'DATASET_ID_EMPTY');
		// Numeric and greater than 0
		else if (!(is_numeric($this->dataset_id) && $this->dataset_id > 0))
			$this->setError('dataset_id', 'DATASET_ID_INVALID');
	}
	
	private function validateSensorName() {
		$this->sensor_name = $this->extractForm('sensor_name');
		
		// Not empty
		if (empty($this->sensor_name))
			$this->setError('sensor_name', 'SENSOR_NAME_EMPTY');
		// Meets length constraints (min & max)
		else if (strlen($this->sensor_name) < self::$MIN_SENSOR_NAME_LENGTH)
			$this->setError('sensor_name', 'SENSOR_NAME_TOO_SHORT');
		else if (strlen($this->sensor_name) > self::$MAX_SENSOR_NAME_LENGTH)
			$this->setError('sensor_name', 'SENSOR_NAME_TOO_LONG');
		// Only valid chars
		else if (!filter_var($this->sensor_name, FILTER_VALIDATE_REGEXP,
				array('options' => array('regexp' => "/^([a-zA-Z0-9\-\_.])+$/i")) )) {
			$this->setError('sensor_name', 'SENSOR_NAME_INVALID_CHARS');
		}
	}
	
	private function validateSensorType() {
		$this->sensor_type = $this->extractForm('sensor_type');
		
		// Not empty
		if (empty($this->sensor_type))
			$this->setError('sensor_type', 'SENSOR_TYPE_EMPTY');
		// Within the list of accepted sensor types
		else if (!in_array($this->sensor_type, self::$VALID_SENSOR_TYPES))
			$this->setError('sensor_type', 'SENSOR_TYPE_INVALID');
	}
	
	private function validateSensorUnits() {
		$this->sensor_units = $this->extractForm('sensor_units');
		
		// Not empty
		if (empty($this->sensor_units))
			$this->setError('sensor_units', 'SENSOR_UNITS_EMPTY');
		// Within the list of accepted sensor units
		else if (!in_array($this->sensor_units, self::$VALID_SENSOR_UNITS))
			$this->setError('sensor_units', 'SENSOR_UNITS_INVALID');
		// Sensor Unit & Sensor Type pair are legit
		// TODO: Define the Sensor Type/Unit constraint
	}
	
	private function validateSequenceType() {
		$this->sequence_type = $this->extractForm('sequence_type');
		
		// Not empty
		if (empty($this->sequence_type))
			$this->setError('sequence_type', 'SENSOR_SEQUENCE_TYPE_EMPTY');
		// Within the list of accepted sequence types (time-coded, sequential)
		if (!in_array($this->sequence_type, self::$VALID_SENSOR_SEQUENCE_TYPES))
			$this->setError('sequence_type', 'SENSOR_SEQUENCE_TYPE_INVALID');
	}
	
	private function validateDescription() {
		$this->description = $this->extractForm('description');
		
		// Within the length constraint
		if (!empty($this->description)) {
			if (strlen($this->description) > self::$MAX_DESCRIPTION_LENGTH)
				$this->setError('description', 'SENSOR_DESCRIPTION_TOO_LONG');
		}
	}
}
?>