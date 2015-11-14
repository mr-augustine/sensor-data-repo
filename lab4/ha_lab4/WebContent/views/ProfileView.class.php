<?php  
class ProfileView {
	
	public static function show() { 
		$userData = (array_key_exists('userData', $_SESSION)) ? $_SESSION['userData'] : null;
		if (!is_null($userData))
			$userName = $userData->getUserName();
		
		$name = $userName."'s ";
		$_SESSION['headertitle'] = ($name != "'s ") ? $name." profile" : "Profile";
		$_SESSION['styles'] = array('site.css');
		
		MasterView::showHeader();
		MasterView::showNavBar();
		ProfileView::showDetails();
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	
	public static function showDetails() {
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		$user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
		$userData = (array_key_exists('userData', $_SESSION)) ? $_SESSION['userData'] : null;
		$skillAssocs = (array_key_exists('skillAssocs', $_SESSION)) ? $_SESSION['skillAssocs'] : array();
		$userRobots = (array_key_exists('userRobots', $_SESSION)) ? $_SESSION['userRobots'] : array();
		
		if (!is_null($user) && !is_null($userData)) {
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
				
			echo '</fieldset><br>';
			echo '</section>';
			
			echo '<section>';
			echo '<fieldset><legend>'.$userData->getUserName()."'s ".'Robots</legend>';
			
			if (count($userRobots) == 0) {
				echo '<p>No robots yet</p>';
			} else {
				echo '<ul>';

				foreach ($userRobots as $robot) {
					// TODO: change this to redirect to a robot profile
					echo '<li><a href="/'.$base.'/robotdata/show/'.$robot->getRobotId().'">'.
							$robot->getRobotName().'</a></li>';
				}
				
				echo '</ul>';
			}
			
			echo '</fieldset><br>';
			echo '</section>';
			
		} else {
			echo '<p>Unknown user</p>';
		}
	}
//     <!DOCTYPE html>
// 	<html>
// 	<head>
// 	<meta charset="utf-8">
// 	<meta name= "keywords" content="Botspace Human profile">
// 	<meta name="description" content = "Profile for Human Botspace Member">
// 	<title>Botspace Human Profile</title>
// 	</head>
// 	<body>
	
// 	<a href="home">HOME</a><br><br>
	
// 	Here's the user!<br><br>
// 	<?php echo $_SESSION['userData'];
	
	
// 	<footer>
// 		<hr>
	
// 		<nav>
// 		<a href="">Tour</a> |
// 		<a href="">About</a> |
// 		<a href="">Help</a> |
// 		<a href="">Terms</a> |
// 		<a href="">Privacy</a>
// 		</nav>
// 	</footer>
// 	</body>
// 	</html>

}
?>