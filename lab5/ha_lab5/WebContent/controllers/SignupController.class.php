<?php
class SignupController {
	
	public static function run() {
		$user = null;
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$formUser = new User($_POST);
			$user = UsersDB::addUser($formUser);
			
			if ($user->getErrorCount() == 0) {
				$_POST['user'] = $user;
			}
		}
		
		if (is_null($user) || $user->getErrorCount() != 0)
			SignupView::show($user);
		else
			ProfileView::show();
	}
}
?>