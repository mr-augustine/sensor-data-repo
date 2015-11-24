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
			if (is_null($measurement) || $measurement->getErrorCount() > 0)
				return $measurement;
			
			$db = Database::getDB();
			$statement = $db->prepare($query);
			$statement->bindValue(":measurement_index", $measurement->getMeasurementIndex());
			$statement->bindValue(":measurement_value", $measurement->getMeasurementValue());
			$statement->bindValue(":measurement_timestamp", $measurement->getMeasurementTimestamp());
			$statement->bindValue(":sensor_id", $measurement->getSensorId());
			$statement->execute();
			$statement->closeCursor();
			
			$newMeasurementId = $db->lastInsertId('measurement_id');
			$measurement->setMeasurementId($newMeasurementId);
		} catch (Exception $e) {
			$measurement->setError('measurement_id', 'MEASUREMENT_INVALID');
		}
		
		return $measurement;
	}
	
	// Returns an array of Measurements that meet the criteria specified.
	// If unsuccessful, this function returns an empty array.
	public static function getMeasurementsBy($type = null, $value = null) {
		$measurementRows = MeasurementsDB::getMeasurementRowsBy($type, $value);
		
		return MeasurementsDB::getMeasurementsArray($measurementRows);
	}
	
	// Returns an array of the rows from the Measurements table whose $type
	// field has value $value. Throws an exception if unsuccessful.
	public static function getMeasurementRowsBy($type = null, $value = null) {
		$allowedTypes = ['measurement_id', 'sensor_id'];
		$measurementRows = array();
		
		try {
			$db = Database::getDB();
			$query = "SELECT measurement_id, measurement_index, measurement_value,
					measurement_timestamp, sensor_id FROM Measurements";
			
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for Measurements");
				
				$query = $query . " WHERE ($type = :$type)";
				$statement = $db->prepare($query);
				$statement->bindParam(":$type", $value);
			} else {
				$query = $query . " ORDER BY measurement_index ASC";
				$statement = $db->prepare($query);
			}
			
			$statement->execute();
			$measurementRows = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor();
		} catch (Exception $e) {
			echo "<p>Error getting measurement rows by $type: ".$e->getMessage()."</p>";
		}
		
		return $measurementRows;
	}

	// Returns an array of Measurement objects extracted from $rows
	public static function getMeasurementsArray($rows) {
		$measurements = array();
		
		if (!empty($rows)) {
			// Convert the array of arrays into an array of Measurements
			// and set the id field
			foreach ($rows as $measurementRow) {
				$measurement = new Measurement($measurementRow);
				
				$measurementId = $measurementRow['measurement_id'];
				$measurement->setMeasurementId($measurementId);
				
				array_push($measurements, $measurement);
			}
		}
		
		return $measurements;
	}
	
	// Returns the $column of Measurements whose $type maches $value
	public static function getMeasurementsValuesBy($type = null, $value = null, $column) {
		$measurementRows = MeasurementsDB::getMeasurementRowsBy($type, $value);
		
		return MeasurementsDB::getMeasurementValues($measurementRows, $column);
	}
	
	// Returns an array of values from the $column extracted from $rows
	public static function getMeasurementValues($rows, $column) {
		$measurementValues = array();
		
		foreach ($row as $measurementRow) {
			$measurementValue = $measurementRow[$column];
			array_push($measurementValues, $measurementValue);
		}
		
		return $measurementValues;
	}
	
	// Updates a Measurement entry in the Measurements table
	public static function updateMeasurement($measurement) {
		try {
			$db = Database::getDB();
			
			if (is_null($measurement) || $measurement->getErrorCount() > 0)
				return $measurement;
			
			$checkMeasurement = MeasurementsDB::getMeasurementsBy('measurement_id',
					$measurement->getMeasurementId());
			
			if (empty($checkMeasurement)) {
				$measurement->setError('measurement_id', 'MEASUREMENT_DOES_NOT_EXIST');
				return $measurement;
			}
			if ($measurement->getErrorCount() > 0)
				return $measurement;
			
			$query = "UPDATE Measurements SET measurement_index = :measurement_index,
					measurement_value = :measurement_value, measurement_timestamp = :measurement_timestamp,
					sensor_id = :sensor_id WHERE measurement_id = :measurement_id";
			
			$statement = $db->prepare($query);
			$statement->bindValue(':measurement_index', $measurement->getMeasurementIndex());
			$statement->bindValue(':measurement_value', $measurement->getMeasurementValue());
			$statement->bindValue(':measurement_timestamp', $measurement->getMeasurementTimestamp());
			$statement->bindValue(':sensor_id', $measurement->getSensorId());
			$statement->bindValue(':measurement_id', $measurement->getMeasurementId());
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) {
			$measurement->setError('measurement_id', 'MEASUREMENT_COULD_NOT_BE_UPDATED');
			//echo $e->getMessage();
			//echo 'file: '.$e->getFile().' line: '.$e->getLine();
		}
		
		return $measurement;
	}
}
?>