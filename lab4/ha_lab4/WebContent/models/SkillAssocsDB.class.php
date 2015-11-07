<?php
class SkillAssocsDB {
	
	// Inserts a SkillAssoc object into the SkillAssocs table and returns 
	// the SkillAssoc with the skillAssocId property set, if successful; 
	// otherwise, returns the SkillAssoc unchanged. Sets a skillAssocId error 
	// if there is a db issue.
	public static function addSkillAssoc($skillAssoc) {
		$query = "INSERT INTO SkillAssocs (skillId, userDataId)
				VALUES (:skillId, :userDataId)";
		
		try {
			if (is_null($skillAssoc) || $skillAssoc->getErrorCount() > 0)
				return $skillAssoc;
			
			$db = Database::getDB();
			$statement = $db->prepare($query);
			$statement->bindValue(":skillId", $skillAssoc->getSkillId());
			$statement->bindValue(":userDataId", $skillAssoc->getUserDataId());
			$statement->execute();
			$statement->closeCursor();
			
			$skillAssoc->setSkillAssocId($db->lastInsertId("skillAssocId"));
		} catch (Exception $e) {
			$skillAssoc->setError('skillAssocId', 'SKILL_ASSOC_INVALID');
		}
		
		return $skillAssoc;
	}
	
	// Returns an array of SkillAssocs that meet the criteria specified. Typically
	// this function will return an array with one element if successful.
	// If unsuccessful, this function returns an empty array.
	public static function getSkillAssocsBy($type = null, $value = null) {
		$skillAssocsRows = SkillAssocsDB::getSkillAssocsRowsBy($type, $value);
		
		return SkillAssocsDB::getSkillAssocsArray($skillAssocsRows);
	}
	
	// Returns an array of the rows from the SkillAssocs table whose $type field
	// has value $value. Throws an exception if unsuccessful.
	public static function getSkillAssocsRowsBy($type, $value) {
		$allowedTypes = ["skillAssocId", "skillId", "userDataId"];
		$skillAssocsRows = array();
		
		try {
			$db = Database::getDB();
			$query = "SELECT skillAssocId, skillId, userDataId FROM SkillAssocs";
			
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type is not an allowed search criterion for SkillAssocs");
				
				$query = $query . " WHERE ($type = :$type)";
				$statement = $db->prepare($query);
				$statement->bindParam(":$type", $value);
			} else {
				$query = $query . " ORDER BY skillAssocId ASC";
				$statement = $db->prepare($query);
			}
			
			$statement->execute();
			$skillAssocsRows = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor();
		} catch (Exception $e) {
			echo "<p>Error getting skill assoc rows by $type: " . $e->getMessage() . "</p>";
		}
		
		return $skillAssocsRows;
	}
	
	// Returns an array of SkillAssoc objects extracted from $rowSets
	public static function getSkillAssocsArray($skillAssocsRows) {
		$skillAssocs = array();
		
		if (!empty($skillAssocsRows)) {
			foreach ($skillAssocsRows as $row) {
				$skillAssoc = new SkillAssocs($row['userDataId'], $row['skillId']);
				$skillAssoc->setSkillAssocId($row['skillAssocId']);
				array_push($skillAssocs, $skillAssoc);
			}
		}
		
		return $skillAssocs;
	}
}
?>