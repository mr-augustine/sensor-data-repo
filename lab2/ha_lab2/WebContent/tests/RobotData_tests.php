<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Basic tests for RobotData</title>
</head>
<body>
<h1>RobotData tests</h1>

<?php
include_once("../models/RobotData.class.php");
?>

<h2>It should create a valid RobotData object when all input is provided</h2>
<?php 
$validTest = array("robot_name" => "ValidRobotName",
		"creator" => "Valid_Creator",
		"status" => "retired");
$s1 = new RobotData($validTest);
echo "The object is: $s1<br>";
$test1 = (is_object($s1))?'':
'Failed:It should create a valid object when valid input is provided<br>';
echo $test1;
$test2 = (empty($s1->getErrors()))?'':
'Failed:It should not have errors when valid input is provided<br>';
echo $test2;
?>

<h2>It should extract the parameters that went in</h2>
<?php 
$props = $s1->getParameters();
print_r($props);
?>

<h2>It should have an error when the robot name is empty</h2>
<?php 
$invalidRobotNameTest = array("robot_name" => "");
$s3 = new RobotData($invalidRobotNameTest);
$test3 = (empty($s3->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test3;
echo "The error for robot_name is: ". $s3->getError('robot_name') ."<br>";
echo "The object is: $s3<br>";
?>

<h2>It should have an error when the creator name is empty</h2>
<?php 
$invalidCreatorNameTest = array("creator" => "");
$s4 = new RobotData($invalidCreatorNameTest);
$test4 = (empty($s4->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test4;
echo "The error for creator is: ". $s4->getError('creator') ."<br>";
echo "The object is: $s4<br>";
?>

<h2>It should have an error when the status is empty</h2>
<?php 
$invalidStatusTest = array("status" => "");
$s5 = new RobotData($invalidStatusTest);
$test5 = (empty($s5->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test5;
echo "The error for status is: ". $s5->getError('status') ."<br>";
echo "The object is: $s5<br>";
?>

<h2>It should have an error when the status is invalid</h2>
<?php 
$invalidStatusTest = array("status" => "invalid-status");
$s6 = new RobotData($invalidStatusTest);
$test6 = (empty($s6->getErrors()))?'':
'Failed:It should have errors when invalid input is provided<br>';
echo $test6;
echo "The error for status is: ". $s6->getError('status') ."<br>";
echo "The object is: $s6<br>";
?>
</body>
</html>
