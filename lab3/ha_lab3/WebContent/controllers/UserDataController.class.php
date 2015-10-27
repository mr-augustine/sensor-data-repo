<?php
class UserDataController {
	
	public static function run() {
		$action = (array_key_exists('action', $_SESSION)) ? $_SESSION['action'] : "";
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : "";
		
		switch ($action) {
			case "create":
				self::newUserData();
				break;
			case "show":
				if ($arguments == 'all') {
					$_SESSION['userData'] = UserDataDB::getUserDataBy();
					$_SESSION['headertitle'] = "botspace user data";
					
					UserDataView::showAll();
				} else {
					$userData = UserDataDB::getUserDataBy('userDataId', $arguments);
					$_SESSION['userData'] = $userData[0];
					self::show();
				}
				break;
			case "update":
				echo "Update";
				self::updateUserData();
				break;
			default:
		}
	}
	
	public static function show() {
		
	}
	
	public static function newUserData() {
		
	}
	
	public static function updateUserData() {
		
	}
}

?>