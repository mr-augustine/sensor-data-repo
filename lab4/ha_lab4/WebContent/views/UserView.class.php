<?php
class UserView {
	
	public static function show() {
		$_SESSION['headertitle'] = "User details";
		$_SESSION['styles'] = array('site.css');
		
		MasterView::showHeader();
		MasterView::showNavBar();
		UserView::showDetails();
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showAll() {
		$_SESSION['styles'] = array('site.css');
		
		if (array_key_exists('headertitle', $_SESSION)) {
			MasterView::showHeader();
		}
		MasterView::showNavBar();
		
		$users = (array_key_exists('users', $_SESSION)) ? $_SESSION['users'] : array();
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		
		echo "<h1>botspace user list</h1>";
		echo "<table>";
		echo "<thead>";
		echo "<tr><th>userId</th><th>email</th><th>Show</th><th>Update</th></tr>";
		echo "</thead>";
		
		echo "<tbody>";
		foreach ($users as $user) {
			echo '<tr>';
			echo '<td>'.$user->getUserId().'</td>';
			echo '<td>'.$user->getEmail().'</td>';
			echo '<td><a href="/'.$base.'/user/show/'.$user->getUserId().'">Show</a></td>';
			echo '<td><a href="/'.$base.'/user/update/'.$user->getUserId().'">Update</a></td>';
			echo '</tr>';
		}
		echo "</tbody>";
		echo "</table>";
		
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showDetails() {
		$user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
		$userData = (array_key_exists('userData', $_SESSION)) ? $_SESSION['userData'] : null;
		$skillAssocs = (array_key_exists('skillAssocs', $_SESSION)) ? $_SESSION['skillAssocs'] : array();
		
		if (is_null($user) || is_null($userData))
			echo '<p>Unknown user</p>';
		else {
			echo '<h1>Profile for '.$userData->getUserName().'</h1>';
			
			echo '<section>';
			echo '<fieldset><legend>Login Info</legend>';
			echo 'Email:         '.$user->getEmail().'<br><br>'."\n";
			
			echo 'Password:      '.$user->getPassword().'<br><br>'."\n";
			echo '</fieldset><br>';
			echo '</section>';
			
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
		$user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		$_SESSION['headertitle'] = "botspace User Creator";
		$_SESSION['styles'] = array('site.css');
		MasterView::showHeader();
		MasterView::showNavBar();
		
		echo '<h1>Create a new User</h1>';
		
		echo '<form action="/'.$base.'/user/create/new" method="POST">';
		if (!is_null($user) && array_key_exists('userId', $user->getErrors()))
			echo 'Error: '.$user->getError('userId')."<br>";
		
		echo 'Email: <input type="text" name="email"';
			if (!is_null($user)) { echo 'value = "'.$user->getEmail().'"'; }
		echo 'tabindex="1" required>'."\n";
		echo '<span class="error">';
			if (!is_null($user)) { echo $user->getError('email'); }
		echo '</span><br><br>'."\n";
		
		echo 'Password: <input type="password" name="password" tabIndex="2" required>'."\n";
		echo '<span class="error">'."\n";
			if (!is_null($user)) { echo $user->getError('password'); }
		echo '</span><br><br>'."\n";
		
		echo '<p><input type="submit" name="submit" value="Submit">';
		echo '</form>';
		
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showUpdate() {
		$users = (array_key_exists('users', $_SESSION)) ? $_SESSION['users'] : null;
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		$_SESSION['headertitle'] = "botspace User Update";
		$_SESSION['styles'] = array('site.css');
		MasterView::showHeader();
		MasterView::showNavBar();
		
		echo '<h1>Update a User entry</h1>';
		
		if (is_null($users) || empty($users) || is_null($users[0])) {
			echo '<section>users does not exist</section>';
			return;
		}
		
		$user = $users[0];
		
		if ($user->getErrors() > 0) {
			$errors = $user->getErrors();
			echo '<section><p>Errors:<br>';
			
			foreach ($errors as $key => $value)
				echo $value . "<br>";
			
			echo '</p></section>';
		}
		
		echo '<section><form method="POST" action="/'.$base.
				'/user/update/'.$user->getUserId().'">';
		echo '<p>Email: <input type="text" name="email"';
		if (!is_null($user))
			echo 'value="'.$user->getEmail().'"';
		echo '><span class="error">';
		if (!is_null($user))
			echo $user->getError('email');
		echo '</span></p>';

		echo '<p>Password: <input type="password" name="password"><span class="error">';
		if (!is_null($user))
			echo $user->getError('password');
		echo '</span></p>';
		
		echo '<input type="submit" value="Submit">';
		echo '</form></section>';
		
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
}

?>