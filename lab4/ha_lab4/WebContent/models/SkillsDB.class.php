<?php
class SkillsDB {
	
	public static function addSkill($skill) {
		// NOT SUPPORTED YET
	}
	
	// Returns an array of Skills that meet the criteria specified. Typically
	// this function will return an array with one element if successful.
	// If unsuccessful, this function returns an empty array.
	public static function getSkillsBy($type = null, $value = null) {
		$skillRows = SkillsDB::getSkillsRowsBy($type, $value);
		
		return SkillsDB::getSkillsArray($skillRows);
	}
	
	// Returns an array of the rows from the Skills table whose $type field
	// has value $value. Throws an exception if unsuccessful.
	public static function getSkillsRowsBy($type, $value) {
		$allowedTypes = ["skillId", "skill_name"];
		$skillRows = array();
		
		try {
			$db = Database::getDB();
			$query = "SELECT skillId, skill_name FROM Skills";
			
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type is not an allowed search criterion for Skills");
				
				$query = $query . " WHERE ($type = :$type)";
				$statement = $db->prepare($query);
				$statement->bindParam(":$type", $value);
			} else {
				$query = $query . " ORDER BY skillId ASC";
				$statement = $db->prepare($query);
			}

			$statement->execute();
			$skillRows = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor();
		} catch (Exception $e) {
			echo "<p>Error getting skill rows by $type: " . $e->getMessage() . "</p>";
		}
		
		return $skillRows;
	}
	
	// Returns an array of Skill objects extracted from $rowSets
	public static function getSkillsArray($rows) {
		$skills = array();
		
		if (!empty($rows)) {
			foreach ($rows as $row) {
				$skill = new Skill($row);
				$skill->setSkillId($row['skillId']);
				array_push($skills, $skill);
			}
		}
		
		return $skills;
	}
	
	public static function updateSkill($skill) {
		// THIS PROBABLY SHOULD NOT BE SUPPORTED UNTIL THE SKILL CLASS CAN
		// SOURCE ITS LIST OF VALID SKILLS FROM THE DATABASE *AND*
		// KEEP THE LIST IN SYNC
// 		try {
// 			$db = Database::getDB();
			
// 			if (is_null($skill) || $skill->getErrorCount() > 0)
// 				return $skill;
			
// 			$checkSkill = SkillsDB::getSkillsBy('skillId', $skill->getSkillId());
			
// 			if (empty($checkSkill))
// 				$skill->setError('skillId', 'SKILL_DOES_NOT_EXIST');
// 			if ($skill->getErrorCount() > 0)
// 				return $skill;
			
// 			$query = "UPDATE Skills SET skill_name = :skill_name
// 					WHERE skillId = :skillId";
			
// 			$statement = $db->prepare($query);
// 			$statement->bindValue(":skill_name", $skill->getSkillName());
// 			$statement->bindValue(":skillId", $skill->getSkillId());
// 			$statement->execute();
// 			$statement->closeCursor();
// 		} catch (Exception $e) {
// 			$skill->setError('skillId', 'SKILL_COULD_NOT_BE_UPDATED');
// 		}
		
// 		return $skill;
	}
}
?>