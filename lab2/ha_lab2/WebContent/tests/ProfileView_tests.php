<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Basic tests for Profile View</title>
</head>
<body>
<h1>Profile view tests</h1>

<?php
include_once("../views/ProfileView.class.php");
include_once("../models/UserData.class.php");
?>

<h2>It should call show() without crashing</h2>
<?php 
$validUserData = array("user_name" => "Admiral_Ackbar",
		"skill_level" => "expert",
		"skill_areas" => array("system-design", "programming", "wiring"),
		"profile_pic" => "ackbar.jpg",
		"started_hobby" => "1983-05",
		"fav_color" => "#ff0000",
		"url" => "http://www.itsatrap.com",
		"phone" => "210-458-4436"
);
$sampleUser = new UserData($validUserData);
ProfileView::show($sampleUser);
?>
</body>
</html>
