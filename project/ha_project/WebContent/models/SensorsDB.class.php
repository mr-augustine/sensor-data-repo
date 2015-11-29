<?php
class SensorsDB {
	
	// Inserts a Sensor object into the Sensor table and returns
	// the Sensor with the sensor_id property set, if successful;
	// otherwise, returns the Sensor unchanged. Sets a sensor_id error
	// if there is a db issue.
	public static function addSensor($sensor) {
		$query = "INSERT INTO Sensors (dataset_id, sensor_name, sensor_type, sensor_units,
				sequence_type, description) VALUES (:dataset_id, :sensor_name, :sensor_type,
				:sensor_units, :sequence_type, :description)";
		
		try {
			if (is_null($sensor) || $sensor->getErrorCount() > 0)
				return $sensor;
			
			$db = Database::getDB();
			$statement = $db->prepare($query);
			$statement->bindValue(':dataset_id', $sensor->getDatasetId());
			$statement->bindValue(':sensor_name', $sensor->getSensorName());
			$statement->bindValue(':sensor_type', $sensor->getSensorType());
			$statement->bindValue(':sensor_units', $sensor->getSensorUnits());
			$statement->bindValue(':sequence_type', $sensor->getSequenceType());
			$statement->bindValue(':description', $sensor->getDescription());
			$statement->execute();
			$statement->closeCursor();
			
			$newSensorId = $db->lastInsertId('sensor_id');
			$sensor->setSensorId($newSensorId);
		} catch (Exception $e) {
			$sensor->setError('sensor_id', 'SENSOR_INVALID');
		}
		
		return $sensor;
	}
	
	// Returns an array of Sensors that meet the criteria specified.
	// If unsuccessful, this function returns an empty array.
	public static function getSensorsBy($type = null, $value = null) {
		$sensorRows = SensorsDB::getSensorRowsBy($type, $value);
		
		return SensorsDB::getSensorsArray($sensorRows);
	}
	
	// Returns an array of the rows from the Sensors table whose $type
	// field has value $value. Throws an exception if unsuccessful.
	public static function getSensorRowsBy($type = null, $value = null) {
		$allowedTypes = ['sensor_id', 'dataset_id', 'sensor_name'];
		$sensorRows = array();
		
		try {
			$db = Database::getDB();
			$query = "SELECT sensor_id, dataset_id, sensor_name, sensor_type, sensor_units, 
					sequence_type, description FROM Sensors";
			
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for Sensors");
				
				$query = $query . " WHERE ($type = :$type)";
				$statement = $db->prepare($query);
				$statement->bindParam(":$type", $value);
			} else {
				$query = $query . " ORDER BY sensor_id ASC";
				$statement = $db->prepare($query);
			}
			
			$statement->execute();
			$sensorRows = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor();
		} catch (Exception $e) {
			echo "<p>Error getting sensor rows by $type: ".$e->getMessage()."</p>";
		}
		
		return $sensorRows;
	}
	
	// Returns an array of Sensor objects extracted from $rows
	public static function getSensorsArray($rows) {
		$sensors = array();
		
		if (!empty($rows)) {
			// Convert the array of arrays into an array of Sensors
			// and set the id field
			foreach ($rows as $sensorRow) {
				$sensor = new Sensor($sensorRow);
				
				$sensorId = $sensorRow['sensor_id'];
				$sensor->setSensorId($sensorId);
				
				// TODO: We should also get the sensor's associated measurements
				// Coordinate this in the controller
				array_push($sensors, $sensor);
			}
		}
		
		return $sensors;
	}
	
	// Returns the $column of Sensors whose $type maches $value
	public static function getSensorsValuesBy($type = null, $value = null, $column) {
		$sensorRows = SensorsDB::getSensorRowsBy($type, $value);
		
		return SensorsDB::getSensorValues($sensorRows, $column);
	}
	
	// Returns an array of values from the $column extracted from $rows
	public static function getSensorValues($rows, $column) {
		$sensorValues = array();
		
		foreach ($row as $sensorRow) {
			$sensorValue = $sensorRow[$column];
			array_push($sensorValues, $sensorValue);
		}
		
		return $sensorValues;
	}
	
	// Updates a Sensor entry in the Sensors table
	// At this time, the dataset_id should not be modifiable
	public static function updateSensor($sensor) {
		try {
			$db = Database::getDB();
			
			if (is_null($sensor) || $sensor->getErrorCount() > 0)
				return $sensor;
			
			$checkSensor = SensorsDB::getSensorsBy('sensor_id', $sensor->getSensorId());
			
			if (empty($checkSensor)) {
				$sensor->setError('sensor_id', 'SENSOR_DOES_NOT_EXIST');
				return $sensor;
			}
			if ($sensor->getErrorCount() > 0)
				return $sensor;
			
			$query = "UPDATE Sensors SET sensor_name = :sensor_name,
					sensor_type = :sensor_type, sensor_units = :sensor_units,
					sequence_type = :sequence_type, description = :description 
					WHERE sensor_id = :sensor_id";
			
			$statement = $db->prepare($query);
			$statement->bindValue(':sensor_name', $sensor->getSensorName());
			$statement->bindValue(':sensor_type', $sensor->getSensorType());
			$statement->bindValue(':sensor_units', $sensor->getSensorUnits());
			$statement->bindValue(':sequence_type', $sensor->getSequenceType());
			$statement->bindValue(':description', $sensor->getDescription());
			$statement->bindValue(':sensor_id', $sensor->getSensorId());
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) {
			$sensor->setError('sensor_id', 'SENSOR_COULD_NOT_BE_UPDATED');
		}
		
		return $sensor;
	}
}
?>