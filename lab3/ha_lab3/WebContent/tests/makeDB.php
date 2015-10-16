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
		
		$sql = "INSERT INTO Users (userId, email, password) VALUES
		                          (:userId, :email, :password)";
		$st = $db->prepare($sql);
		$st->execute (array (':userId' => 1, ':email' => 'bjabituya@yahoo.com', ':password' => 'wwwwwwww'));
		$st->execute (array (':userId' => 2, ':email' => 'charlie.g@hotmail.com', ':password' => 'xxxxxxxx'));
		$st->execute (array (':userId' => 3, ':email' => 'altars@gmail.com', ':password' => 'yyyyyyyy'));
		$st->execute (array (':userId' => 4, ':email' => 'asuda@kenbishi.jp', ':password' => 'zzzzzzzz'));
	} catch ( PDOException $e ) {
		echo $e->getMessage ();  // not final error handling
	}
	 
	return $db;
}
?>