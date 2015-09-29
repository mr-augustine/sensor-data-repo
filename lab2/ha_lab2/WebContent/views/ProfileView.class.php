<?php  
class ProfileView {
	
  public static function show($userData) {  	
?> 
    <!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8">
	<meta name= "keywords" content="Botspace profile">
	<meta name="description" content = "Profile for Human Botspace Member">
	<title>Botspace Profile</title>
	</head>
	<body>
	
	Here's the user!<br><br>
	<?php echo $userData; ?>
	
	
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