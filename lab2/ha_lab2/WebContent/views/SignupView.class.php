<?php
class SignupView {
	
	public static function show($user) {
?>		
	<!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8">
	<title>Sign up for a botspace account</title>
	</head>
	<body>
	<img src="resources/images/botspace-logo.png" alt="bostpace logo" style="width:627px;height:126px;">
	
		<section>
		<h1>Create an account</h1>
		<form action="simpleEcho.php" method="post">
			Name:       <input type="text" name="name" tabindex="1" required><br><br>
			Email:      <input type="email" name="email" tabindex="2" required><br><br>
			Password:	<input type="password" name="password" tabindex="3" required><br><br>
			
			Skill Level:
			<input type="radio" name="skill_level" value="Novice" tabindex="4" checked>Novice
			<input type="radio" name="skill_level" value="Advanced" tabindex="5">Advanced
			<input type="radio" name="skill_level" value="Expert" tabindex="6">Expert<br><br>
			
			<fieldset>
				<legend>Skill Areas</legend>
				<input type="checkbox" name="skill_area" value="sensors" tabindex="7">sensors	
				<input type="checkbox" name="skill_area" value="code" tabindex="8">code	
				<input type="checkbox" name="skill_area" value="mechanisms" tabindex="9">mechanisms
			</fieldset><br>
		
			Profile Picture: <input type="file" id="fileinput" accept="image/*" tabindex="10"><br><br>
			Started Robotics: <input type="month" id="first_hobby" tabindex="11"><br><br>
			Favorite Color: <input type="color" name="fav_color" tabindex="12"><br><br>
			URL: <input type="url" name="url" tabindex="13"><br><br>
			Telephone: <input type="tel" name="phone" tabindex="14"><br><br>
			
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