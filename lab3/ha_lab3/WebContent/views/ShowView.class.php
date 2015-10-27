<?php
class ShowView {
	
	public static function show() {
		$_SESSION['headertitle'] = "Show botspace objects";
		MasterView::showHeader();
		ShowView::showDetails();
		MasterView::showFooter();
	}
	
	public static function showDetails() {
		$base = $_SESSION['base'];
		
		echo '<h2>Show botspace objects</h2>';
		echo '<ul>';
		echo '<li> <a href="/'.$base.'/users/show/all">All users</a> (User.class)</li>';
		echo '<li> <a href="/'.$base.'/userdata/show/all">All user data</a> (UserData.class)</li>';
		echo '<li> <a href="/'.$base.'/skills/show/all">All skills</a> (Skill.class)</li>';
		echo '<li> <a href="/'.$base.'/skillassocs/show/all">All skill associations</a> (SkillAssoc.class)</li>';
		echo '<li> <a href="/'.$base.'/robotdata/show/all">All robot data</a> (RobotData.class)</li>';
		echo '</ul>';
	}
}
?>