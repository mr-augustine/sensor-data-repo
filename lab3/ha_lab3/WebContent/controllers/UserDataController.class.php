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
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : 0;
		$userData = $_SESSION['userData'];
		
		if (!is_null($userData)) {
			$_SESSION['userData'] = $userData;
			
			$skillAssocs = SkillAssocsDB::getSkillAssocsBy('userDataId', $userData->getUserDataId());
			$_SESSION['skillAssocs'] = $skillAssocs;
			
			UserDataView::show();
		} else {
			HomeView::show();
		}
	}
	
	public static function newUserData() {
		$userData = null;
		$newUserData = null;
		
		if ($_SERVER["REQUEST_METHOD"] == "POST")
			$userData = new UserData($_POST);
		
		$_SESSION['userData'] = $userData;
		
		if (is_null($userData) || $userData->getErrorCount() != 0)
			UserDataView::showNew();
		else {
			$newUserData = UserDataDB::addUserData($userData);
			
			if (!is_null($newUserData) && $newUserData->getErrorCount() == 0)
				$_SESSION['userData'] = $newUserData;
			
			HomeView::show();
			//header('Location: /'.$_SESSION['base']);
		}
	}
	
	public static function updateUserData() {
		
	}
}

?>