<?php
class UsersDB {
	
	// Inserts a User object into the Users table and returns the userId
	public static function addUser($user) {
		$query = "INSERT INTO Users (email, password)
		                      VALUES(:email, :password)";
		$returnId = 0;
		
		try {
			if (is_null($user) || $user->getErrorCount() > 0)
				throw new PDOException("Invalid User object can't be inserted");
			
			$db = Database::getDB ();
			$statement = $db->prepare ($query);
			$statement->bindValue(":email", $user->getEmail());
			$statement->bindValue(":password", $user->getPassword());
			$statement->execute ();
			$statement->closeCursor();
			$returnId = $db->lastInsertId("userId");
		} catch ( PDOException $e ) { // Not permanent error handling
			echo "<p>Error adding user to Users ".$e->getMessage()."</p>";
		}
		
		return $returnId;
	}
	
	public static function getAllUsers() {
		
	}
	
	public static function getUserBy($type, $value) {
		
	}
	
	public static function getUsersArray($rowSets) {
		
	}
}

?>