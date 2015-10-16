<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for UsersDB</title>
</head>
<body>
<h1>UsersDB tests</h1>

<?php
include_once("../models/Database.class.php");
include_once("../models/Messages.class.php");
include_once("../models/User.class.php");
include_once("../models/UsersDB.class.php");
include_once("./makeDB.php");
?>

<h2>It should get all users from a test database</h2>
<?php 
makeDB('botspacetest');
Database::clearDB();
$db = Database::getDB('botspacetest');
$users = UsersDB::getAllUsers();
$usersCount = count($users);
echo "Number of users in db is: $usersCount <br>";
foreach ($users as $user)
	echo "$user <br>";
?>