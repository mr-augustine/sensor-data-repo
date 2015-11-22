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
			$st = $db->prepare("DROP DATABASE if EXISTS $dbName");
			$st->execute();
			$st = $db->prepare("CREATE DATABASE $dbName");
			$st->execute();
			$st = $db->prepare("USE $dbName");
			$st->execute();
			
			$st = $db->prepare("DROP TABLE if EXISTS Users");
			$st->execute();
			$st = $db->prepare("CREATE TABLE Users (
    			user_id         int(11) NOT NULL AUTO_INCREMENT,
    			password        varchar(255) COLLATE utf8_unicode_ci,
    			PRIMARY KEY (user_id)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
			$st->execute();
			
			$st = $db->prepare("DROP TABLE if EXISTS DataSets");
			$st->execute();
			$st = $db->prepare("CREATE TABLE DataSets (
    			dataset_id      int(11) NOT NULL AUTO_INCREMENT,
				dataset_name    varchar(32) NOT NULL COLLATE utf8_unicode_ci,
    			description     varchar(255) COLLATE utf8_unicode_ci,
    			date_created    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    			PRIMARY KEY (dataset_id)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
			$st->execute();
			
			$st = $db->prepare("DROP TABLE if EXISTS Sensors");
			$st->execute();
			$st = $db->prepare("CREATE TABLE Sensors (
    			sensor_id       int(11) NOT NULL AUTO_INCREMENT,
    			PRIMARY KEY (sensor_id)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
			$st->execute();
			
			$st = $db->prepare("DROP TABLE if EXISTS Measurements");
			$st->execute();
			$st = $db->prepare("CREATE TABLE Measurements (
    			measurement_id          int(11) NOT NULL AUTO_INCREMENT,
    			measurement_index       int(11) NOT NULL,
    			measurement_value       varchar(32) NOT NULL COLLATE utf8_unicode_ci,
    			measurement_timestamp   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    			sensor_id               int(11) NOT NULL,
    			PRIMARY KEY (measurement_id),
    			FOREIGN KEY (sensor_id) REFERENCES Sensors(sensor_id)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
			$st->execute();
			
			
			// Table insertions go here
			
		} catch (PDOException $e) {
			echo $e->getMessage();
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