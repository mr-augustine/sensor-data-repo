<?php
class CreateView {
	
	public static function show() {
		$_SESSION['headertitle'] = "Create botspace objects";
		$_SESSION['styles'] = array('site.css');
		MasterView::showHeader();
		MasterView::showNavBar();
		CreateView::showDetails();
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showDetails() {
		$base = $_SESSION['base'];
		
		echo '<h2>Create botspace objects</h2>';
		echo '<ul>';
		echo '<li> <a href="/'.$base.'/user/create">A new user</a> (User.class)</li>';
		echo '<li> <a href="/'.$base.'/userdata/create">A new user data entry</a> (UserData.class)</li>';
		echo '<li> A new skill (admin only)</li>';
		echo '<li> A new skill association (use UserData create)</li>';
		echo '<li> <a href="/'.$base.'/robotdata/create">A new robot data entry</a> (RobotData.class)</li>';
		echo '</ul>';
	}
}
?>