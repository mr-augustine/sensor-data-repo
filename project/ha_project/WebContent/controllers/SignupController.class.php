<?php
class SignupController {
	
	public static function run() {
		$user = null;
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$formUser = new User($_POST);
			
			if ($formUser->getErrorCount() == 0) {
				$plaintextPassword = $formUser->getPassword();
				$hashedPassword = password_hash($plaintextPassword, PASSWORD_DEFAULT);
				$formUser->setPassword($hashedPassword);
				
				$user = UsersDB::addUser($formUser);
				
				if ($user->getErrorCount() == 0) {
					$_SESSION['user'] = $user;
				}
			} else {
				$user = $formUser;
			}
		}
		
		if (is_null($user) || $user->getErrorCount() != 0)
			SignupView::show($user);
		else
			ProfileView::show();
	}
}
?>