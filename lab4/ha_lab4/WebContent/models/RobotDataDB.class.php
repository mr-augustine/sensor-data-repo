<?php
class RobotDataDB {
	
	// Inserts a RobotData object into the RobotData table and returns the
	// RobotData with the robotId property set, if successful; otherwise,
	// returns the RobotData unchanged. Sets a robotId error if there is
	// a db issue.
	public static function addRobotData($robotData) {
		$query = "INSERT INTO RobotData (robot_name, status) VALUES
				(:robot_name, :status)";
		
		try {
			if (is_null($robotData) || $robotData->getErrorCount() > 0)
				throw new PDOException("Invalid RobotData object can't be inserted: ");
			
			$db = Database::getDB();
			$statement = $db->prepare($query);
			$statement->bindValue(":robot_name", $robotData->getRobotName());
			$statement->bindValue(":status", $robotData->getStatus());
			$statement->execute();
			$statement->closeCursor();
			$returnId = $db->lastInsertId("robotId");
			
			$robotData->setRobotId($returnId);
		} catch (Exception $e) {
			$robotData->setError('robotId', 'ROBOT_DATA_INVALID');
		}
		
		return $robotData;
	}

	// Returns an array of the rows from the RobotData table whose $type field
	// has value $value. Throws an exception if unsuccessful.
	public static function getRobotDataRowSetsBy($type = null, $value = null) {
		$allowedTypes = ['robotId', 'robotId', 'robot_name', 'status'];
		$robotDataRowSets = array();
		
		try {
			$db = Database::getDB();
			$query = "SELECT robotId, robot_name, status FROM RobotData";
			
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for RobotData");
				
				$query = $query . " WHERE ($type = :$type)";
				$statement = $db->prepare($query);
				$statement->bindParam(":type", $value);
			} else {
				$query = $query . " ORDER BY robotId ASC";
				$statement = $db->prepare($query);
			}
			
			$statement->execute();
			$robotDataRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor();
		} catch (Exception $e) {
			echo "<p>Error getting robot data rows by $type: " . $e->getMessage(). "</p>";
		}
		
		return $robotDataRowSets;
	}
	
	// Returns an array of RobotData that meet the criteria specified.
	// If unsuccessful, this function returns an empty array.
	public static function getRobotDataBy($type = null, $value = null) {
		$robotDataRows = RobotDataDB::getRobotDataRowSetsBy($type, $value);
		
		return RobotDataDB::getRobotDataArray($robotDataRows);
	}
	
	// Returns an array of RobotData objects extracted from $rowSets
	public static function getRobotDataArray($rowSets) {
		$robotsData = array();
		
		if (!empty($rowSets)) {
			foreach ($rowSets as $robotDataRow) {
				$robotDataRow['creators'] = RobotAssocsDB::getRobotAssocValuesBy('robotId', $robotDataRow['robotId'], "creatorId");
				
				$robotData = new RobotData($robotDataRow);
				$robotId = $robotDataRow['robotId'];
				$robotData->setRobotId($robotId);

				array_push($robotsData, $robotData);
			}
		}
		
		return $robotsData;
	}
	
	// Returns the $column of RobotData whose $type matches $value
	public static function getRobotDataValuesBy($type = null, $value = null, $column) {
		$robotDataRows = RobotDataDB::getRobotDataRowSetsBy($type, $value);
		
		return RobotDataDB::getRobotDataValues($robotDataRows, $column);
	}
	
	// Returns an array of values from the $column extracted from $rowSets
	public static function getRobotDataValues($rowSets, $column) {
		$robotDataValues = array();
		
		foreach ($rowSets as $robotDataRow) {
			$robotDataValue = $robotDataRow[$column];
			array_push($robotDataValues, $robotDataValue);
		}
		
		return $robotDataValues;
	}
	
	public static function updateRobotData($robotData) {
		
	}
}
?>