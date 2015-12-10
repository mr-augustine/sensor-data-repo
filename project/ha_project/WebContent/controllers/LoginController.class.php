<?php
class LoginController {
	
	public static function run() {
		$user = null;
		$userIsLegit = false;
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$user = new User($_POST);
			
			if ($user->getErrorCount() == 0) {
				$checkUserArray = UsersDB::getUsersBy('username', $user->getUserName());
				
				if (count($checkUserArray) > 0) {
					$checkUser = $checkUserArray[0];
					$user->setUserId($checkUser->getUserId());
				
					$userIsLegit = password_verify($_POST['password'], $checkUser->getPassword());
				}
			}
		} else {
			LoginView::show();
			return;
		}
		
		if ($userIsLegit) {
			$_SESSION['authenticatedUser'] = $user;
			$_SESSION['authenticated'] = true;
			HomeView::show();
		} else {
			$user->setError('username', 'USERNAME_PASSWORD_COMBO_INVALID');
			$_SESSION['user'] = $user;
			LoginView::show();
		}
	}
	
	public static function UserIsLoggedIn($userId) {
		return ($_SESSION['authenticated'] == true &&
				$_SESSION['authenticatedUser']->getUserId() == $userId);
	}
}
?>