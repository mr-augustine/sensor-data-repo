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
$s2 = new UserData($invalidUserNameTest);
$test2 = (empty($s2->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test2;
echo "The error for user_name is: ". $s2->getError('user_name') ."<br>";
echo "The object is: $s2<br>";
?>

<h2>It should have an error when the user name contains invalid characters</h2>
<?php 
$invalidUserNameTest = array("user_name" => "krobbins$");
$s3 = new UserData($invalidUserNameTest);
$test3 = (empty($s3->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test3;
echo "The error for user_name is: ". $s3->getError('user_name') ."<br>";
echo "The object is: $s3<br>";
?>

<h2>It should have an error when the skill area is invalid</h2>
<?php 
$invalidSkillAreasTest = array("skill_areas" => array("error_trapping"));
$s4 = new UserData($invalidSkillAreasTest);
$test4 = (empty($s4->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test4;
echo "The error for skill_areas is: ". $s4->getError('skill_areas') ."<br>";
echo "The object is: $s4<br>";
?>

<h2>It should have an error when the skill level is invalid</h2>
<?php 
$invalidSkillLevelTest = array("skill_level" => "professional");
$s5 = new UserData($invalidSkillLevelTest);
$test5 = (empty($s5->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test5;
echo "The error for skill_level is: ". $s5->getError('skill_level') ."<br>";
echo "The object is: $s5<br>";
?>

<h2>It should have an error when the skill level is empty</h2>
<?php 
$invalidSkillLevelTest = array("skill_level" => "");
$s6 = new UserData($invalidSkillLevelTest);
$test6 = (empty($s6->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test6;
echo "The error for skill_level is: ". $s6->getError('skill_level') ."<br>";
echo "The object is: $s6<br>";
?>

<h2>It should have an error when the profile picture format is invalid</h2>
<?php 
$invalidProfilePicTest = array("profile_pic" => "invalidpic.xxx");
$s7 = new UserData($invalidProfilePicTest);
$test7 = (empty($s7->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test7;
echo "The error for profile_pic is: ". $s7->getError('profile_pic') ."<br>";
echo "The object is: $s7<br>";
?>

<h2>It should have an error when the hobby start date is empty</h2>
<?php 
$invalidHobbyStartTest = array("started_hobby" => "");
$s8 = new UserData($invalidHobbyStartTest);
$test8 = (empty($s8->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test8;
echo "The error for started_hobby is: ". $s8->getError('started_hobby') ."<br>";
echo "The object is: $s8<br>";
?>

<h2>It should have an error when the hobby start date format is invalid</h2>
<?php 
$invalidHobbyStartTest = array("started_hobby" => "wxyz-123");
$s9 = new UserData($invalidHobbyStartTest);
$test9 = (empty($s9->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test9;
echo "The error for started_hobby is: ". $s9->getError('started_hobby') ."<br>";
echo "The object is: $s9<br>";
?>

<h2>It should have an error when the hobby start date format is invalid</h2>
<?php 
$invalidHobbyStartTest = array("started_hobby" => "1960-03");
$s10 = new UserData($invalidHobbyStartTest);
$test10 = (empty($s10->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test10;
echo "The error for started_hobby is: ". $s10->getError('started_hobby') ."<br>";
echo "The object is: $s10<br>";
?>

<h2>It should have an error when the url is invalid</h2>
<?php 
$invalidUrlTest = array("url" => "invalidsite");
$s11 = new UserData($invalidUrlTest);
$test11 = (empty($s11->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test11;
echo "The error for url is: ". $s11->getError('url') ."<br>";
echo "The object is: $s11<br>";
?>

<h2>It should have an error when the phone number is invalid</h2>
<?php 
$invalidPhoneTest = array("phone" => "abc-def-ghij");
$s12 = new UserData($invalidPhoneTest);
$test12 = (empty($s12->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test12;
echo "The error for phone is: ". $s12->getError('phone') ."<br>";
echo "The object is: $s12<br>";
?>

<h2>It should have an error when the favorite color is empty</h2>
<?php 
$invalidFavColorTest = array("fav_color" => "");
$s13 = new UserData($invalidFavColorTest);
$test13 = (empty($s13->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test13;
echo "The error for fav_color is: ". $s13->getError('fav_color') ."<br>";
echo "The object is: $s13<br>";
?>

<h2>It should have an error when the favorite color is invalid</h2>
<?php 
$invalidFavColorTest = array("fav_color" => "#xyz123");
$s14 = new UserData($invalidFavColorTest);
$test14 = (empty($s14->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test14;
echo "The error for fav_color is: ". $s14->getError('fav_color') ."<br>";
echo "The object is: $s14<br>";
?>
</body>
</html>