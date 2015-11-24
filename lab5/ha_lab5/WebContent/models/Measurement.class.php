<?php
include_once("Messages.class.php");

class Measurement {
	public static $VALID_IMAGE_TYPES = array('COLOR', 'INFRARED', 'GRAYSCALE');
	public static $VALID_BINARY_VALUES = array('YES', 'NO', 'TRUE', 'FALSE', '1', '0', 'ON', 'OFF');
	public static $VALID_DIRECTIONS = array('FORWARD', 'REVERSE', 'LEFT', 'RIGHT', 'NORTH', 'SOUTH', 'EAST', 'WEST');
	
	private $errorCount;
	private $errors;
	private $formInput;
	
	private $measurement_id;
	private $measurement_index;
	private $measurement_value;
	private $measurement_timestamp;
	private $sensor_id;
	
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
	
	public function getMeasurementId() {
		return $this->measurement_id;
	}
	
	public function setMeasurementId($id) {
		$this->measurement_id = $id;
	}
	
	public function getMeasurementIndex() {
		return $this->measurement_index;
	}
	
	public function getMeasurementValue() {
		return $this->measurement_value;
	}
	
	public function getMeasurementTimestamp() {
		return $this->measurement_timestamp;
	}
	
	public function getSensorId() {
		return $this->sensor_id;
	}
	
	public function getParameters() {
		$paramArray = array("measurement_id" => $this->measurement_id,
							"measurement_index" => $this->measurement_index,
							"measurement_value" => $this->measurement_value,
							"measurement_timestamp" => $this->measurement_timestamp,
							"sensor_id" => $this->sensor_id);
		
		return $paramArray;
	}
	
	public function __toString() {
		$objectString = "[Measurement] {id: ".$this->measurement_id.", index: ".
			$this->measurement_index.", value: ".$this->measurement_value.
			", timestamp: ".$this->measurement_timestamp.", sensor_id: ".
			$this->sensor_id."}";
		
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
			$this->validateMeasurementIndex();
			$this->validateMeasurementValue();
			$this->validateMeasurementTimestamp();
			$this->validateSensorId();
		} else {
			$this->initializeEmpty();
		}
	}
	
	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
		$this->measurement_id = "";
		$this->measurement_index = "";
		$this->measurement_value = "";
		$this->measurement_timestamp = "";
		$this->sensor_id = "";
	}
	
	private function validateMeasurementIndex() {
		$this->measurement_index = $this->extractForm('measurement_index');
		
		// Not empty
		if (empty($this->measurement_index))
			$this->setError('measurement_index', 'MEASUREMENT_INDEX_EMPTY');
		// Numeric & Greater than 0
		else if (!is_numeric($this->measurement_index) ||
				$this->measurement_index < 1) {
			$this->setError('measurement_index', 'MEASUREMENT_INDEX_INVALID');	
		}

	}
	
	private function validateMeasurementValue() {
		// Needs the context of what units are being used
		// Maybe passed through the form by the Controller: formInput['sensorType']
		$this->measurement_value = $this->extractForm('measurement_value');
		
		// Not empty
		if (empty($this->measurement_value))
			$this->setError('measurement_value', 'MEASUREMENT_VALUE_EMPTY');
		// Use a switch-case block
		else {
			$sensorType = $this->extractForm('sensorType');
			
			switch ($sensorType) {
				case 'ALTITUDE':
					if (!$this->validAltitudeValue($this->measurement_value))
						$this->setError('measurement_value', 'MEASUREMENT_VALUE_INVALID_ALTITUDE');
					break;
				case 'BINARY':
					if (!$this->validBinaryValue($this->measurement_value))
						$this->setError('measurement_value', 'MEASUREMENT_VALUE_INVALID_BINARY');
					break;
				case 'COUNT':
					if (!$this->validCountValue($this->measurement_value))
						$this->setError('measurement_value', 'MEASUREMENT_VALUE_INVALID_COUNT');
					break;
				case 'DIRECTION':
					if (!$this->validDirectionValue($this->measurement_value))
						$this->setError('measurement_value', 'MEASUREMENT_VALUE_INVALID_DIRECTION');
					break;
				case 'DISTANCE':
					if (!$this->validDistanceValue($this->measurement_value))
						$this->setError('measurement_value', 'MEASUREMENT_VALUE_INVALID_DISTANCE');
					break;
				case 'HEADING':
					if (!$this->validHeadingValue($this->measurement_value))
						$this->setError('measurement_value', 'MEASUREMENT_VALUE_INVALID_HEADING');
					break;
				case 'IMAGE':
					if (!$this->validImageValue($this->measurement_value))
						$this->setError('measurement_value', 'MEASUREMENT_VALUE_INVALID_IMAGE');
					break;
				case 'LATITUDE':
					if (!$this->validLatitudeValue($this->measurement_value))
						$this->setError('measurement_value', 'MEASUREMENT_VALUE_INVALID_LATITUDE');
					break;
				case 'LONGITUDE':
					if (!$this->validLongitudeValue($this->measurement_value))
						$this->setError('measurement_value', 'MEASUREMENT_VALUE_INVALID_LONGITUDE');
					break;
				case 'RANGE':
					if (!$this->validRangeValue($this->measurement_value))
						$this->setError('measurement_value', 'MEASUREMENT_VALUE_INVALID_RANGE');
					break;
				case 'RATE':
					if (!$this->validRateValue($this->measurement_value))
						$this->setError('measurement_value', 'MEASUREMENT_VALUE_INVALID_RATE');
					break;
				case 'TEMPERATURE':
					if (!$this->validTemperatureValue($this->measurement_value))
						$this->setError('measurement_value', 'MEASUREMENT_VALUE_INVALID_TEMPERATURE');
					break;
				default:
					$this->setError('measurement_value', 'MEASUREMENT_VALUE_INVALID');
			}
		}
	}
	
	private function validAltitudeValue($altitude) {
		// Numeric and non-negative
		return (is_numeric($altitude) && $altitude >= 0);
	}
	
	private function validBinaryValue($binary) {
		// Within list of accepted binary values
		return (in_array($binary, self::$VALID_BINARY_VALUES));
	}
	
	private function validCountValue($count) {
		// Numeric and non-negative
		return (is_numeric($count) && $count >= 0);
	}
	
	private function validDirectionValue($direction) {
		// Within list of accepted direction values
		// Forward, reverse, left, right, NSEW
		return (in_array($direction, self::$VALID_DIRECTIONS));
	}
	
	private function validDistanceValue($distance) {
		// Numeric
		return (is_numeric($distance));
	}
	
	private function validHeadingValue($heading) {
		// Numeric and within range 0..360 exclusive
		return (is_numeric($heading) && $heading >= 0 && $heading <= 360);
	}
	
	private function validImageValue($image) {
		// Within list of accepted image types
		return (in_array($image, self::$VALID_IMAGE_TYPES));
	}

	private function validLatitudeValue($latitude) {
		// Numeric and within range -90..90 inclusive
		return (is_numeric($latitude) && $latitude >= -90 && $latitude <= 90);
	}
	
	private function validLongitudeValue($longitude) {
		// Numeric and within range -180..180 inclusive
		return (is_numeric($longitude) && $longitude >= -180 && $longitude <= 180);
	}

	private function validRangeValue($range) {
		// Numeric and non-negative
		return (is_numeric($range) && $range >= 0);
	}
	
	private function validRateValue($rate) {
		// Numeric
		return (is_numeric($rate));
	}
	
	private function validTemperatureValue($temperature) {
		// Numeric
		return (is_numeric($temperature));
	}
	
	private function validateMeasurementTimestamp() {
		// Needs the context of what sequence type is being used
		// Maybe passed through the form by the Controller: formInput['sequenceType']
		$this->measurement_timestamp = $this->extractForm('measurement_timestamp');

		$sensorSequenceType = $this->extractForm('sequenceType');
		switch ($sensorSequenceType) {
			case 'TIME_CODED':
				// Non-empty
				if (empty($this->measurement_timestamp))
					$this->setError('measurement_timestamp', 'MEASUREMENT_TIMESTAMP_EMPTY');
				// Timestamp Format
				else if (!$this->validTimestampFormat($this->measurement_timestamp)) {
					$this->setError('measurement_timestamp', 'MEASUREMENT_TIMESTAMP_FORMAT_INVALID');			
				}
				// Timestamp represents a legitimate point in time
				else if (!$this->validTimestampValue($this->measurement_timestamp)) {
					$this->setError('measurement_timestamp', 'MEASUREMENT_TIMESTAMP_VALUE_INVALID');
				}
				// Timestamp fall between Epoch and the current time
				else if (!$this->timestampWithinValidRange($this->measurement_timestamp)) {
					$this->setError('measurement_timestamp', 'MEASUREMENT_TIMESTAMP_RANGE_INVALID');
				}
				break;
			case 'SEQUENTIAL':
				// Sequential measurements are ordered by index and don't have
				// associated timestamps
				// However, if this is a sequential measurement that already has
				// a timestamp, preserve it.
				if (!empty($this->measurement_timestamp))
					break;
				
				// Otherwise, set it to an empty string
				$this->measurement_timestamp = '';
				break;
			default:
				$this->setError('measurement_timestamp', 'MEASUREMENT_TIMESTAMP_INVALID');
		}
	}

	private function validTimestampFormat($date) {
		// yyyy-dd-mm hh-mm-ss[.uuuuuu]
		$validTimestampFormatRegex = "/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}(\.\d{1,6})?$/";
		
		return filter_var($this->measurement_timestamp,
			FILTER_VALIDATE_REGEXP,
			array('options' => array('regexp' => $validTimestampFormatRegex)));
	}
	
	private function validTimestampValue($timestamp) {
		$measuredTimestamp = date_parse($timestamp);
		
		return ($measuredTimestamp['error_count'] == 0);
	}
	
	private function timestampWithinValidRange($timestamp) {
		$measuredTimestamp = date_parse($timestamp);
		$currentTimestamp = date_parse(date('Y-m-d'));
		
		// Return False if the specified timestamp occurs before Epoch year
		if (!($measuredTimestamp['year'] >= 1970 && $measuredTimestamp['year'] <= $currentTimestamp['year']))
			return false;
		
		$dateInterval = date_diff(date_create($timestamp), date_create(date('Y-m-d H:i:s.u')));
		$daysDifference = $dateInterval->format('%d');
		$daysDifference += 0;
		
		// Return True if current date follows the specified $timestamp
		return ($daysDifference >= 0);
	}
	
	private function validateSensorId() {
		$this->sensor_id = $this->extractForm('sensor_id');
		
		// Not empty
		if (empty($this->sensor_id))
			$this->setError('sensor_id', 'SENSOR_ID_EMPTY');

		// Non-negative
		else if (!is_numeric($this->sensor_id) || $this->sensor_id < 0)
			$this->setError('sensor_id', 'SENSOR_ID_INVALID');
	}	
	
}
?>