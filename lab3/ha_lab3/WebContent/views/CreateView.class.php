<?php
class CreateView {
	
	public static function show() {
		$_SESSION['headertitle'] = "Create botspace objects";
		MasterView::showHeader();
		CreateView::showDetails();
		MasterView::showFooter();
	}
	
	public static function showDetails() {
		$base = $_SESSION['base'];
		
		echo '<h2>Create botspace objects</h2>';
		echo '<ul>';
		echo '<li> <a href="/'.$base.'/users/create">A new user</a> (User.class)</li>';
		echo '<li> <a href="/'.$base.'/userdata/create">A new user data entry</a> (UserData.class)</li>';
		echo '<li> A new skill (admin only)</li>';
		echo '<li> <a href="/'.$base.'/skillassocs/create">A new skill association</a> (SkillAssoc.class)</li>';
		echo '<li> <a href="/'.$base.'/robotdata/create">A new robot data entry</a> (RobotData.class)</li>';
		echo '</ul>';
	}
}
?>