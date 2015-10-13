<?php

class DBMaker {
	
	// Creates a test database named $dbName and returns a connection to it,
	// if successful. Throws an exception otherwise.
	public static function create($dbName) {
		$db = null;
		
		try {
			$dbspec = 'mysql:host=localhost;dbname=' . "". ";charset=utf8";
			$username = 'root';
			$password = '';
			$options = array (
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
			);
			
			$db = new PDO ( $dbspec, $username, $password, $options );
			
			// Create the database and the Users table
			$st = $db->prepare ( "DROP DATABASE if EXISTS $dbName" );
			$st->execute ();
			$st = $db->prepare ( "CREATE DATABASE $dbName" );
			$st->execute ();
			$st = $db->prepare ( "USE $dbName" );
			$st->execute ();
			$st = $db->prepare ( "DROP TABLE if EXISTS Users" );
			$st->execute ();
			$st = $db->prepare ( "CREATE TABLE Users (
					userId             int(11) NOT NULL AUTO_INCREMENT,
					email              varchar (255) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
					password           varchar(255) COLLATE utf8_unicode_ci,
				    date_created       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY (userId)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci" );
			$st->execute ();
		
			// Populate the Users table
			$sql = "INSERT INTO Users (userId, email, password) VALUES
		                          (:userId, :email, :password)";
			$st = $db->prepare ( $sql );
			$st->execute (array (':userId' => 1, ':email' => 'bjabituya@yahoo.com', ':password' => 'xxx'));
			$st->execute (array (':userId' => 2, ':email' => 'charlie.g@hotmail.com', ':password' => 'yyy'));
			$st->execute (array (':userId' => 3, ':email' => 'altars@gmail.com', ':password' => 'zzz'));
			$st->execute (array (':userId' => 4, ':email' => 'asuda@kenbishi.jp', ':password' => 'www'));
			
		} catch ( PDOException $e ) {
			echo $e->getMessage (); // not final error handling
		}
		
		return $db;
	}
	
	// Deletes a test database named $dbName, if successful.
	// Throws and exception otherwise.
	public static function delete($dbName) {
		try {
			$dbspec = 'mysql:host=localhost;dbname=' . $dbName . ";charset=utf8";
			$username = 'root';
			$password = '';
			$options = array (PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
			$db = new PDO ($dbspec, $username, $password, $options);
			$st = $db->prepare ("DROP DATABASE if EXISTS $dbName");
			$st->execute ();
		} catch ( PDOException $e ) {
			echo $e->getMessage (); // not final error handling
		}
	}
}
?>