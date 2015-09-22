<?php  
class LoginView {
	
  public static function show($user) {  	
?> 
    <!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8">
	<meta name= "keywords" content="Botspace login">
	<meta name="description" content = "Login for Botspace">
	<title>Log into botspace</title>
	</head>
	<body>
	<img src="resources/images/botspace-logo.png" alt="bostpace logo" style="width:627px;height:126px;">
	
		<section>
		<h1>Log into botspace</h1>
		<form action="simpleEcho.php" method="post">
		<p>
		email<br>
		<input type="email" name="email" tabindex="1" required><br><br>
		password<br>
		<input type="password" name="password" tabindex="2" required>
		</p>
		
		<input type="submit" value="Submit">
		</form>
		</section>
	
	
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