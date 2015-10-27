<?php
class UserController {
	
	public static function run() {
		$action = (array_key_exists('action', $_SESSION)) ? $_SESSION['action'] : "";
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : "";
		
		switch ($action) {
			case "create":
				self::newUser();
				break;
			case "show":
				if ($arguments == 'all') {
					$_SESSION['users'] = UsersDB::getUsersBy();
					$_SESSION['headertitle'] = "botspace users";
					
					UserView::showAll();
				} else {
					$users = UsersDB::getUsersBy('userId', $arguments);
					$_SESSION['user'] = $users[0];
					self::show();
				}
				break;
			case "update":
				echo "Update";
				self::updateUser();
				break;
			default:
		}
	}
	
	public static function show() {
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : 0;
		$user = $_SESSION['user'];
		
		if (!is_null($user)) {
			$_SESSION['user'] = $user;
			
			$userDataArray = UserDataDB::getUserDataBy('userId', $user->getUserId());
			$userData = $userDataArray[0];
			$_SESSION['userData'] = $userData;
			
			$skillAssocs = SkillAssocsDB::getSkillAssocsBy('userDataId', $userData->getUserDataId());
			$_SESSION['skillAssocs'] = $skillAssocs;
			
			// The robot data section might look something like this:
			//$robotDataArray = RobotDataDB::getRobotDataBy('creator', $user->getUserId());
			//$_SESSION['robotData'] = $robotDataArray;
			
			UserView::show();
		} else {
			HomeView::show();
		}
	}
	
	public static function newUser() {
		$user = null;
		
		if ($_SERVER["REQUEST_METHOD"] == "POST")
			$user = new User($_POST);
		
		$_SESSION['user'] = $user;
		
		if (is_null($user) || $user->getErrorCount() != 0) {
			//$_SESSION['user'] = $user;
			UserView::showNew();
		} else {
			$newUser = UsersDB::addUser($user);
			
			if ($newUser->getErrorCount() == 0)
				$_SESSION['user'] = $newUser;
			
			HomeView::show();
			//header('Location: /'.$_SESSION['base']);
		}
	}
	
	public static function updateUser() {
		
	}
}

?>