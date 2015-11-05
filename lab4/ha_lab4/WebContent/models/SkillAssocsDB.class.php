<?php
class SkillAssocsDB {
	
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
	
	public static function getSkillAssocsBy($type = null, $value = null) {
		$skillAssocsRows = SkillAssocsDB::getSkillAssocsRowsBy($type, $value);
		
		return SkillAssocsDB::getSkillAssocsArray($skillAssocsRows);
	}
	
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