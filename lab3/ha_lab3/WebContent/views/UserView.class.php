<?php
class UserView {
	
	public static function show() {
		$_SESSION['headertitle'] = "User details";
		MasterView::showHeader();
		UserView::showDetails();
		MasterView::showFooter();
	}
	
	public static function showAll() {
		if (array_key_exists('headertitle', $_SESSION)) {
			MasterView::showHeader();
		}
		
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
	}
	
	public static function showDetails() {
		
	}
	
	public static function showNew() {
		
	}
	
	public static function showUpdate() {
		
	}
}

?>