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
			
			$st = $db->prepare("DROP TABLE if EXISTS Datasets");
			$st->execute();
			$st = $db->prepare("CREATE TABLE Datasets (
    			dataset_id      int(11) NOT NULL AUTO_INCREMENT,
				user_id         int(11) NOT NULL,
				dataset_name    varchar(32) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
    			description     varchar(255) COLLATE utf8_unicode_ci,
    			date_created    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    			PRIMARY KEY (dataset_id),
				FOREIGN KEY (user_id) REFERENCES Users(user_id)
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
    			measurement_timestamp   TIMESTAMP,
    			sensor_id               int(11) NOT NULL,
    			PRIMARY KEY (measurement_id),
    			FOREIGN KEY (sensor_id) REFERENCES Sensors(sensor_id)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
			$st->execute();
			
			
			// Table insertions go here
			
			// Populate the Users table
			$sql = "INSERT INTO Users (user_id, username, password) VALUES
					(:user_id, :username, :password)";
			$st = $db->prepare($sql);
			$st->execute(array(':user_id' => 1, ':username' => 'jabituya', ':password' => '$2y$10$c1YR3YAtv5VJy7bU4KbC.umWt9mbL8bFtaxnoDbd8nvmggcfqaM5W'));
			$st->execute(array(':user_id' => 2, ':username' => 'mwatney', ':password' => '$2y$10$5pcOvjUbkcXKz7vfjCNjcej/6KO89vcNg.u7m84tLL1/jc99jJWF6'));
			$st->execute(array(':user_id' => 3, ':username' => 'ryan.stone', ':password' => '$2y$10$.iyID/cQucx7SF61f/RsreV61lVXVYa/lvgkKSq/EWukT0HTeut1u'));
			$st->execute(array(':user_id' => 4, ':username' => 'cooper', ':password' => '$2y$10$hZecd/spqqmWagIE3VXxZeaEOJEhSUiEkzTNIx7FtbXK5OdsbLiy.'));
			$st->execute(array(':user_id' => 5, ':username' => 'liz.shaw', ':password' => '$2y$10$KGYOoNJr4yOF0meEDFPng.ZGgRlcfjv1a2H0ecDK03TETl7Eq2ZAS'));
			$st->execute(array(':user_id' => 6, ':username' => 'charlie-g', ':password' => '$2y$10$g8SDz5IjB5ASFIVPR9addec13G6zuqA6tDjyzDVJvSzpIRGtQljoO'));
			$st->execute(array(':user_id' => 7, ':username' => 'altars', ':password' => '$2y$10$ADsSkEAN.1DYmX5/35AAEeskCs.KTi8w3muBEMHoWatZJbYjoWYp6'));
			$st->execute(array(':user_id' => 8, ':username' => 'asuda0x1', ':password' => '$2y$10$z0hExq5pEWicWCgirPAmvOKQMxNvwMMi1rizFK4ta15HwqLVun7K6'));
			
			
			// Populate the Datasets table
			$sql = "INSERT INTO Datasets (dataset_id, user_id, dataset_name, description)
					VALUES (:dataset_id, :user_id, :dataset_name, :description)";
			$st = $db->prepare($sql);
			$st->execute(array(':dataset_id' => 1, ':user_id' => 1, ':dataset_name' => 'Lincoln Park Run', ':description' => ''));
			
			
			// Populate the Sensors table
			$sql = "INSERT INTO Sensors (sensor_id, dataset_id, sensor_name, sensor_type, sensor_units, sequence_type, description) VALUES
    			(:sensor_id, :dataset_id, :sensor_name, :sensor_type, :sensor_units, :sequence_type, :description)";
			$st = $db->prepare($sql);
			$st->execute(array(':sensor_id' => 1, ':dataset_id' => 1, ':sensor_name' => 'compass0', 
					':sensor_type' => 'HEADING', ':sensor_units' => 'DEGREES', ':sequence_type' => 'SEQUENTIAL', 
					':description' => "The robot's only compass. Placed ontop a mast."));
			$st->execute(array(':sensor_id' => 2, ':dataset_id' => 1, ':sensor_name' => 'ping0',
					':sensor_type' => 'RANGE', ':sensor_units' => 'CENTIMETERS', ':sequence_type' => 'SEQUENTIAL',
					':description' => "The robot's only ultrasonic sensor. Placed at the front/center"));
			$st->execute(array(':sensor_id' => 3, ':dataset_id' => 1, ':sensor_name' => 'bump0',
					':sensor_type' => 'BINARY', ':sensor_units' => 'ON-OFF', ':sequence_type' => 'SEQUENTIAL',
					':description' => "The robot's only bump switch. Placed at the front/center."));
			
			
			// Populate the Measurements table
			$sql = "INSERT INTO Measurements (measurement_id, measurement_index, measurement_value, measurement_timestamp, sensor_id) VALUES
				(:measurement_id, :measurement_index, :measurement_value, :measurement_timestamp, :sensor_id)";
			$st = $db->prepare($sql);
			$st->execute(array(':measurement_id' => 1, ':measurement_index' => 1, ':measurement_value' => '45.2',
					':measurement_timestamp' => NULL, ':sensor_id' => 1));
			$st->execute(array(':measurement_id' => 2, ':measurement_index' => 2, ':measurement_value' => '48.7',
					':measurement_timestamp' => NULL, ':sensor_id' => 1));
			$st->execute(array(':measurement_id' => 3, ':measurement_index' => 3, ':measurement_value' => '49.1',
					':measurement_timestamp' => NULL, ':sensor_id' => 1));
			$st->execute(array(':measurement_id' => 4, ':measurement_index' => 1, ':measurement_value' => '30',
					':measurement_timestamp' => NULL, ':sensor_id' => 2));
			$st->execute(array(':measurement_id' => 5, ':measurement_index' => 2, ':measurement_value' => '29',
					':measurement_timestamp' => NULL, ':sensor_id' => 2));
			$st->execute(array(':measurement_id' => 6, ':measurement_index' => 3, ':measurement_value' => '30',
					':measurement_timestamp' => NULL, ':sensor_id' => 2));
			$st->execute(array(':measurement_id' => 7, ':measurement_index' => 1, ':measurement_value' => 'OFF',
					':measurement_timestamp' => NULL, ':sensor_id' => 3));
			$st->execute(array(':measurement_id' => 8, ':measurement_index' => 2, ':measurement_value' => 'OFF',
					':measurement_timestamp' => NULL, ':sensor_id' => 3));
			$st->execute(array(':measurement_id' => 9, ':measurement_index' => 3, ':measurement_value' => 'ON',
					':measurement_timestamp' => NULL, ':sensor_id' => 3));
				
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