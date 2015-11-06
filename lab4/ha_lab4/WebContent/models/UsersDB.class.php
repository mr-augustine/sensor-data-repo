<?php
class UsersDB {
	
	// Inserts a User object into the Users table and returns the User
	// with the userId property set, if successful
	public static function addUser($user) {
		$query = "INSERT INTO Users (email, password)
		                      VALUES(:email, :password)";
		
		try {
			if (is_null($user) || $user->getErrorCount() > 0)
				return $user;
			
			$db = Database::getDB();
			$statement = $db->prepare($query);
			$statement->bindValue(":email", $user->getEmail());
			$statement->bindValue(":password", $user->getPassword());
			$statement->execute();
			$statement->closeCursor();
			$user->setUserId($db->lastInsertId("userId"));
		} catch (Exception $e) { // Not permanent error handling
			$user->setError('userId', 'USER_INVALID');
		}
		
		return $user;
	}
		
	// Returns the rowsets of Users whose $type field has value $value
	// Rowsets will contain either a single column or all columns from the Users table
	public static function getUserRowSetsBy($type = null, $value = null) {
		$allowedTypes = ["userId", "email"];
		$userRowSets = array();
	
		try {
			$db = Database::getDB();
			$query = "SELECT userId, email, password FROM Users";
			
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for User");
			
				$query = $query . " WHERE ($type = :$type)";
				$statement = $db->prepare($query);
				$statement->bindParam(":$type", $value);
			} else {
				$query = $query . " ORDER BY userId ASC";
				$statement = $db->prepare($query);
			}
			
			$statement->execute();
			$userRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor();
		} catch (PDOException $e) { // Not permanent error handling
			echo "<p>Error getting user rows by $type: " . $e->getMessage() . "</p>";
		}
	
		return $userRowSets;
	}
	
	// Returns values in the $column extracted from $rowSets as an array
	public static function getUserValues($rowSets, $column) {
		$userValues = array();
		//print_r($rowSets);
	
		foreach ($rowSets as $userRow )  {
			$userValue = $userRow[$column];
			array_push ($userValues, $userValue);
		}
	
		return $userValues;
	}
	
	// Returns the userId of the user whose $type field has value $value
	public static function getUserValuesBy($type = null, $value = null, $column) {
		$userRows = UsersDB::getUserRowSetsBy($type, $value);
	
		return UsersDB::getUserValues($userRows, $column);
	}
	
	// Returns an array of User objects extracted from $rowSets
	public static function getUsersArray($rowSets) {
		$users = array();
	
		if (!empty($rowSets)) {
			// Convert the array of arrays into an array of Users
			foreach ($rowSets as $userRow) {
				$user = new User($userRow);
				$user->setUserId($userRow['userId']);
				array_push ($users, $user);
			}
		}
		 
		return $users;
	}
	
	// Returns an array of Users that meet the criteria specified. Typically
	// this function will return an array with one element if successful.
	// If unsuccessful, this function returns an empty array.
	public static function getUsersBy($type = null, $value = null) {
		$userRows = UsersDB::getUserRowSetsBy($type, $value);
		
		return UsersDB::getUsersArray($userRows);
	}
	
	public static function updateUser($user) {
		try {
			$db = Database::getDB();
			
			if (is_null($user) || $user->getErrorCount() > 0)
				return $user;
			
			$checkUser = UsersDB::getUsersBy('userId', $user->getUserId());
			
			if (empty($checkUser))
				$user->setError('userId', 'USER_DOES_NOT_EXIST');
			if ($user->getErrorCount() > 0)
				return $user;
			
			$query = "UPDATE Users SET email = :email, password = :password
					WHERE userId = :userId";
			
			$statement = $db->prepare($query);
			$statement->bindValue(":email", $user->getEmail());
			$statement->bindValue(":password", $user->getPassword());
			$statement->bindValue(":userId", $user->getUserId());
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) {
			$user->setError('userId', 'USER_COULD_NOT_BE_UPDATED');
		}
		
		return $user;
	}
}

?>