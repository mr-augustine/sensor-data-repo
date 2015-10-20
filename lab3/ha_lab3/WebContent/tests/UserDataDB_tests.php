<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for UserDataDB</title>
</head>
<body>
<h1>UserDataDB tests</h1>

<?php
include_once("../models/Database.class.php");
include_once("../models/Messages.class.php");
include_once("../models/User.class.php");
include_once("../models/UsersDB.class.php");
include_once("../models/UserData.class.php");
include_once("../models/UserDataDB.class.php");
include_once("./makeDB.php");
?>

<h2>It should get all user data from a test database</h2>
<?php 
makeDB('botspacetest');
Database::clearDB();
$db = Database::getDB('botspacetest');
$userData = UserDataDB::getUserDataBy();
$userDataCount = count($userData);
echo "Number of user data in db is: $userDataCount <br>";
foreach ($userData as $userData) {
	echo "$userData <br>";
}
?>

<h2>It should allow a new valid user data to be added for a new user</h2>
<?php 
makeDB('botspacetest');
Database::clearDB();
$db = Database::getDB('botspacetest');
echo "Number of user data in db before adding is: " . count(UserDataDB::getUserDataBy()) . "<br>";
$validTestUser = array("email" => "newbie@validemail.com", "password" => "validpassword");
$user = new User($validTestUser);
$userId = UsersDB::addUser($user);
$validTestUserData = array("user_name" => "newbie-user", "skill_level" => "novice", 
		"skill_areas" => array("computer-vision", "soldering", "circuit-design"),
		"profile_pic" => "no-picture.jpg", "started_hobby" => "2015-10",
		"fav_color" => "#ff8000", "url" => "http://www.wired.com", "phone" => "210-555-1234");
$userData = new UserData($validTestUserData);
$userData->setUserId($userId);
$userDataId = UserDataDB::addUserData($userData);
echo "Number of user data in db after adding is: " . count(UserDataDB::getUserDataBy()) . "<br>";
echo "UserData ID of new user is: $userDataId"
?>

<h2>It should not allow invalid user data to be added</h2>


<h2>It should allow user data to be edited for an existing user</h2>


<h2>It should not allow user data to be added for a nonexistent user</h2>


<h2>It should not get user data not in UserData</h2>


<h2>It should get UserData by userId</h2>


<h2>It should get UserData by user_name</h2>


<h2>It should get UserData by skill_level</h2>


<?php // TODO: ensure you can fetch UserData by multiple skill areas ?> 
<h2>It should get UserData by skill_area</h2>


<h2>It should get UserData by robot_name</h2>


<h2>It should not get UserData by a field that isn't there</h2>