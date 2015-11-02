<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Basic tests for Home View</title>
</head>
<body>
<h1>Home view tests</h1>

<?php
include_once("../views/HomeView.class.php");
?>

<h2>It should call show() without crashing</h2>
<?php 
HomeView::show();
?>
</body>
</html>
