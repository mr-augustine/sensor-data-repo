<?php
class UsersDB {
	
	// Inserts a User object into the User table and returns
	// the User with the user_id property set, if successful;
	// otherwise, returns the User unchanged. Sets a user_id error
	// if there is a db issue.
	public static function addUser($User) {
		
	}
	
	// Returns an array of the rows from the Users table whose $type
	// field has value $value. Throws an exception if unsuccessful.
	public static function getUserRowsBy($type = null, $value = null) {
	
	}
	
	// Returns an array of values from the $column extracted from $rows
	public static function getUserValues($rows, $column) {
	
	}
	
	// Returns the $column of Users whose $type maches $value
	public static function getUsersValuesBy($type = null, $value = null, $column) {
	
	}
	
	// Returns an array of User objects extracted from $rows
	public static function getUsersArray($rows) {
	
	}
	
	// Returns an array of Users that meet the criteria specified.
	// If unsuccessful, this function returns an empty array.
	public static function getUsersBy($type = null, $value = null) {
	}
	
	// Updates a User entry in the Users table
	public static function updateUser($user) {
	
	}
}
?>