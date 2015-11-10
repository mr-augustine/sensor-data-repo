<?php
class UserDataView {
	
	public static function show() {
		$_SESSION['headertitle'] = "UserData details";
		$_SESSION['styles'] = array('site.css');
		
		MasterView::showHeader();
		MasterView::showNavBar();
		UserDataView::showDetails();
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showAll() {
		$_SESSION['styles'] = array('site.css');
		
		if (array_key_exists('headertitle', $_SESSION)) {
			MasterView::showHeader();
		}
		MasterView::showNavBar();
		
		$userData = (array_key_exists('userData', $_SESSION)) ? $_SESSION['userData'] : array();
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		
		echo "<h1>botspace user data list</h1>";
		echo "<table>";
		echo "<thead>";
		echo "<tr><th>userDataId</th><th>userId</th><th>user_name</th><th>skill_level</th>
				<th>profile_pic</th><th>started_hobby</th><th>fav_color</th>
				<th>url</th><th>phone</th><th>Show</th><th>Update</th>";
		echo "</thead>";
		
		echo "<tbody>";
		foreach ($userData as $data) {
			echo '<tr>';
			echo '<td>'.$data->getUserDataId().'</td>';
			echo '<td>'.$data->getUserId().'</td>';
			echo '<td>'.$data->getUserName().'</td>';
			echo '<td>'.$data->getSkillLevel().'</td>';
			echo '<td>'.$data->getProfilePic().'</td>';
			echo '<td>'.$data->getStartedHobby().'</td>';
			echo '<td>'.$data->getFavColor().'</td>';
			echo '<td>'.$data->getUrl().'</td>';
			echo '<td>'.$data->getPhone().'</td>';
			echo '<td><a href="/'.$base.'/userdata/show/'.$data->getUserDataId().'">Show</a></td>';
			echo '<td><a href="/'.$base.'/userdata/update/'.$data->getUserDataId().'">Update</a></td>';
			echo '</tr>';
		}
		echo "</tbody>";
		echo "</table>";
		
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showDetails() {
		$userData = (array_key_exists('userData', $_SESSION)) ? $_SESSION['userData'] : null;
		//$skillAssocs = (array_key_exists('skillAssocs', $_SESSION)) ? $_SESSION['skillAssocs'] : array();
		$skills = (array_key_exists('skills', $_SESSION)) ? $_SESSION['skills'] : array();
		
		if (is_null($userData))
			echo '<p>Unknown user data</p>';
		else {
			echo '<h1>UserData for userId #'.$userData->getUserId().'</h1>';
			
			echo '<section>';
			echo '<fieldset><legend>User Data</legend>';
			echo 'Username:      '.$userData->getUserName().'<br><br>'."\n";
			echo 'Skill Level:   '.$userData->getSkillLevel().'<br><br>'."\n";
			echo 'Skills:        ';
			
			// FIXME: Don't allow a View to make DB calls; do this in the Controller instead
// 			foreach ($skillAssocs as $skillAssoc) {
// 				$skills = SkillsDB::getSkillsBy('skillId', $skillAssoc->getSkillId());
// 				$skill = $skills[0];
// 				echo $skill->getSkillName()."  ";
// 			}

			foreach ($skills as $skill) {
				echo $skill->getSkillName()." ";
			}
			
			echo "<br><br>";
			echo 'Profile Pic:   '.$userData->getProfilePic().'<br><br>'."\n";
			echo 'Started Hobby: '.$userData->getStartedHobby().'<br><br>'."\n";
			echo 'Fav Color:     '.$userData->getFavColor().'<br><br>'."\n";
			echo 'Url:           '.$userData->getUrl().'<br><br>'."\n";
			echo 'Phone:         '.$userData->getPhone().'<br><br>'."\n";
			
			// Insert RobotData 
			echo '</fieldset><br>';
			echo '</section>';
		}
	}
	
	public static function showNew() {
		$userData = (array_key_exists('userData', $_SESSION)) ? $_SESSION['userData'] : null;
		$skillAssocs = (array_key_exists('skillAssocs', $_SESSION)) ? $_SESSION['skillAssocs'] : array();
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		$_SESSION['headertitle'] = "botspace UserData Creator";
		$_SESSION['styles'] = array('site.css');
		MasterView::showHeader();
		MasterView::showNavBar();
		
		// First find some available userIds to associate the new UserData with
		$users = UsersDB::getUsersBy();
		$availableUsers = array();
		
		if (!is_null($users) && count($users) > 0) {
			foreach ($users as $user) {
				$userDataArray = UserDataDB::getUserDataBy('userId', $user->getUserId());
				
				if (count($userDataArray) == 0)
					array_push($availableUsers, $user);
			}
		}
		
		echo '<h1>Create a new UserData entry</h1>';
		
		echo '<form action="/'.$base.'/userdata/create/new" method="POST">';
		if (!is_null($userData) && array_key_exists('userDataId', $userData->getErrors()))
			echo 'Error: '.$userData->getError('userDataId')."<br>";
		
		echo 'UserId:  ';
		echo '<select name="userId">';
		echo '<option value="0"> </option>';
		foreach ($availableUsers as $availUser) {
			$userId = $availUser->getUserId();
			
			echo '<option value="'.$userId.'">'.$userId.'</option>';
		}
		echo '</select><br><br>';
		
		echo 'Name: <input type="text" name="user_name"';
			if (!is_null($userData)) { echo 'value = "'.$userData->getUserName().'"'; }
		echo 'tabindex="2" required>'."\n";
		echo '<span class="error">';
			if (!is_null($userData)) { echo $userData->getError('user_name'); }
		echo '</span><br><br>'."\n";
		
		echo 'Skill Level: <input type="radio" name="skill_level" value="novice" tabindex="3"';
			if ((is_null($userData)) ||
					(!is_null($userData) && strcmp($userData->getSkillLevel(), UserData::$SKILL_LEVELS['0']) == 0)) {
					echo "checked";	
			}
		echo '>Novice';
		echo '<input type="radio" name="skill_level" value="advanced" tabindex="4"';
			if (!is_null($userData) && strcmp($userData->getSkillLevel(), UserData::$SKILL_LEVELS['1']) == 0) {
				echo "checked";
			}
		echo '>Advanced';
		echo '<input type="radio" name="skill_level" value="expert" tabindex="5"';
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
		echo '<input type="checkbox" name="skill_areas[]" value="system-design" tabindex="6"';
			if (!is_null($userData) && in_array("system-design", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>system-design';
		echo '<input type="checkbox" name="skill_areas[]" value="programming" tabindex="7"';
			if (!is_null($userData) && in_array("programming", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>programming';
		echo '<input type="checkbox" name="skill_areas[]" value="machining" tabindex="8"';
			if (!is_null($userData) && in_array("machining", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>machining';
		echo '<input type="checkbox" name="skill_areas[]" value="soldering" tabindex="9"';
			if (!is_null($userData) && in_array("soldering", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>soldering';
		echo '<input type="checkbox" name="skill_areas[]" value="wiring" tabindex="10"';
			if (!is_null($userData) && in_array("wiring", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>wiring';
		echo '<input type="checkbox" name="skill_areas[]" value="circuit-design" tabindex="11"';
			if (!is_null($userData) && in_array("circuit-design", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>circuit-design';
		echo '<input type="checkbox" name="skill_areas[]" value="power-systems" tabindex="12"';
			if (!is_null($userData) && in_array("power-systems", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>power-systems';
		echo '<input type="checkbox" name="skill_areas[]" value="computer-vision" tabindex="13"';
			if (!is_null($userData) && in_array("computer-vision", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>computer-vision';
		echo '<input type="checkbox" name="skill_areas[]" value="ultrasonic" tabindex="14"';
			if (!is_null($userData) && in_array("ultrasonic", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>ultrasonic';
		echo '<input type="checkbox" name="skill_areas[]" value="infrared" tabindex="15"';
			if (!is_null($userData) && in_array("infrared", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>infrared';
		echo '<input type="checkbox" name="skill_areas[]" value="gps" tabindex="16"';
			if (!is_null($userData) && in_array("gps", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>GPS';
		echo '<input type="checkbox" name="skill_areas[]" value="compass" tabindex="17"';
			if (!is_null($userData) && in_array("compass", $userData->getSkillAreas())) {
				echo "checked";
			}
		echo '>compass'."\n";
		echo '</fieldset><br>'."\n";
		
		echo 'Profile Picture: <input type="file" name="profile_pic" accept="image/*" tabindex="18">';
			if (!is_null($userData)) { echo $userData->getError('profile_pic'); }
		echo '<br><br>';
			
		echo 'Started Robotics: <input type="date" name="started_hobby" min="1970-01-01" max="';
		echo 'date("Y-m-d")';
		echo 'tabindex="19"';
			if (!is_null($userData) && !empty($userData->getStartedHobby())) {
				echo 'value="'.$userData->getStartedHobby().'"';
			}
		echo '>'."\n";
			if (!is_null($userData)) {echo $userData->getError('started_hobby');}
		echo '<br><br>';
			
		echo 'Favorite Color: <input type="color" name="fav_color" tabindex="20"';
			if (!is_null($userData) && !empty($userData->getFavColor())) {
				echo 'value="'.$userData->getFavColor().'"';
			}
		echo '>'."\n";
			if (!is_null($userData)) { echo $userData->getError('fav_color'); }
		echo '<br><br>'."\n";
			
		echo 'URL: <input type="url" name="url" tabindex="21"';
			if (!is_null($userData)) { echo 'value="'.$userData->getUrl().'"'; }
		echo '>';
			if (!is_null($userData)) { echo $userData->getError('url'); }
		echo '<br><br>'."\n";
			
		echo 'Telephone: <input type="tel" name="phone" tabindex="22"';
			if (!is_null($userData)) { echo 'value="'.$userData->getPhone().'"'; }
		echo '>'."\n";
			if (!is_null($userData)) { echo $userData->getError('phone'); }
		echo '<br><br>'."\n";
		
		
		echo '<p><input type="submit" name="submit" value="Submit">';
		echo '</form>';
		
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showUpdate() {
		$userDataArray = (array_key_exists('userData', $_SESSION)) ? $_SESSION['userData'] : null;
		$skillAssocs = (array_key_exists('skillAssocs', $_SESSION)) ? $_SESSION['skillAssocs'] : array();
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		$_SESSION['headertitle'] = "botspace UserData Update";
		$_SESSION['styles'] = array('site.css');
		MasterView::showHeader();
		MasterView::showNavBar();
		
		echo '<h1>Update a UserData entry</h1>';
		
		$userData = $userDataArray;
		
		if (is_array($userDataArray))
			$userData = $userDataArray[0];

		
		if (is_null($userDataArray) || empty($userDataArray) || is_null($userData)) {
			echo '<section>userdata does not exist</section>';
			return;
		}		
		
		if ($userData->getErrors() > 0) {
			$errors = $userData->getErrors();
			echo '<section><p>Errors:<br>';
			
			foreach ($errors as $key => $value)
				echo $value . "<br>";
			
			echo '</p></section>';
		}
		
		echo '<form method="POST" action="/'.$base.'/userdata/update/'.$userData->getUserDataId().'">';
		
		echo 'UserId:  '.$userData->getUserDataId()."<br><br>";
		
		echo 'Name: <input type="text" name="user_name"';
		if (!is_null($userData)) { echo 'value = "'.$userData->getUserName().'"'; }
		echo 'tabindex="2" required>'."\n";
		echo '<span class="error">';
		if (!is_null($userData)) { echo $userData->getError('user_name'); }
		echo '</span><br><br>'."\n";
		
		echo 'Skill Level: <input type="radio" name="skill_level" value="novice" tabindex="3"';
		if ((is_null($userData)) ||
			(!is_null($userData) && strcmp($userData->getSkillLevel(), UserData::$SKILL_LEVELS['0']) == 0)) {
			echo "checked";
		}
		echo '>Novice';
		echo '<input type="radio" name="skill_level" value="advanced" tabindex="4"';
		if (!is_null($userData) && strcmp($userData->getSkillLevel(), UserData::$SKILL_LEVELS['1']) == 0) {
			echo "checked";
		}
		echo '>Advanced';
		echo '<input type="radio" name="skill_level" value="expert" tabindex="5"';
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
		echo '<input type="checkbox" name="skill_areas[]" value="system-design" tabindex="6"';
		if (!is_null($userData) && in_array("system-design", $userData->getSkillAreas())) {
			echo "checked";
		}
		echo '>system-design';
		echo '<input type="checkbox" name="skill_areas[]" value="programming" tabindex="7"';
		if (!is_null($userData) && in_array("programming", $userData->getSkillAreas())) {
			echo "checked";
		}
		echo '>programming';
		echo '<input type="checkbox" name="skill_areas[]" value="machining" tabindex="8"';
		if (!is_null($userData) && in_array("machining", $userData->getSkillAreas())) {
			echo "checked";
		}
		echo '>machining';
		echo '<input type="checkbox" name="skill_areas[]" value="soldering" tabindex="9"';
		if (!is_null($userData) && in_array("soldering", $userData->getSkillAreas())) {
			echo "checked";
		}
		echo '>soldering';
		echo '<input type="checkbox" name="skill_areas[]" value="wiring" tabindex="10"';
		if (!is_null($userData) && in_array("wiring", $userData->getSkillAreas())) {
			echo "checked";
		}
		echo '>wiring';
		echo '<input type="checkbox" name="skill_areas[]" value="circuit-design" tabindex="11"';
		if (!is_null($userData) && in_array("circuit-design", $userData->getSkillAreas())) {
			echo "checked";
		}
		echo '>circuit-design';
		echo '<input type="checkbox" name="skill_areas[]" value="power-systems" tabindex="12"';
		if (!is_null($userData) && in_array("power-systems", $userData->getSkillAreas())) {
			echo "checked";
		}
		echo '>power-systems';
		echo '<input type="checkbox" name="skill_areas[]" value="computer-vision" tabindex="13"';
		if (!is_null($userData) && in_array("computer-vision", $userData->getSkillAreas())) {
			echo "checked";
		}
		echo '>computer-vision';
		echo '<input type="checkbox" name="skill_areas[]" value="ultrasonic" tabindex="14"';
		if (!is_null($userData) && in_array("ultrasonic", $userData->getSkillAreas())) {
			echo "checked";
		}
		echo '>ultrasonic';
		echo '<input type="checkbox" name="skill_areas[]" value="infrared" tabindex="15"';
		if (!is_null($userData) && in_array("infrared", $userData->getSkillAreas())) {
			echo "checked";
		}
		echo '>infrared';
		echo '<input type="checkbox" name="skill_areas[]" value="gps" tabindex="16"';
		if (!is_null($userData) && in_array("gps", $userData->getSkillAreas())) {
			echo "checked";
		}
		echo '>GPS';
		echo '<input type="checkbox" name="skill_areas[]" value="compass" tabindex="17"';
		if (!is_null($userData) && in_array("compass", $userData->getSkillAreas())) {
			echo "checked";
		}
		echo '>compass'."\n";
		echo '</fieldset><br>'."\n";

		echo 'Profile Picture: <input type="file" name="profile_pic" accept="image/*" tabindex="18">';
		if (!is_null($userData)) { echo $userData->getError('profile_pic'); }
		echo '<br><br>';
			
		echo 'Started Robotics: <input type="date" name="started_hobby" min="1970-01-01" max="';
		echo 'date("Y-m-d")';
		echo 'tabindex="19"';
		if (!is_null($userData) && !empty($userData->getStartedHobby())) {
			echo 'value="'.$userData->getStartedHobby().'"';
		}
		echo '>'."\n";
		if (!is_null($userData)) {echo $userData->getError('started_hobby');}
		echo '<br><br>';
			
		echo 'Favorite Color: <input type="color" name="fav_color" tabindex="20"';
		if (!is_null($userData) && !empty($userData->getFavColor())) {
			echo 'value="'.$userData->getFavColor().'"';
		}
		echo '>'."\n";
		if (!is_null($userData)) { echo $userData->getError('fav_color'); }
		echo '<br><br>'."\n";
			
		echo 'URL: <input type="url" name="url" tabindex="21"';
		if (!is_null($userData)) { echo 'value="'.$userData->getUrl().'"'; }
		echo '>';
		if (!is_null($userData)) { echo $userData->getError('url'); }
		echo '<br><br>'."\n";
			
		echo 'Telephone: <input type="tel" name="phone" tabindex="22"';
		if (!is_null($userData)) { echo 'value="'.$userData->getPhone().'"'; }
		echo '>'."\n";
		if (!is_null($userData)) { echo $userData->getError('phone'); }
		echo '<br><br>'."\n";


		echo '<p><input type="submit" name="submit" value="Submit">';
		echo '</form>';
		
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
}

?>