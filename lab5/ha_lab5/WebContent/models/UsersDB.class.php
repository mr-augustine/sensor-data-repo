<?php
class UsersDB {
	
	// Inserts a User object into the User table and returns
	// the User with the user_id property set, if successful;
	// otherwise, returns the User unchanged. Sets a user_id error
	// if there is a db issue.
	public static function addUser($user) {
		$query = 'INSERT INTO Users (username, password)
				VALUES (:username, :password)';
		
		try {
			if (is_null($user) || $user->getErrorCount() > 0)
				return $user;
			
			$db = Database::getDB();
			$statement = $db->prepare($query);
			$statement->bindValue(':username', $user->getUsername());
			$statement->bindValue(':password', $user->getPassword());
			$statement->execute();
			$statement->closeCursor();
			$user->setUserId($db->lastInsertId('user_id'));
		} catch (Exception $e) {
			$user->setError('user_id', 'USER_INVALID');
		}
		
		return $user;
	}
	
	// Returns an array of the rows from the Users table whose $type
	// field has value $value. Throws an exception if unsuccessful.
	public static function getUserRowsBy($type = null, $value = null) {
		$allowedTypes = ['user_id', 'username'];
		$userRows = array();

		try {
			$db = Database::getDB();
			$query = 'SELECT user_id, username, password FROM Users';
			
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for User");
				
				$query = $query . " WHERE ($type = :$type)";
				$statement = $db->prepare($query);
				$statement->bindParam(":$type", $value);
			} else {
				$query = $query.' ORDER BY user_id ASC';
				$statement = $db->prepare($query);
			}
			
			$statement->execute();
			$userRows = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor();
		} catch (Exception $e) {
			echo "<p>Error getting user rows by $type: ".$e->getMessage()."</p>";
		}
		
		return $userRows;
	}
	
	// Returns an array of User objects extracted from $rows
	public static function getUsersArray($rows) {
		$users = array();
		
		if (!empty($rows)) {
			// Convert the array of arrays into an array of Users
			foreach ($rows as $userRow) {
				$user = new User($userRow);
				$user->setUserId($userRow['user_id']);
				array_push($users, $user);
			}
		}
		
		return $users;
	}
	
	// Returns an array of Users that meet the criteria specified.
	// If unsuccessful, this function returns an empty array.
	public static function getUsersBy($type = null, $value = null) {
		$userRows = UsersDB::getUserRowsBy($type, $value);
		
		return UsersDB::getUsersArray($userRows);
	}
	
	// Returns the $column of Users whose $type maches $value
	public static function getUsersValuesBy($type = null, $value = null, $column) {
		$userRows = UsersDB::getUserRowsBy($type, $value);
		
		return UsersDB::getUserValues($userRows, $column);
	}
	
	// Returns an array of values from the $column extracted from $rows
	public static function getUserValues($rows, $column) {
		$userValues = array();
		
		foreach ($row as $userRow) {
			$userValue = $userRow[$column];
			array_push($userValues, $userValue);
		}
		
		return $userValues;
	}
	
	// Updates a User entry in the Users table
	public static function updateUser($user) {
		try {
			$db = Database::getDB();
			
			if (is_null($user) || $user->getErrorCount() > 0)
				return $user;

			$checkUser = UsersDB::getUsersBy('user_id', $user->getUserId());

			if (empty($checkUser))
				$user->setError('user_id', 'USER_DOES_NOT_EXIST');
			if ($user->getErrorCount() > 0)
				return $user;
			
			$query = 'UPDATE Users SET username = :username, password = :password 
					WHERE user_id = :user_id';
			
			$statement = $db->prepare($query);
			$statement->bindValue(':username', $user->getUsername());
			$statement->bindValue(':password', $user->getPassword());
			$statement->bindValue(':user_id', $user->getUserId());
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) {
			$user->setError('user_id', 'USER_COULD_NOT_BE_UPDATED');
		}
		
		return $user;
	}
}
?>