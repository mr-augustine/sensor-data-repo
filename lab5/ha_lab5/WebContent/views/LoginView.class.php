<?php
class LoginView {
	
	public static function show() {
		$_SESSION['headertitle'] = "Log into Sensor Data Repo";
		$_SESSION['styles'] = array('site.css');
		
		MasterView::showHeader();
		MasterView::showNavBar();
		LoginView::showDetails();
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showDetails() {
		$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
		
		echo '<section>'."\n";
		echo '<h1>Log into Sensor Data Repo</h1>'."\n\n";
		echo '<form action="login" method="post">'."\n";
		
		// This is redundant
// 		echo '<span class="error">';
// 		if (!is_null($user)) { echo $user->getError('username'); }
// 		echo '</span>'."\n";
		
		echo '<p>'."\n";
		echo 'username<br>'."\n";
		echo '<input type="text" name="username" autofocus '."\n";
		if (!is_null($user)) {echo 'value = "'. $user->getUsername() .'"';}
		echo 'tabindex="1" required>'."\n";
		echo '<span class="error">'."\n";
		if (!is_null($user)) {echo $user->getError('username');}
		echo "\n".'</span>';
		
		echo '<br><br>'."\n\n";
		
		echo 'password<br>'."\n";
		echo '<input type="password" name="password" tabindex="2" required>'."\n";
		if (!is_null($user)) {echo $user->getError('password');}
		echo '</p>'."\n\n";
		
		echo '<input type="submit" value="Submit">'."\n";
		echo '</form>'."\n";
		echo '</section>'."\n";
	}
}
?>