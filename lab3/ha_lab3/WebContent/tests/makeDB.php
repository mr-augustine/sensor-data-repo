<?php
// Creates a test database named $dbName and returns a connection to it,
// if successful. Throws an exception otherwise.
function makeDB($dbName) {
	
	try {
		$dbspec = 'mysql:host=localhost;dbname='.$dbName.";charset=utf8";
		$username = 'root';
		$password = '';
	    $options = array (PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $db = new PDO ($dbspec, $username, $password, $options);
		$st = $db->prepare("DROP DATABASE if EXISTS $dbName");
		$st->execute();
		$st = $db->prepare("CREATE DATABASE $dbName");
		$st->execute();
		$st = $db->prepare("USE $dbName");
		$st->execute();
		$st = $db->prepare("DROP TABLE if EXISTS Users");
		$st->execute();
		$st = $db->prepare(
			"CREATE TABLE Users (
					userId             int(11) NOT NULL AUTO_INCREMENT,
					email              varchar (255) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
					password           varchar(255) COLLATE utf8_unicode_ci,
				    date_created       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY (userId)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
		);
		$st->execute();
		
		$st = $db->prepare("DROP TABLE if EXISTS UserData");
		$st->execute();
		$st = $db->prepare(
			"CREATE TABLE UserData (
				userDataId		 int(11) NOT NULL AUTO_INCREMENT,
  				userId			 int(11) NOT NULL COLLATE utf8_unicode_ci,
  				user_name		 varchar(30) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  				skill_level		 int(1) COLLATE utf8_unicode_ci,
  				profile_pic		 varchar(255) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  				started_hobby 	 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  				date_created	 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  				fav_color	 	 char(6) NOT NULL COLLATE utf8_unicode_ci,
  				url				 varchar(255) COLLATE utf8_unicode_ci,
  				phone			 varchar(255) COLLATE utf8_unicode_ci,
  				PRIMARY KEY (userDataId),
  				FOREIGN KEY (userId) REFERENCES Users(userId)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"	
		);
		$st->execute();
		
		$sql = "INSERT INTO Users (userId, email, password) VALUES
		                          (:userId, :email, :password)";
		$st = $db->prepare($sql);
		$st->execute (array (':userId' => 1, ':email' => 'bjabituya@yahoo.com', ':password' => 'wwwwwwww'));
		$st->execute (array (':userId' => 2, ':email' => 'charlie.g@hotmail.com', ':password' => 'xxxxxxxx'));
		$st->execute (array (':userId' => 3, ':email' => 'altars@gmail.com', ':password' => 'yyyyyyyy'));
		$st->execute (array (':userId' => 4, ':email' => 'asuda@kenbishi.jp', ':password' => 'zzzzzzzz'));
		
		$sql = "INSERT INTO UserData (userDataId, userId, user_name, skill_level, profile_pic, started_hobby, fav_color, url, phone) VALUES
				(:userDataId, :userId, :user_name, :skill_level, :profile_pic, :started_hobby, :fav_color, :url, :phone)";
		$st = $db->prepare($sql);
		$st->execute (array (':userDataId' => 1, ':userId' => 1, ':user_name' => 'jabituya', ':skill_level' => 2, ':profile_pic' => 'none.jpg', ':started_hobby' => '2015-10-17 07:38:46', ':fav_color' => '008000', ':url' => 'http://www.google.com', ':phone' => '210-555-9090'));
	} catch ( PDOException $e ) {
		echo $e->getMessage ();  // not final error handling
	}
	 
	return $db;
}
?>