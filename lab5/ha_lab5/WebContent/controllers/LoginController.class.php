<?php
class LoginController {
	
	public static function run() {
		$user = null;
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$user = new User($_POST);
			$users = UsersDB::getUsersBy('username', $user->getUsername());
			
			if (empty($users))
				$user->setError('username', 'USERNAME_PASSWORD_COMBO_INVALID');
			else
				$user = $users[0];
		}
		
		$_SESSION['user'] = $user;
		
		if (is_null($user) || $user->getErrorCount() !=0 )
			LoginView::show();
		else {
			$_SESSION['authenticatedUser'] = $user;
			$_SESSION['authenticated'] = true;
			HomeView::show();
		}
	}
}
?>