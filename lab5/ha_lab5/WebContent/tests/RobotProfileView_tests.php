<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Basic tests for RobotProfile View</title>
</head>
<body>
<h1>RobotProfile view tests</h1>

<?php
include_once("../views/RobotProfileView.class.php");
include_once("../models/RobotData.class.php");
?>

<h2>It should call show() without crashing</h2>
<?php 
$validRobotData = array("robot_name" => "MSE-6",
		"creator" => "Admiral_Ackbar",
		"status" => "in-development"
);
$sampleRobot = new RobotData($validRobotData);
RobotProfileView::show($sampleRobot);
?>
</body>
</html>
