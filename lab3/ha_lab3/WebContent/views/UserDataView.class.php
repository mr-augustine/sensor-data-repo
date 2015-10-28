<?php
class UserDataView {
	
	public static function show() {
		$_SESSION['headertitle'] = "UserData details";
		MasterView::showHeader();
		UserDataView::showDetails();
		MasterView::showFooter();
	}
	
	public static function showAll() {
		if (array_key_exists('headertitle', $_SESSION)) {
			MasterView::showHeader();
		}
		
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
	}
	
	public static function showDetails() {
		$userData = (array_key_exists('userData', $_SESSION)) ? $_SESSION['userData'] : null;
		$skillAssocs = (array_key_exists('skillAssocs', $_SESSION)) ? $_SESSION['skillAssocs'] : array();
		
		if (is_null($userData))
			echo '<p>Unknown user data</p>';
		else {
			echo '<h1>UserData for userId #'.$userData->getUserId().'</h1>';
			
			echo '<section>';
			echo '<fieldset><legend>User Data</legend>';
			echo 'Username:      '.$userData->getUserName().'<br><br>'."\n";
			echo 'Skill Level:   '.$userData->getSkillLevel().'<br><br>'."\n";
			echo 'Skills:        ';
			
			foreach ($skillAssocs as $skillAssoc) {
				$skills = SkillsDB::getSkillsBy('skillId', $skillAssoc->getSkillId());
				$skill = $skills[0];
				echo $skill->getSkillName()."  ";
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
		
	}
	
	public static function showUpdate() {
	
	}
}

?>