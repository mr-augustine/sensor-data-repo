<?php
class LoginController {

	public static function run() {
		$user = null;
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$user = new User($_POST);
			$users = UsersDB::getUsersBy('email', $user->getEmail());
			
			if (empty($users)) 
				$user->setError('userName', 'EMAIL_PASSWORD_COMBO_INVALID');		
		    else  
				$user = $users[0];
		}
		
		$_SESSION['user'] = $user;
		
		if (is_null($user) || $user->getErrorCount() != 0)
			LoginView::show();
		else {
			HomeView::show();
			//header('Location: /'.$_SESSION['base']);
		}
	}
}
?>