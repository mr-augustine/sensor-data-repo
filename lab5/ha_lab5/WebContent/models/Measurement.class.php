<?php
include_once("Messages.class.php");

class Measurement {
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
	
	public function getParameters() {
		$paramArray = array("measurement_id" => $this->measurement_id,
							"measurement_index" => $this->measurement_index,
							"measurement_value" => $this->measurement_value,
							"measurement_timestamp" => $this->measurement_timestamp,
							"sensor_id" => $this->sensor_id);
		
		return paramArray;
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
		$errors = array();
		
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
		$this->measurement_index = $this->extractForm('measurement_id');
		
		// Not empty
		if (empty($this->measurement_index))
			$this->setError('measurement_id', 'MEASUREMENT_ID_EMPTY');
		// Numeric & Non-negative
		else if (!is_numeric($this->measurement_index) ||
				$this->measurement_index < 0) {
			$this->setError('measurement_id', 'MEASUREMENT_ID_INVALID');	
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
				case "good":
					//something
					break;
				default:
					$this->setError('measurement_value', 'MEASUREMENT_VALUE_INVALID');
			}
		}
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
				else if (!timestampFormatValid($this->measurement_timestamp)) {
					$this->setError('measurement_timestamp', 'MEASUREMENT_TIMESTAMP_FORMAT_INVALID');			
				}
				// Timestamp represents a legitimate point in time
				else if (!timestampValueValid($this->measurement_timestamp)) {
					$this->setError('measurement_timestamp', 'MEASUREMENT_TIMESTAMP_VALUE_INVALID');
				}
				// Timestamp fall between Epoch and the current time
				else if (!timestampWithinValidRange($this->measurement_timestamp)) {
					$this->setError('measurement_timestamp', 'MEASUREMENT_TIMESTAMP_RANGE_INVALID');
				}
				break;
			case 'SEQUENTIAL':
				// Sequential measurements are ordered by index and don't have
				// associated timestamps
				$this->measurement_timestamp = null;
				break;
			default:
				$this->setError('measurement_timestamp', 'MEASUREMENT_TIMESTAMP_INVALID');
		}
	}

	private function timestampFormatValid($date) {
		// yyyy-dd-mm hh-mm-ss[.uuuuuu]
		$validTimestampFormatRegex = "/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}?(\.\d{1,6})$/";
		
		return filter_var($this->measurement_timestamp,
			FILTER_VALIDATE_REGEXP,
			array('options' => array('regexp' => $validTimestampFormatRegex)));
	}
	
	private function timestampValueValid($timestamp) {
		$measuredTimestamp = date_parse($timestamp);
		
		return ($measuredTimestamp['error_count'] == 0);
	}
	
	private function timestampWithinValidRange($timestamp) {
		$currentTimestamp = date_parse(date('Y'));
		
		// Return False if the specified timestamp occurs before Epoch year
		if (!($year >= 1970 && $year <= $currentTimestamp['year']))
			return false;
		
		$dateInterval = date_diff(date_create($timestamp), date_create(date('Y-M-D H:i:s.u')));
		$daysDifference = $dateInterval->format('%d');
		$daysDifference += 0;
		
		// Return True if current date follows the specified $timestamp
		return ($days >= 0);
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