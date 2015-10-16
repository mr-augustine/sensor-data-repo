<?php
class SignupView {
	
	public static function show($user, $userData) {
		$_SESSION['headertitle'] = "Sign up for a botspace account";
		MasterView::showHeader();
		SignupView::showDetails($user, $userData);
		MasterView::showFooter();
	}

	public static function showDetails($user, $userData) {
  		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
  		
		echo '<img src="resources/images/botspace-logo.png" alt="bostpace logo" style="width:627px;height:126px;">'."\n";
	
		echo '<section>'."\n";
		echo '<h1>Create an account</h1>'."\n";
		echo '<form action="signup" method="post">'."\n";
		echo 'Name:       <input type="text" name="user_name"'; 
			if (!is_null($userData)) { echo 'value = "'. $userData->getUserName() .'"'; }
		echo 'tabindex="1" required>'."\n";
		echo '<span class="error">'."\n";
			if (!is_null($userData)) { echo $userData->getError('user_name'); }
		echo '</span><br><br>'."\n";
			
		echo 'Email:      <input type="email" name="email"'; 
			if (!is_null($user)) { echo 'value = "'. $user->getEmail() .'"'; }
		echo 'tabindex="2" required>'."\n";
		echo '<span class="error">'."\n";
			if (!is_null($user)) { echo $user->getError('email'); }
		echo '</span><br><br>'."\n";
			
		echo 'Password:   <input type="password" name="password" tabindex="3" required>'."\n";
		echo '<span class="error">'."\n";
			if (!is_null($user)) { echo $user->getError('password'); }
		echo '</span><br><br>'."\n";
			
		echo 'Skill Level:'."\n";
		echo '<input type="radio" name="skill_level" value="novice" tabindex="4"'; 
			if ((is_null($userData)) || 
					(!is_null($userData) && strcmp($userData->getSkillLevel(), UserData::$SKILL_LEVELS['0']) == 0)) {
					echo "checked";
			}
		echo '>Novice';
		echo '<input type="radio" name="skill_level" value="advanced" tabindex="5"';
			if (!is_null($userData) && strcmp($userData->getSkillLevel(), UserData::$SKILL_LEVELS['1']) == 0) {
				echo "checked";
			}
		echo '>Advanced';
		echo '<input type="radio" name="skill_level" value="expert" tabindex="6"';
			if (!is_null($userData) && strcmp($userData->getSkillLevel(), UserData::$SKILL_LEVELS['2']) == 0) {
				echo "checked";
			}
		echo '>Expert'."\n";
		echo '<span class="error">'."\n";
			if (!is_null($userData)) { echo $userData->getError('skill_level'); }
		echo  '</span><br><br>'."\n";
			
		if (!is_null($userData)) { echo $userData->getError('skill_area').'<br>'; }
		echo '<fieldset>'."\n";
		echo '<legend>Skill Areas</legend>'."\n";
		echo '<input type="checkbox" name="skill_areas[]" value="system-design" tabindex="7"';
			if (!is_null($userData) && in_array("system-design", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>system-design';
		echo '<input type="checkbox" name="skill_areas[]" value="programming" tabindex="8"';
			if (!is_null($userData) && in_array("programming", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>programming';
		echo '<input type="checkbox" name="skill_areas[]" value="machining" tabindex="9"';
			if (!is_null($userData) && in_array("machining", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>machining';
		echo '<input type="checkbox" name="skill_areas[]" value="soldering" tabindex="10"';
			if (!is_null($userData) && in_array("soldering", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>soldering';
		echo '<input type="checkbox" name="skill_areas[]" value="wiring" tabindex="11"';
			if (!is_null($userData) && in_array("wiring", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>wiring';
		echo '<input type="checkbox" name="skill_areas[]" value="circuit-design" tabindex="12"';
			if (!is_null($userData) && in_array("circuit-design", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>circuit-design';
		echo '<input type="checkbox" name="skill_areas[]" value="power-systems" tabindex="13"';
			if (!is_null($userData) && in_array("power-systems", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>power-systems';
		echo '<input type="checkbox" name="skill_areas[]" value="computer-vision" tabindex="14"';
			if (!is_null($userData) && in_array("computer-vision", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>computer-vision';
		echo '<input type="checkbox" name="skill_areas[]" value="ultrasonic" tabindex="15"';
			if (!is_null($userData) && in_array("ultrasonic", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>ultrasonic';
		echo '<input type="checkbox" name="skill_areas[]" value="infrared" tabindex="16"';
			if (!is_null($userData) && in_array("infrared", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>infrared';
		echo '<input type="checkbox" name="skill_areas[]" value="gps" tabindex="17"';
			if (!is_null($userData) && in_array("gps", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>GPS';
		echo '<input type="checkbox" name="skill_areas[]" value="compass" tabindex="18"';
			if (!is_null($userData) && in_array("compass", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>compass'."\n";
		echo '</fieldset><br>'."\n";
		
		echo 'Profile Picture: <input type="file" name="profile_pic" accept="image/*" tabindex="19">';
		if (!is_null($userData)) { echo $userData->getError('profile_pic'); }
		echo '<br><br>';
			
		echo 'Started Robotics: <input type="month" name="started_hobby" min="1970-01" max="';
		echo 'date("Y-m")';
		echo 'tabindex="20"';
			if (!is_null($userData) && !empty($userData->getStartedHobby())) {
				echo 'value="'.$userData->getStartedHobby().'"';
			}
		echo '>'."\n";
		if (!is_null($userData)) {echo $userData->getError('started_hobby');}
		echo '<br><br>';
			
		echo 'Favorite Color: <input type="color" name="fav_color" tabindex="21"';
			if (!is_null($userData) && !empty($userData->getFavColor())) {
				echo 'value="'.$userData->getFavColor().'"';
			}
		echo '>'."\n";
			if (!is_null($userData)) { echo $userData->getError('fav_color'); }
		echo '<br><br>'."\n";
			
		echo 'URL: <input type="url" name="url" tabindex="22"';
			if (!is_null($userData)) { echo 'value="'.$userData->getUrl().'"'; }
		echo '>';
			if (!is_null($userData)) { echo $userData->getError('url'); }
		echo '<br><br>'."\n";
			
		echo 'Telephone: <input type="tel" name="phone" tabindex="23"';
			if (!is_null($userData)) { echo 'value="'.$userData->getPhone().'"'; }
		echo '>'."\n";
			if (!is_null($userData)) { echo $userData->getError('phone'); }
		echo '<br><br>'."\n";
			
		echo '<input type="submit" value="Submit">'."\n";
		echo '</form>'."\n";
		echo '</section>'."\n";
 
	}
}
?>