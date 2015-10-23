<?php
class SignupController {

	public static function run() {
		$user = null;
		$userData = null;
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			//simpleEcho.php;
			$formUser = new User($_POST);
			$user = UsersDB::addUser($formUser);
			
			if ($user->getErrorCount() == 0) {
				$_POST["userId"] = $user->getUserId();
				$formUserData = new UserData($_POST);
				$userData = UserDataDB::addUserData($formUserData);

				if ($userData->getErrorCount() == 0) {
					$_SESSION['user'] = $user;
					$_SESSION['userData'] = $userData;
				}
			}
		} 
		
		
		if (is_null($user) || is_null($userData) ||
				$user->getErrorCount() != 0 || $userData->getErrorCount() != 0) {
			SignupView::show($user, $userData);			
		} else {
			ProfileView::show();
		}
	}
}
?>