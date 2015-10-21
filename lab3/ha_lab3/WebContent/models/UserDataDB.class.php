<?php
class UserDataDB {

	// Inserts a UserData object into the UserData table and returns the userDataId
	public static function addUserData($userData) {
		$query = "INSERT INTO UserData (userId, user_name, skill_level,  
				profile_pic, started_hobby, fav_color, url, phone) VALUES
				(:userId, :user_name, :skill_level, :profile_pic,
				:started_hobby, :fav_color, :url, :phone)";
		// TODO: Add a SkillAssoc query
		// TODO: Add a Robots query
		
		try {
			// check null and check for errors
			// check for User by given userId; throw exception if non-existent
			if (is_null($userData) || $userData->getErrorCount() > 0)
				throw new PDOException("Invalid UserData object can't be inserted: "/*.$userData->getErrorCount()." "
						.print_r($userData->getErrors(), true)*/);
			
			$newUserId = $userData->getUserId();
			
			if (!isset($newUserId))
				throw new PDOException("UserId not specified");
			
			// Verify that the specified user exists in the database
			$db = Database::getDB();
			$users = UsersDB::getUserValuesBy('userId', $newUserId, 'userId');
			if ($users[0] != $newUserId)
				throw new PDOException("Cannot associate UserData with invalid User");
			
			$statement = $db->prepare($query);
			$statement->bindValue(":userId", $newUserId);
			$statement->bindValue(":user_name", $userData->getUserName());
			$statement->bindValue(":skill_level", $userData->getSkillLevel());
			// TODO: Have the profile pic uploaded to a designated folder and moved
			$statement->bindValue(":profile_pic", $userData->getProfilePic());
			$statement->bindValue(":started_hobby", $userData->getStartedHobby());
			$statement->bindValue(":fav_color", $userData->getFavColor());
			$statement->bindValue(":url", $userData->getUrl());
			$statement->bindValue(":phone", $userData->getPhone());
			
			$statement->execute();
			$statement->closeCursor();
			$returnId = $db->lastInsertId("userDataId");
			
			$query = "INSERT INTO SkillAssocs (userDataId, skillId) VALUES
					(:userDataId, :skillId)";
			// Handle skill area associations separately since they're going into a different table
			// TODO: Review this for instances where this can go wrong

			foreach ($userData->getSkillAreas() as $skill) {
				// Translate the skill to a skillId, then create a skill association
				
				$skillArray = SkillsDB::getSkillsBy('skill_name', $skill);
				$skillObject = $skillArray[0];
				echo "skill_name: ".$skillObject->getSkillName();
				$skillstatement = $db->prepare($query);
				$skillstatement->bindValue(":userDataId", $returnId);
				$skillstatement->bindValue(":skillId", $skillObject->getSkillId());
				$skillstatement->execute();
				$skillstatement->closeCursor();
				$skillAssocId = $db->lastInsertId("skillAssocId");
			}
			
			$userData->setUserDataId($returnId);
		} catch (Exception $e) { // Not permanent error handling
			$userData->setError('userDataId', 'USER_DATA_INVALID');
			echo $e->getMessage();
		}
		
		return $userData;
	}
	
	public static function getUserDataRowSetsBy($type = null, $value = null) {
		$allowedTypes = ['userId', 'user_name', 'skill_level', 'skill_areas', 'robot_name'];
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