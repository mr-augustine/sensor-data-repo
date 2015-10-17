<?php
class UserDataDB {

	// Inserts a UserData object into the UserData table and returns the userDataId
	public static function addUserData($userData) {
		
	}
	
	public static function getUserDataRowSetsBy($type = null, $value = null) {
		$allowedTypes = ['userId', 'user_name', 'skill_level', 'skill_area', 'robot_name'];
		$userDataRowSets = NULL;
		
		try {
			$db = Database::getDB();
			$query = "SELECT userDataId, userId, user_name, skill_level FROM UserData";
			
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for UserData");
				
				$query = $query . " WHERE ($type = :$type)";
				$statement = $db->prepare($query);
				$statement->bindParam(":$type", $value);
			} else // Don't apply the WHERE clause
				$statement = $db->prepare($query);
			
			$statement->execute();
			$userDataRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor();
		} catch (Exception $e) {
			echo "<p>Error getting user rows by $type: " . $e->getMessage() . "</p>";
		}
		
		return $userDataRowSets;
	}
	
	
	public static function getUserDataBy($type = null, $value = null) {
		$userDataRows = UserDataDB::getUserDataRowSetsBy($type, $value);
		
		return UserDataDB::getUserDataArray($userDataRows);
	}
	
	
	public static function getUserDataArray($rowSets) {
		$usersData = array();
		
		if (!empty($rowSets)) {
			foreach ($rowSets as $userDataRow) {
				$userData = new UserData($userDataRow);
				
				// The UserData constructor does not set the userDataId for
				// a new UserData object; the UserData table takes care of that
				// during insertion. Here we manually set the userDataId to
				// complete the UserData object.
				$userData->setUserDataId($userDataRow['userDataId']);
				array_push($usersData, $userData);
			}
		}
		
		return $usersData;
	}
	
	public static function getUserDataValuesBy($column, $type = null, $value = null) {
		$userDataRows = UserDataDB::getUserDataRowSetsBy($type, $value);
		
		return UserDataDB::getUserDataValues($userDataRows, $column);
	}
	
	public static function getUserDataValues($rowSets, $column) {
		$userDataValues = array();
		
		foreach ($rowSets as $userDataRow) {
			$userDataValue = $userDataRow[$column];
			array_push($userDataValues, $userDataValue);
		}
		
		return $userDataValues;
	}
}
?>