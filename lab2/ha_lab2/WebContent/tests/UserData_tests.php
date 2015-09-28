<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for UserData</title>
</head>
<body>
<h1>User tests</h1>
<?php
include_once("../models/UserData.class.php");
?>

<h2>It should have an error when the user name contains invalid characters</h2>
<?php 
$invalidUserNameTest = array("userName" => "krobbins$", "email" => "valid@email.com");
$s1 = new User($invalidUserNameTest);
$test2 = (empty($s1->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test2;
echo "The error for userName is: ". $s1->getError('userName') ."<br>";
echo "The object is: $s1<br>";
?>

<h2>It should have an error when the user name contains too few characters</h2>
<?php 
$invalidUserNameTest = array("userName" => "krob", "email" => "valid@email.com");
$s1 = new User($invalidUserNameTest);
$test2 = (empty($s1->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test2;
echo "The error for userName is: ". $s1->getError('userName') ."<br>";
echo "The object is: $s1<br>";
?>

</body>
</html>