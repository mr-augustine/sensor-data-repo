<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Basic tests for UserData</title>
</head>
<body>
<h1>UserData tests</h1>
<?php
include_once("../models/UserData.class.php");
?>

<h2>It should have an error when the user name is empty</h2>
<?php 
$invalidUserNameTest = array("user_name" => "");
$s1 = new UserData($invalidUserNameTest);
$test1 = (empty($s1->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test1;
echo "The error for user_name is: ". $s1->getError('user_name') ."<br>";
echo "The object is: $s1<br>";
?>

<h2>It should have an error when the user name contains too few characters</h2>
<?php 
$invalidUserNameTest = array("user_name" => "krob");
$s1 = new UserData($invalidUserNameTest);
$test2 = (empty($s1->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test2;
echo "The error for user_name is: ". $s1->getError('user_name') ."<br>";
echo "The object is: $s1<br>";
?>

<h2>It should have an error when the user name contains invalid characters</h2>
<?php 
$invalidUserNameTest = array("user_name" => "krobbins$");
$s1 = new UserData($invalidUserNameTest);
$test3 = (empty($s1->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test3;
echo "The error for user_name is: ". $s1->getError('user_name') ."<br>";
echo "The object is: $s1<br>";
?>

<h2>It should have an error when the skill area is invalid</h2>
<?php 
$invalidSkillAreasTest = array("skill_areas" => array("error_trapping"));
$s1 = new UserData($invalidSkillAreasTest);
$test4 = (empty($s1->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test4;
echo "The error for skill_areas is: ". $s1->getError('skill_areas') ."<br>";
echo "The object is: $s1<br>";
?>

</body>
</html>