<?php
class RobotAssocsDB {
	
	// Inserts a RobotAssoc object into the RobotAssocs table and returns
	// the RobotAssoc with the robotAssocId property set, if successful;
	// otherwise, returns the RobotAssoc unchanged. Sets a robotAssocId error
	// if there is a db issue.
	public static function addRobotAssoc($robotAssoc) {
		$query = "INSERT INTO RobotAssocs (robotId, creatorId)
				VALUES (:robotId, :creatorId)";
		
		try {
			if (is_null($robotAssoc) || $robotAssoc->getErrorCount() > 0)
				return $robotAssoc;
			
			$db = Database::getDB();
			$statement = $db->prepare($query);
			$statement->bindValue(":robotId", $robotAssoc->getRobotId());
			$statement->bindValue(":creatorId", $robotAssoc->getCreatorId());
			$statement->execute();
			$statement->closeCursor();
			
			$robotAssoc->setRobotAssocId($db->lastInsertId("robotAssocId"));
		} catch (Exception $e) {
			$robotAssoc->setError('robotAssocId', 'ROBOT_ASSOC_INVALID');
		}
		
		return $robotAssoc;
	}
	
	// Returns an array of RobotAssocs that meet the criteria specified. Typically
	// this function will return an array with one element if successful.
	// If unsuccessful, this function returns an empty array.
	public static function getRobotAssocsBy($type = null, $value = null) {
		$robotAssocsRows = RobotAssocsDB::getRobotAssocsRowsBy($type, $value);
		
		return RobotAssocsDB::getRobotAssocsArray($robotAssocsRows);
	}
	
	// Returns an array of the rows from the RobotAssocs table whose $type field
	// has value $value. Throws an exception if unsuccessful.
	public static function getRobotAssocsRowsBy($type, $value) {
		$allowedTypes = ["robotAssocId", "robotId", "creatorId"];
		$robotAssocsRows = array();
		
		try {
			$db = Database::getDB();
			$query = "SELECT robotAssocId, robotId, creatorId from RobotAssocs";
			
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type is not an allowed search criterion for RobotAssocs");
				
				$query = $query . " WHERE ($type = :$type)";
				$statement = $db->prepare($query);
				$statement->bindParam(":$type", $value);
			} else {
				$query = $query . " ORDER BY robotAssocId ASC";
				$statement = $db->prepare($query);
			}
			
			$statement->execute();
			$robotAssocsRows = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor();
		} catch (Exception $e) {
			echo "<p>Error getting robot assoc rows by $type: " . $e->getMessage() . "</p>";
		}
		
		return $robotAssocsRows;
	}
	
	// Returns an array of RobotAssoc objects extracted from $robotAssocsRows
	public static function getRobotAssocsArray($robotAssocsRows) {
		$robotAssocs = array();
		
		if (!empty($robotAssocsRows)) {
			foreach ($robotAssocsRows as $row) {
				$robotAssoc = new RobotAssoc($row['robotId'], $row['creatorId']);
				$robotAssoc->setRobotAssocId($row['robotAssocId']);
				array_push($robotAssocs, $robotAssoc);
			}
		}
		
		return $robotAssocs;
	}
	
	// Returns the $column of RobotAssoc whose $type matches $value
	public static function getRobotAssocValuesBy($type = null, $value = null, $column) {
		$robotAssocsRows = RobotAssocsDB::getRobotAssocsRowsBy($type, $value);
		
		return RobotAssocsDB::getRobotAssocsValues($robotAssocsRows, $column);
	}
	
	// Returns an array of values from the $column extracted from $rowSets
	public static function getRobotAssocsValues($rowSets, $column) {
		$robotAssocValues = array();
		
		foreach ($rowSets as $robotAssocRow) {
			$robotAssocValue = $robotAssocRow[$column];
			array_push($robotAssocValues, $robotAssocValue);
		}
		
		return $robotAssocValues;
	}
}
?>