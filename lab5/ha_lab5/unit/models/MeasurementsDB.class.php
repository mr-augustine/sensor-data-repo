<?php
class MeasurementsDB {
	
	// Inserts a Measurement object into the Measurements table and returns
	// the Measurement with the measurement_id property set, if successful;
	// otherwise, returns the Measurement unchanged. Sets a measurement_id error
	// if there is a db issue.
	public static function addMeasurement($measurement) {
		$query = "INSERT INTO Measurements (measurement_index, measurement_value,
				measurement_timestamp, sensor_id) VALUES (:measurement_index,
				:measurement_value, :measurement_timestamp, :sensor_id)";
		
		try {
			if (is_null($measurment) || $measurement->getErrorCount() > 0)
				return $measurement;
			
			$db = Database::getDB();
			$statement = $db->prepare($query);
			$statement->bindValue(":measurement_index", $measurement->getMeasurementIndex());
			$statement->bindValue(":measurement_value", $measurement->getMeasurementValue());
			$statement->bindValue(":measurement_timestamp", $measurement->getMeasurementTimestamp());
			$statement->bindValue(":sensor_id", $measurement->getSensorId());
			$statement->execute();
			$statement->closeCursor();
			$measurement->setMeasurementId($db->lastInsertId('measurement_id'));
		} catch (Exception $e) {
			$measurement->setError('measurement_id', 'MEASUREMENT_INVALID');
		}
		
		return $measurement;
	}
	
	// Returns an array of the rows from the Measurements table whose $type
	// field has value $value. Throws an exception if unsuccessful.
	public static function getMeasurementRowsBy($type = null, $value = null) {
		
	}

	// Returns an array of values from the $column extracted from $rows
	public static function getMeasurementValues($rows, $column) {
	
	}
	
	// Returns the $column of Measurements whose $type maches $value
	public static function getMeasurementsValuesBy($type = null, $value = null, $column) {
		
	}
	
	// Returns an array of Measurement objects extracted from $rows
	public static function getMeasurementsArray($rows) {
		
	}
	
	// Returns an array of Measurements that meet the criteria specified.
	// If unsuccessful, this function returns an empty array.
	public static function getMeasurementsBy($type = null, $value = null) {		
	}
	
	// Updates a Measurement entry in the Measurements table
	public static function updateMeasurement($measurement) {
		
	}
}
?>