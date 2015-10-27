<?php
class UserController {
	
	public static function run() {
		$action = (array_key_exists('action', $_SESSION)) ? $_SESSION['action'] : "";
		$arguments = $_SESSION['arguments'];
		
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
					$_SESSION['user'] = UsersDB::getUsersBy('userId', $arguments);
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
		
	}
	
	public static function newUser() {
		
	}
	
	public static function updateUser() {
		
	}
}

?>