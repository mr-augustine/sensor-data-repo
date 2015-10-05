<?php  
class RobotProfileView {
	
  public static function show($robotData) {  	
?> 
    <!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8">
	<meta name= "keywords" content="Botspace Robot profile">
	<meta name="description" content = "Profile for Robot Botspace Member">
	<title>Botspace Robot Profile</title>
	</head>
	<body>
	
	<a href="home">HOME</a><br><br>
	
	Here's the robot!<br><br>
	<?php echo $robotData; ?>
	
	
	<footer>
		<hr>
	
		<nav>
		<a href="">Tour</a> |
		<a href="">About</a> |
		<a href="">Help</a> |
		<a href="">Terms</a> |
		<a href="">Privacy</a>
		</nav>
	</footer>
	</body>
	</html>
<?php 
  }
}
?>