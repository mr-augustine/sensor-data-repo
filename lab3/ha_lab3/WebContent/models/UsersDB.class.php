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
			
			$db = Database::getDB ();
			$statement = $db->prepare ($query);
			$statement->bindValue(":email", $user->getEmail());
			$statement->bindValue(":password", $user->getPassword());
			$statement->execute ();
			$statement->closeCursor();
			$returnId = $db->lastInsertId("userId");
		} catch (Exception $e) { // Not permanent error handling
			$user->setError('userId', 'USER_INVALID');
		}
		
		return $user;
	}
	
	// Returns all rows in the Users table as an array of arrays 
	public static function getAllUsers() {
	   $query = "SELECT * FROM Users";
	   $users = array();
	   
	   try {
	      $db = Database::getDB();
	      $statement = $db->prepare($query);
	      $statement->execute();
	      $users = UsersDB::getUsersArray ($statement->fetchAll(PDO::FETCH_ASSOC));
	      $statement->closeCursor();
		} catch (PDOException $e) { // Not permanent error handling
			echo "<p>Error getting all users " . $e->getMessage () . "</p>";
		}
		
		return $users;
	}
	
	// Returns the rowsets of Users whose $type field has value $value
	// Rowsets will contain either a single column or all columns from the Users table
	public static function getUserRowSetsBy($type, $value, $column) {
		$allowedTypes = ["userId", "email"];
		$allowedColumns = ["userId", "email", "*"];
		$userRowSets = NULL;
	
		try {
			if (!in_array($type, $allowedTypes))
				throw new PDOException("$type not an allowed search criterion for User");
			elseif (!in_array($column, $allowedColumns))
			throw new PDOException("$column not a column of User");
				
			$query = "SELECT $column FROM Users WHERE ($type = :$type)";
			$db = Database::getDB();
			$statement = $db->prepare($query);
			$statement->bindParam(":$type", $value);
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
	public static function getUserValuesBy($type, $value, $column) {
		$userRows = UsersDB::getUserRowSetsBy($type, $value, $column);
	
		return UsersDB::getUserValues($userRows, $column);
	}
	
	// Returns an array of User objects extracted from $rowSets
	public static function getUsersArray($rowSets) {
		$users = array();
	
		if (!empty($rowSets)) {
			// Convert the array of arrays into an array of Users
			foreach ($rowSets as $userRow) {
				$user = new User($userRow);
				array_push ($users, $user);
			}
		}
		 
		return $users;
	}
	
	// Returns a User object whose $type field has value $value
	public static function getUsersBy($type, $value) {
		$userRows = UsersDB::getUserRowSetsBy($type, $value, '*');
		
		return UsersDB::getUsersArray($userRows);
	}
}

?>