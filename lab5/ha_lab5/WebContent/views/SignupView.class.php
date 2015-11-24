<?php
class SignupView {
	
	public static function show($user) {
		$_SESSION['headertitle'] = "Sign up for a Sensor Data Repo account";
		$_SESSION['styles'] = array('site.css', 'signup.css');
		
		MasterView::showHeader();
		MasterView::showNavBar();
		SignupView::showDetails($user);
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showDetails($user) {
		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
		
		echo '<section>'."\n";
		echo '<h1>Create an account</h1>'."\n";
		echo '<form action="signup" method="post">'."\n";
		echo 'Username: <input type="text" name="username"';
			if (!is_null($user)) { echo 'value="'.$user->getUsername().'"'; }
		echo 'tabindex="1" required>'."\n";
		echo '<span class="error">'."\n";
			if (!is_null($user)) { echo $user->getError('username'); }
		echo '</span><br><br>'."\n";
		
		echo 'Password: <input type="password" name="password" tabindex="2" required>'."\n";
		echo '<span class="error">'."\n";
			if (!is_null($user)) { echo $user->getError('password'); }
		echo '<span><br><br>'."\n";
		
		echo '<input type="submit" value="Submit">'."\n";
		echo '</form>'."\n";
		echo '</section>'."\n";
	}
}
?>