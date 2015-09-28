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
			Name:       <input type="text" name="user_name" tabindex="1" required><br><br>
			Email:      <input type="email" name="email" tabindex="2" required><br><br>
			Password:	<input type="password" name="password" tabindex="3" required><br><br>
			
			Skill Level:
			<input type="radio" name="skill_level" value="novice" tabindex="4" checked>Novice
			<input type="radio" name="skill_level" value="advanced" tabindex="5">Advanced
			<input type="radio" name="skill_level" value="expert" tabindex="6">Expert<br><br>
			
			<fieldset>
				<legend>Skill Areas</legend>
				<input type="checkbox" name="skill_areas[]" value="system-design" tabindex="7">system-design
				<input type="checkbox" name="skill_areas[]" value="programming" tabindex="8">programming
				<input type="checkbox" name="skill_areas[]" value="machining" tabindex="9">machining
				<input type="checkbox" name="skill_areas[]" value="soldering" tabindex="10">soldering
				<input type="checkbox" name="skill_areas[]" value="wiring" tabindex="11">wiring
				<input type="checkbox" name="skill_areas[]" value="circuit-design" tabindex="12">circuit-design
				<input type="checkbox" name="skill_areas[]" value="power-systems" tabindex="13">power-systems
				<input type="checkbox" name="skill_areas[]" value="computer-vision" tabindex="14">computer-vision
				<input type="checkbox" name="skill_areas[]" value="ultrasonic" tabindex="15">ultrasonic
				<input type="checkbox" name="skill_areas[]" value="infrared" tabindex="16">infrared
				<input type="checkbox" name="skill_areas[]" value="gps" tabindex="17">GPS
				<input type="checkbox" name="skill_areas[]" value="compass" tabindex="18">compass
			</fieldset><br>
		
			Profile Picture: <input type="file" name="profile_pic" accept="image/*" tabindex="19"><br><br>
			Started Robotics: <input type="month" name="started_hobby" min="1970-01" max="<?php echo date("Y-m")?>" tabindex="20"><br><br>
			Favorite Color: <input type="color" name="fav_color" tabindex="21"><br><br>
			URL: <input type="url" name="url" tabindex="22"><br><br>
			Telephone: <input type="tel" name="phone" tabindex="23"><br><br>
			
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