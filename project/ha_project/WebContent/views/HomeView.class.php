<?php
class HomeView {
	
	public static function show() {
		$_SESSION['headertitle'] = "Sensor Data Repo";
		$_SESSION['styles'] = array('jumbotron.css', 'site.css');
		
		MasterView::showHeader();
		MasterView::showNavBar();
		HomeView::showDetails();
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showDetails() {
		$base = $_SESSION['base'];
		$_SESSION['footertitle'] = 'test username/pass = mwatney/aaaaaaaa';
		
		echo '<div class="jumbotron">';
		echo '<div class="container">';
		
		echo '<img class="logo" src="/'.$base.'/resources/images/sensor-data-repo-logo.png" alt="sensor data repo logo">';
		echo '<br><br>';
		echo '<p><strong>Sensor Data Repo</strong> is the free, simple, and structured way to share your sensor data with a community of peers.</p>';
		echo '</div>';
		echo '</div>';
	}
	
	public static function userLoggedIn() {
		return (array_key_exists("authenticatedUser", $_SESSION) && !is_null($_SESSION['authenticatedUser']));
	}
	
	public static function getLastNRegisteredUsers($n) {
		$lastNUsers = array();
		
		try {
			$registeredUsers = UsersDB::getUserDataBy();
		
			$lastNUsers = array_slice($registeredUsers, -$n, $n);
		} catch (Exception $e) {
			return $lastNUsers;
		}
		
		return $lastNUsers;
	}
}
?>