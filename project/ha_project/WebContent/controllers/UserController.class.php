<?php
class UserController {
	
	public static function run() {
		$action = (array_key_exists('action', $_SESSION)) ? $_SESSION['action'] : "";
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : "";
		
		switch ($action) {
			case "show":
				ProfileController::run();
				break;
			case "update":
				// For an individual user, show their account edit page
				if (is_numeric($arguments)) {
					$targetUserId = $arguments;
					// Only allow updating if the user is logged in and the
					// loggedin user is the target user
					if (self::UserCanEditTargetAccount($targetUserId))
						self::updateUser($targetUserId);
					else
						HomeView::show();
				}
				break;
			default:
		}
	}
	
	// Currently not used; For now, we redirect to the ProfileController
	private function show() {
		
	}
	
	private function updateUser($userId) {
		$users = UsersDB::getUsersBy('user_id',$userId);
		
		if (empty($users)) {
			HomeView::show();
			header('Location: /'.$_SESSION['base']);
		} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$_SESSION['user'] = $users[0];
			UserView::showUpdate();
		} else {
			$params = $users[0]->getParameters();
			$params['username'] = (array_key_exists('username', $_POST)) ? $_POST['username'] : "";
			$params['password'] = (array_key_exists('password', $_POST)) ? $_POST['password'] : "";
			
			$updatedUser = new User($params);
			$updatedUser->setUserId($users[0]->getUserId());
			$plaintextPassword = $updatedUser->getPassword();
			$hashedPassword = password_hash($plaintextPassword, PASSWORD_DEFAULT);
			$updatedUser->setPassword($hashedPassword);
			$returnedUser = UsersDB::updateUser($updatedUser);
			
			if ($returnedUser->getErrorCount() == 0) {
				// TODO: Log out the current user before diplaying the HomeView; LogoutController::LogoutCurrentUser()
				HomeView::show();
				header('Location: /'.$_SESSION['base']);
			} else {
				$_SESSION['user'] = $updatedUser;
				UserView::showUpdate();
			}
		}
	}
	
	private function UserCanEditTargetAccount($targetUserId) {
		return LoginController::UserIsLoggedIn($targetUserId);
	}
}
?>