<?php
class SignupView {
	
	public static function show($user, $userData) {
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
			Name:       <input type="text" name="user_name" 
			<?php if (!is_null($userData)) {echo 'value = "'. $userData->getUserName() .'"';}?> tabindex="1" required><br><br>
			Email:      <input type="email" name="email" 
			<?php if (!is_null($user)) {echo 'value = "'. $user->getEmail() .'"';}?> tabindex="2" required><br><br>
			Password:	<input type="password" name="password" tabindex="3" required><br><br>
			
			Skill Level:
			<input type="radio" name="skill_level" value="novice" tabindex="4" 
			<?php
				if (!is_null($userData) && strcmp($userData->getSkillLevel(), UserData::$SKILL_LEVELS['0']) == 0) {
					echo "checked";
				} ?> >Novice
			<input type="radio" name="skill_level" value="advanced" tabindex="5"
			<?php
				if (!is_null($userData) && strcmp($userData->getSkillLevel(), UserData::$SKILL_LEVELS['1']) == 0) {
					echo "checked";
				} ?> >Advanced
			<input type="radio" name="skill_level" value="expert" tabindex="6"
			<?php
				if (!is_null($userData) && strcmp($userData->getSkillLevel(), UserData::$SKILL_LEVELS['2']) == 0) {
					echo "checked";
				} ?> >Expert<br><br>
			
			<fieldset>
				<legend>Skill Areas</legend>
				<input type="checkbox" name="skill_areas[]" value="system-design" tabindex="7"
				<?php if (!is_null($userData) && in_array("system-design", $userData->getSkillAreas())) {
						echo "checked";
					}
				?>>system-design
				<input type="checkbox" name="skill_areas[]" value="programming" tabindex="8"
				<?php if (!is_null($userData) && in_array("programming", $userData->getSkillAreas())) {
						echo "checked";
					}
				?>>programming
				<input type="checkbox" name="skill_areas[]" value="machining" tabindex="9"
				<?php if (!is_null($userData) && in_array("machining", $userData->getSkillAreas())) {
						echo "checked";
					}
				?>>machining
				<input type="checkbox" name="skill_areas[]" value="soldering" tabindex="10"
				<?php if (!is_null($userData) && in_array("soldering", $userData->getSkillAreas())) {
						echo "checked";
					}
				?>>soldering
				<input type="checkbox" name="skill_areas[]" value="wiring" tabindex="11"
				<?php if (!is_null($userData) && in_array("wiring", $userData->getSkillAreas())) {
						echo "checked";
					}
				?>>wiring
				<input type="checkbox" name="skill_areas[]" value="circuit-design" tabindex="12"
				<?php if (!is_null($userData) && in_array("circuit-design", $userData->getSkillAreas())) {
						echo "checked";
					}
				?>>circuit-design
				<input type="checkbox" name="skill_areas[]" value="power-systems" tabindex="13"
				<?php if (!is_null($userData) && in_array("power-systems", $userData->getSkillAreas())) {
						echo "checked";
					}
				?>>power-systems
				<input type="checkbox" name="skill_areas[]" value="computer-vision" tabindex="14"
				<?php if (!is_null($userData) && in_array("computer-vision", $userData->getSkillAreas())) {
						echo "checked";
					}
				?>>computer-vision
				<input type="checkbox" name="skill_areas[]" value="ultrasonic" tabindex="15"
				<?php if (!is_null($userData) && in_array("ultrasonic", $userData->getSkillAreas())) {
						echo "checked";
					}
				?>>ultrasonic
				<input type="checkbox" name="skill_areas[]" value="infrared" tabindex="16"
				<?php if (!is_null($userData) && in_array("infrared", $userData->getSkillAreas())) {
						echo "checked";
					}
				?>>infrared
				<input type="checkbox" name="skill_areas[]" value="gps" tabindex="17"
				<?php if (!is_null($userData) && in_array("gps", $userData->getSkillAreas())) {
						echo "checked";
					}
				?>>GPS
				<input type="checkbox" name="skill_areas[]" value="compass" tabindex="18"
				<?php if (!is_null($userData) && in_array("compass", $userData->getSkillAreas())) {
						echo "checked";
					}
				?>>compass
			</fieldset><br>
		
			Profile Picture: <input type="file" name="profile_pic" accept="image/*" tabindex="19">
			<?php if (!is_null($userData)) { echo $userData->getError('profile_pic'); }?><br><br>
			Started Robotics: <input type="month" name="started_hobby" min="1970-01" max="<?php echo date("Y-m")?>" tabindex="20"
			<?php if (!is_null($userData) && !empty($userData->getStartedHobby())) {
					echo 'value="'.$userData->getStartedHobby().'"';
				}
			?>>
			<?php if (!is_null($userData)) {echo $userData->getError('started_hobby');}?><br><br>>
			Favorite Color: <input type="color" name="fav_color" tabindex="21"
			<?php if (!is_null($userData) && !empty($userData->getFavColor())) {
					echo 'value="'.$userData->getFavColor().'"';
				}
			?>>
			<?php if (!is_null($userData)) { echo $userData->getError('fav_color'); }?><br><br>>
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