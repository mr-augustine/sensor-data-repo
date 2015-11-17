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

			$st = $db->prepare ( "DROP TABLE if EXISTS UserData" );
			$st->execute();
			$st = $db->prepare ( "CREATE TABLE UserData (
					userDataId		 int(11) NOT NULL AUTO_INCREMENT,
  					userId			 int(11) NOT NULL COLLATE utf8_unicode_ci,
  					user_name		 varchar(30) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  					skill_level		 varchar(30) NOT NULL COLLATE utf8_unicode_ci,
  					profile_pic		 varchar(255) COLLATE utf8_unicode_ci,
  					started_hobby 	 DATE,
  					date_created	 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  					fav_color		 char(7) NOT NULL COLLATE utf8_unicode_ci,
  					url				 varchar(255) COLLATE utf8_unicode_ci,
  					phone			 varchar(255) COLLATE utf8_unicode_ci,
  					PRIMARY KEY (userDataId),
  					FOREIGN KEY (userId) REFERENCES Users(userId)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci" );
			$st->execute();
			
			$st = $db->prepare ( "DROP TABLE if EXISTS Skills" );
			$st->execute();
			$st = $db->prepare ( "CREATE TABLE Skills (
					skillId			 int(3) NOT NULL AUTO_INCREMENT,
					skill_name		 varchar(32) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
					PRIMARY KEY (skillId)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci" );
			$st->execute();
			
			$st = $db->prepare ( "DROP TABLE if EXISTS SkillAssocs" );
			$st->execute();
			$st = $db->prepare ( "CREATE TABLE SkillAssocs (
					skillAssocId	 int(11) NOT NULL AUTO_INCREMENT,
					skillId			 int(3) NOT NULL,
					userDataId		 int(11) NOT NULL,
					PRIMARY KEY (skillAssocId),
					FOREIGN KEY (skillId) REFERENCES Skills(skillId),
					FOREIGN KEY (userDataId) REFERENCES UserData(userDataId)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci" );
			$st->execute();
			
			$st = $db->prepare ( "DROP TABLE if EXISTS RobotData" );
			$st->execute();
			$st = $db->prepare ( "CREATE TABLE RobotData (
					robotId		 	 int(11) NOT NULL AUTO_INCREMENT,
  					robot_name		 varchar(32) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  					status			 varchar(30) NOT NULL COLLATE utf8_unicode_ci,
  					PRIMARY KEY (robotId)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci" );
			$st->execute();
			
			$st = $db->prepare ( "DROP TABLE if EXISTS RobotAssocs" );
			$st->execute();
			$st = $db->prepare ( "CREATE TABLE RobotAssocs (
					robotAssocId		 int(11) NOT NULL AUTO_INCREMENT,
  					robotId			 	 int(11) NOT NULL,
  					creatorId			 int(11) NOT NULL,
  					PRIMARY KEY 		 (robotAssocId),
  					FOREIGN KEY (robotId) REFERENCES RobotData(robotId),
  					FOREIGN KEY (creatorId) REFERENCES UserData(userDataId)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci" );
			$st->execute();
			
			// Populate the Skills table
			$sql = "INSERT INTO Skills (skillId, skill_name) VALUES
						(:skillId, :skill_name)";
			$st = $db->prepare ( $sql );
			$st->execute (array (':skillId' => 1, ':skill_name' => 'system-design'));
			$st->execute (array (':skillId' => 2, ':skill_name' => 'programming'));
			$st->execute (array (':skillId' => 3, ':skill_name' => 'machining'));
			$st->execute (array (':skillId' => 4, ':skill_name' => 'soldering'));
			$st->execute (array (':skillId' => 5, ':skill_name' => 'wiring'));
			$st->execute (array (':skillId' => 6, ':skill_name' => 'circuit-design'));
			$st->execute (array (':skillId' => 7, ':skill_name' => 'power-systems'));
			$st->execute (array (':skillId' => 8, ':skill_name' => 'computer-vision'));
			$st->execute (array (':skillId' => 9, ':skill_name' => 'ultrasonic'));
			$st->execute (array (':skillId' => 10, ':skill_name' => 'infrared'));
			$st->execute (array (':skillId' => 11, ':skill_name' => 'GPS'));
			$st->execute (array (':skillId' => 12, ':skill_name' => 'compass'));
			
			
			// Populate the Users table
			$sql = "INSERT INTO Users (userId, email, password) VALUES
		                          (:userId, :email, :password)";
			$st = $db->prepare ( $sql );
			$st->execute (array (':userId' => 1, ':email' => 'bjabituya@yahoo.com', ':password' => 'wwwwwwww'));
			$st->execute (array (':userId' => 2, ':email' => 'mwatney@mars.com', ':password' => 'aaaaaaaa'));
			$st->execute (array (':userId' => 3, ':email' => 'ryan.stone@iss.gov', ':password' => 'bbbbbbbb'));
			$st->execute (array (':userId' => 4, ':email' => 'jcoop@tps.gov', ':password' => 'cccccccc'));
			$st->execute (array (':userId' => 5, ':email' => 'liz.shaw@lv223.com', ':password' => 'dddddddd'));
			$st->execute (array (':userId' => 6, ':email' => 'charlie.g@hotmail.com', ':password' => 'xxxxxxxx'));
			$st->execute (array (':userId' => 7, ':email' => 'altars@gmail.com', ':password' => 'yyyyyyyy'));
			$st->execute (array (':userId' => 8, ':email' => 'asuda@kenbishi.jp', ':password' => 'zzzzzzzz'));

			// Populate the UserData table
			$sql = "INSERT INTO UserData (userDataId, userId, user_name, skill_level, profile_pic, started_hobby, fav_color, url, phone) VALUES
					(:userDataId, :userId, :user_name, :skill_level, :profile_pic, :started_hobby, :fav_color, :url, :phone)";
			$st = $db->prepare( $sql );
			$st->execute (array (':userDataId' => 1, ':userId' => 1, ':user_name' => 'jabituya', ':skill_level' => "advanced", ':profile_pic' => 'none.jpg',
					':started_hobby' => '2015-10-17 07:38:46', ':fav_color' => '#008000', ':url' => 'http://www.google.com', ':phone' => '210-555-9090'));
			$st->execute (array (':userDataId' => 2, ':userId' => 2, ':user_name' => 'mwatney', ':skill_level' => "novice", ':profile_pic' => 'none.jpg',
					':started_hobby' => '2015-10-26 12:00:00', ':fav_color' => '#ff8000', ':url' => 'http://www.strandedonmars.com', ':phone' => '210-555-9090'));
			$st->execute (array (':userDataId' => 3, ':userId' => 3, ':user_name' => 'ryan.stone', ':skill_level' => "advanced", ':profile_pic' => 'none.jpg',
					':started_hobby' => '2015-10-26 12:00:01', ':fav_color' => '#004080', ':url' => 'http://www.ihatespace.com', ':phone' => '210-555-9090'));
			$st->execute (array (':userDataId' => 4, ':userId' => 4, ':user_name' => 'cooper', ':skill_level' => "advanced", ':profile_pic' => 'none.jpg',
					':started_hobby' => '2015-10-26 12:00:02', ':fav_color' => '#c0c0c0', ':url' => 'http://www.si.edu', ':phone' => '210-555-9090'));
			$st->execute (array (':userDataId' => 5, ':userId' => 5, ':user_name' => 'liz.shaw', ':skill_level' => "novice", ':profile_pic' => 'none.jpg',
					':started_hobby' => '2015-10-26 12:00:03', ':fav_color' => '#008080', ':url' => 'http://www.weylandindustries.com', ':phone' => '210-555-9090'));
			$st->execute (array (':userDataId' => 6, ':userId' => 6, ':user_name' => 'charlie-g', ':skill_level' => "advanced", ':profile_pic' => 'none.jpg',
					':started_hobby' => '2012-09-09 12:00:04', ':fav_color' => '#800080', ':url' => 'http://www.knightindustries.com', ':phone' => '210-555-4321'));
			$st->execute (array (':userDataId' => 7, ':userId' => 7, ':user_name' => 'altars', ':skill_level' => "expert", ':profile_pic' => 'none.jpg',
					':started_hobby' => '1980-03-12 12:00:05', ':fav_color' => '#8000ff', ':url' => 'http://www.monolithrobots.com', ':phone' => '210-555-7654'));
			$st->execute (array (':userDataId' => 8, ':userId' => 8, ':user_name' => 'asuda0x1', ':skill_level' => "expert", ':profile_pic' => 'none.jpg',
					':started_hobby' => '1970-01-05 12:00:06', ':fav_color' => '#0080c0', ':url' => 'http://www.defenseministry.jp', ':phone' => '210-999-9999'));
			
			// Populate the SkillAssocs table
			$sql = "INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
						(:skillAssocId, :userDataId, :skillId)";
			$st = $db->prepare ( $sql );
			$st->execute (array (':skillAssocId' => 1, ':userDataId' => 1, 'skillId' => 1));
			$st->execute (array (':skillAssocId' => 2, ':userDataId' => 1, 'skillId' => 2));
			$st->execute (array (':skillAssocId' => 3, ':userDataId' => 1, 'skillId' => 8));
			$st->execute (array (':skillAssocId' => 4, ':userDataId' => 2, 'skillId' => 1));
			$st->execute (array (':skillAssocId' => 5, ':userDataId' => 2, 'skillId' => 12));
			$st->execute (array (':skillAssocId' => 6, ':userDataId' => 3, 'skillId' => 9));
			$st->execute (array (':skillAssocId' => 7, ':userDataId' => 3, 'skillId' => 10));
			$st->execute (array (':skillAssocId' => 8, ':userDataId' => 4, 'skillId' => 11));
			$st->execute (array (':skillAssocId' => 9, ':userDataId' => 4, 'skillId' => 3));
			$st->execute (array (':skillAssocId' => 10, ':userDataId' => 4, 'skillId' => 5));
			$st->execute (array (':skillAssocId' => 11, ':userDataId' => 4, 'skillId' => 7));
			$st->execute (array (':skillAssocId' => 12, ':userDataId' => 5, 'skillId' => 4));
			$st->execute (array (':skillAssocId' => 13, ':userDataId' => 5, 'skillId' => 8));
			$st->execute (array (':skillAssocId' => 14, ':userDataId' => 6, 'skillId' => 4));
			$st->execute (array (':skillAssocId' => 15, ':userDataId' => 6, 'skillId' => 8));
			$st->execute (array (':skillAssocId' => 16, ':userDataId' => 6, 'skillId' => 11));
			$st->execute (array (':skillAssocId' => 17, ':userDataId' => 6, 'skillId' => 9));
			$st->execute (array (':skillAssocId' => 18, ':userDataId' => 6, 'skillId' => 6));
			$st->execute (array (':skillAssocId' => 19, ':userDataId' => 7, 'skillId' => 1));
			$st->execute (array (':skillAssocId' => 20, ':userDataId' => 7, 'skillId' => 8));
			$st->execute (array (':skillAssocId' => 21, ':userDataId' => 8, 'skillId' => 2));
			$st->execute (array (':skillAssocId' => 22, ':userDataId' => 8, 'skillId' => 5));
			$st->execute (array (':skillAssocId' => 23, ':userDataId' => 8, 'skillId' => 12));
			$st->execute (array (':skillAssocId' => 24, ':userDataId' => 8, 'skillId' => 10));
			$st->execute (array (':skillAssocId' => 25, ':userDataId' => 8, 'skillId' => 11));
			$st->execute (array (':skillAssocId' => 26, ':userDataId' => 8, 'skillId' => 4));
			$st->execute (array (':skillAssocId' => 27, ':userDataId' => 8, 'skillId' => 9));
			$st->execute (array (':skillAssocId' => 28, ':userDataId' => 8, 'skillId' => 7));
			$st->execute (array (':skillAssocId' => 29, ':userDataId' => 8, 'skillId' => 1));
			
			$sql = "INSERT INTO RobotData (robotId, robot_name, status) VALUES
						(:robotId, :robot_name, :status)";
			$st = $db->prepare( $sql );
			$st->execute (array (':robotId' => 1, ':robot_name' => "TARS", ':status' => "in-development"));
			$st->execute (array (':robotId' => 2, ':robot_name' => "KIPP", ':status' => "retired"));
			$st->execute (array (':robotId' => 3, ':robot_name' => "CASE", ':status' => "design"));
			
			$sql = "INSERT INTO RobotAssocs (robotAssocId, robotId, creatorId) VALUES
						(:robotAssocId, :robotId, :creatorId)";
			$st = $db->prepare( $sql );
			$st->execute (array (':robotAssocId' => 1, ':robotId' => 1, ':creatorId' => 7));
			$st->execute (array (':robotAssocId' => 2, ':robotId' => 2, ':creatorId' => 4));
			$st->execute (array (':robotAssocId' => 3, ':robotId' => 3, ':creatorId' => 4));
			
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