<?php
class UserView {
	
	public static function show() {
		// Not implemented yet; currently handled by ProfileView
	}
	
	private function showDetails() {
		// Not implemented yet; currently handled by ProfileView
	}
	
	public static function showUpdate() {
		$user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : '';
		$_SESSION['headertitle'] = 'Sensor Data Repo | Account Update';
		$_SESSION['stytles'] = array('site.cs');
		MasterView::showHeader();
		MasterView::showNavBar();
		
		echo '<h1>Account Update</h1>';
		
		if (!isset($user)) {
			echo '<section>User does not exist</section>';
			return;
		}
		
		if (count($user->getErrors()) > 0) {
			$errors = $user->getErrors();
			echo '<section><p>Errors:<br>';
			
			foreach ($errors as $key => $value)
				echo $value.'<br>';
			
			echo '</p></section>';
		}
		
		echo '<section><form method="POST" action="/'.$base.'/user/update/'.$user->getUserId().'">';
		echo '<p>New Username: <input type="text" name="username"';
		if (!is_null($user))
			echo 'value="'.$user->getUsername().'"';
		echo '><span class="error">';
		if (!is_null($user))
			echo $user->getError('username');
		echo '</span></p>';
		
		echo '<p>New Password: <input type="password" name="password"><span class="error">';
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