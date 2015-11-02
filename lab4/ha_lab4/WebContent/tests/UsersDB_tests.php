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

<h2>It should allow a new valid user to be added</h2>
<?php 
echo "Number of users in db before new user added is: ". count(UsersDB::getAllUsers()) ."<br>";
$validUser = array("email" => "valid.user@email.com", "password" => "11111111");
$user = new User($validUser);
$userId = UsersDB::addUser($user);
echo "Number of users in db after user add is: ". count(UsersDB::getAllUsers()) ."<br>";
echo "User ID of new user is: $userId<br>";
?>

<h2>It should not allow an invalid user to be added</h2>
<?php
echo "Number of users in db before invalid user add is: ". count(UsersDB::getAllUsers()) ."<br>";
$invalidUser = new User(array("email" => "invalid.email@", "password" => "nope"));
$userId = UsersDB::addUser($invalidUser);
echo "Number of users in db after add attempt is: ". count(UsersDB::getAllUsers()) ."<br>";
echo "User ID of new user is: $userId<br>";
?>

<h2>It should not add a duplicate user</h2>
<?php 
echo "Number of users in db before invalid user add is: ". count(UsersDB::getAllUsers()) ."<br>";
$duplicateUser = array("email" => "asuda@kenbishi.jp", "password" => "whatever");
$user = new User($duplicateUser);
$userId = UsersDB::addUser($user);
echo "Number of users in db after add attempt is: ". count(UsersDB::getAllUsers()) ."<br>";
echo "User ID of new user is: $userId<br>";
?>

<h2>It should get a User by email</h2>
<?php 
$users = UsersDB::getUsersBy('email', 'altars@gmail.com');
echo "The value of User altars@gmail.com is:<br>$users[0]<br>";
?>

<h2>It should get a User by userId</h2>
<?php
$users = UsersDB::getUsersBy('userId', '2');
echo "The value of User 2 is:<br>$users[0]<br>";
?>

<h2>It should not get a User not in Users</h2>
<?php 
$users = UsersDB::getUsersBy('email', 'dalfk@adlfkj.edu');
if (empty($users))
	echo "No user dalfk@adlfkj.edu";
else
	echo "The value of User dalfk@adlfkj.edu is:<br>$users[0]<br>";
?>

<h2>It should not get a User by a field that isn't there</h2>
<?php 
$users = UsersDB::getUsersBy('height', '59');
if (empty($users))
	echo "No user with this height";
else 
	echo "The value of User with a specified height is:<br>$user<br>";
?>

<h2>It should get a email by user id</h2>
<?php 
$userNames = UsersDB::getUserValuesBy('userId', 1, 'email');
print_r($userNames);
?>

</body>
</html>