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
				username		varchar(32) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
    			password        varchar(255) COLLATE utf8_unicode_ci,
    			PRIMARY KEY (user_id)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
			$st->execute();
			
			$st = $db->prepare("DROP TABLE if EXISTS DataSets");
			$st->execute();
			$st = $db->prepare("CREATE TABLE DataSets (
    			dataset_id      int(11) NOT NULL AUTO_INCREMENT,
				dataset_name    varchar(32) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
    			description     varchar(255) COLLATE utf8_unicode_ci,
    			date_created    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    			PRIMARY KEY (dataset_id)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
			$st->execute();
			
			$st = $db->prepare("DROP TABLE if EXISTS Sensors");
			$st->execute();
			$st = $db->prepare("CREATE TABLE Sensors (
    			sensor_id       int(11) NOT NULL AUTO_INCREMENT,
				dataset_id      int(11) NOT NULL,
				sensor_name     varchar(32) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
    			sensor_type     varchar(32) NOT NULL COLLATE utf8_unicode_ci,
    			sensor_units    varchar(32) NOT NULL COLLATE utf8_unicode_ci,
    			sequence_type   varchar(32) NOT NULL COLLATE utf8_unicode_ci,
    			description     varchar(128) COLLATE utf8_unicode_ci,
    			PRIMARY KEY (sensor_id),
				FOREIGN KEY (dataset_id) REFERENCES Datasets(dataset_id)
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
			$st = $db->prepare("INSERT INTO Users (user_id, username, password) VALUES
					(1, 'jabituya', 'wwwwwwww')");
			$st->execute();
			$st = $db->prepare("INSERT INTO Users (user_id, username, password) VALUES
					(2, 'mwatney', 'aaaaaaaa')");
			$st->execute();
			$st = $db->prepare("INSERT INTO Users (user_id, username, password) VALUES
					(3, 'ryan.stone', 'bbbbbbbb')");
			$st->execute();
			$st = $db->prepare("INSERT INTO Users (user_id, username, password) VALUES
					(4, 'cooper', 'cccccccc')");
			$st->execute();
			$st = $db->prepare("INSERT INTO Users (user_id, username, password) VALUES
					(5, 'liz.shaw', 'dddddddd')");
			$st->execute();
			$st = $db->prepare("INSERT INTO Users (user_id, username, password) VALUES
					(6, 'charlie-g', 'xxxxxxxx')");
			$st->execute();
			$st = $db->prepare("INSERT INTO Users (user_id, username, password) VALUES
					(7, 'altars', 'yyyyyyyy')");
			$st->execute();
			$st = $db->prepare("INSERT INTO Users (user_id, username, password) VALUES
					(8, 'asuda0x1', 'zzzzzzzz')");
			$st->execute();
				
			
			$st = $db->prepare("INSERT INTO Datasets (dataset_id, dataset_name)
					VALUES (1, 'Lincoln Park Run')");
			$st->execute();
			
			$st = $db->prepare("INSERT INTO Sensors (sensor_id, dataset_id, sensor_name, sensor_type, sensor_units, sequence_type, description) VALUES
    			(1, 1, 'compass0', 'HEADING', 'DEGREES', 'SEQUENTIAL', \"The robot\'s only compass. Placed ontop a mast.\")");
			$st->execute();
			$st = $db->prepare("INSERT INTO Sensors (sensor_id, dataset_id, sensor_name, sensor_type, sensor_units, sequence_type, description) VALUES
    			(2, 1, 'ping0', 'RANGE', 'CENTIMETERS', 'SEQUENTIAL', \"The robot\'s only ultrasonic sensor. Placed at the front/center.\")");
			$st->execute();
			$st = $db->prepare("INSERT INTO Sensors (sensor_id, dataset_id, sensor_name, sensor_type, sensor_units, sequence_type, description) VALUES
				(3, 1, 'bump0', 'BINARY', 'ON-OFF', 'SEQUENTIAL', \"The robot\'s only bump switch. Placed at the front/center.\")");					
			$st->execute();
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