<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Basic tests for Signup View</title>
</head>
<body>
<h1>Signup view tests</h1>

<?php
include_once("../views/SignupView.class.php");
?>

<h2>It should call show() without crashing</h2>
<?php 
SignupView::show(null, null);
?>
</body>
</html>
