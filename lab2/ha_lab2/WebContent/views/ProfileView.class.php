<?php  
class ProfileView {
	
  public static function show($userData) {  	
?> 
    <!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8">
	<meta name= "keywords" content="Botspace Human profile">
	<meta name="description" content = "Profile for Human Botspace Member">
	<title>Botspace Human Profile</title>
	</head>
	<body>
	
	<a href="home">HOME</a><br><br>
	
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