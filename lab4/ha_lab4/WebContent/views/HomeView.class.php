<?php
class HomeView {

  	public static function show() {  
  		$_SESSION['headertitle'] = "botspace";
  		$_SESSION['styles'] = array('jumbotron.css', 'site.css');
  		
  		MasterView::showHeader();
  		MasterView::showNavBar();
  		HomeView::showDetails();
  		MasterView::showFooter();
  		MasterView::showPageEnd();
  	}
  	
  	public static function showDetails() {
  		$base = $_SESSION['base'];
  		$_SESSION['footertitle'] = 'test username/pass = mwatney@mars.com/aaaaaaaa';
  		
  		echo '<div class="jumbotron">';
  		echo '<div class="container">';

  		echo '<img class="logo" src="/'.$base.'/resources/images/botspace-badge.png" alt="botspace badge">';
  		echo '<br><br>';
  		echo '<p><strong>Botspace</strong> is the free, simple, and structured way to share your robot projects with a community of peers.</p>';
  		echo '<p>Talk to other hobbyists about their creations, or ask for help with your own. Botspace is a community to help you make your robots awesome!</p>';
  		echo '</div>';
  		echo '</div>';
  		
  		echo '<aside><section>';
  		echo '<h2>Robot Showcase</h2>';
  		echo '<ul>';
  		
  		$newestRobots = self::getLastNCreatedRobots(3);
  		
  		if (count($newestRobots) == 0) {
  			echo '<li>No Robots Available Yet</li>';
  		} else {
  			foreach ($newestRobots as $robot) {
  				echo '<li><a href="/'.$base.'/robotdata/show/'.$robot->getRobotId().'">'.
    				$robot->getRobotName().'</a></li>';
  			}
  		}
  		
//   		echo '<li><a href="">Robot 1</a></li>';
//   		echo '<li><a href="">Robot 2</a></li>';
//   		echo '<li><a href="">Robot 3</a></li>';	
  		
  		echo '</ul></section>';
  		echo '<section>';
  		echo '<h2>Newest Members</h2>';
  		echo '<ul>';
  		
  		$newestMembers = self::getLastNRegisteredUsers(3);
  		
  		if (count($newestMembers) == 0) {
  			echo '<li>No Members Available Yet</li>';
  		} else {
  		
	  		foreach ($newestMembers as $member) {
	  			echo '<li><a href="/'.$base.'/userdata/show/'.$member->getUserDataId().'">'.
	    			$member->getUserName().'</a></li>';
	  		}
  		}
  		
  		echo '</ul></section>';
  		echo '<aside>';
  	}
  	
  	public static function userLoggedIn() {
  		return (array_key_exists("authenticatedUser", $_SESSION) && !is_null($_SESSION['authenticatedUser']));
  	}
  	
  	public static function getLastNRegisteredUsers($n) {
  		$lastNUsers = array();
  		
  		try {
  			$registeredUsers = UserDataDB::getUserDataBy();
  		
  			$lastNUsers = array_slice($registeredUsers, -$n, $n);
  		} catch (Exception $e) {
  			return $lastNUsers;
  		}
  		
  		return $lastNUsers;
  	}
  	
  	public static function getLastNCreatedRobots($n) {
  		$lastNRobots = array();
  		
  		try {
  			$robots = RobotDataDB::getRobotDataBy();
  			
  			$lastNRobots = array_slice($robots, -$n, $n);
  		} catch (Exception $e) {
  			return $lastRobots;
  		}
  		
  		return $lastNRobots;
  	}
}
?>