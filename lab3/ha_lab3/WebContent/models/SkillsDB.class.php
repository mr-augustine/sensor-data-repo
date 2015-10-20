<?php
class SkillsDB {
	
	public static function addSkill($skill) {
		// NOT SUPPORTED YET
	}
	
	public static function getSkillsBy($type = null, $value = null) {
		$skillRows = SkillsDB::getSkillsRowsBy($type, $value);
		
		return SkillsDB::getSkillsArray($skillRows);
	}
	
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
			} else
				$statement = $db->prepare($query);

			$statement->execute();
			$skillRows = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor();
		} catch (Exception $e) {
			echo "<p>Error getting skill rows by $type: " . $e->getMessage() . "</p>";
		}
		
		return $skillRows;
	}
	
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
}
?>