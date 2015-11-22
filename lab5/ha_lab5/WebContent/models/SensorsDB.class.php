<?php
class SensorsDB {
	
	// Inserts a Sensor object into the Sensor table and returns
	// the Sensor with the sensor_id property set, if successful;
	// otherwise, returns the Sensor unchanged. Sets a sensor_id error
	// if there is a db issue.
	public static function addSensor($Sensor) {
		
	}
	
	// Returns an array of the rows from the Sensors table whose $type
	// field has value $value. Throws an exception if unsuccessful.
	public static function getSensorRowsBy($type = null, $value = null) {
	
	}
	
	// Returns an array of values from the $column extracted from $rows
	public static function getSensorValues($rows, $column) {
	
	}
	
	// Returns the $column of Sensors whose $type maches $value
	public static function getSensorsValuesBy($type = null, $value = null, $column) {
	
	}
	
	// Returns an array of Sensor objects extracted from $rows
	public static function getSensorsArray($rows) {
	
	}
	
	// Returns an array of Sensors that meet the criteria specified.
	// If unsuccessful, this function returns an empty array.
	public static function getSensorsBy($type = null, $value = null) {
	}
	
	// Updates a Sensor entry in the Sensors table
	public static function updateSensor($sensor) {
	
	}
}
?>