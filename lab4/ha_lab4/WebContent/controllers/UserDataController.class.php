<?php
class UserDataController {
	
	public static function run() {
		$action = (array_key_exists('action', $_SESSION)) ? $_SESSION['action'] : "";
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : "";
		
		switch ($action) {
			case "create":
				self::newUserData();
				break;
			// FIXME: $_SESSION['userData'] can refer to either a single object
			// or an array of objects. Give them separate keys
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
				//echo "Update";
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
			
			$skills = array();
			
			foreach ($skillAssocs as $skillAssoc) {
				$skillsArray = SkillsDB::getSkillsBy('skillId', $skillAssoc->getSkillId());
				$skill = $skillsArray[0];
				array_push($skills, $skill);
			}
			
			//$_SESSION['skillAssocs'] = $skillAssocs;
			$_SESSION['skills'] = $skills;
			
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
		$userDataArray = UserDataDB::getUserDataBy('userDataId', $_SESSION['arguments']);
		
		if (empty($userDataArray)) {
			HomeView::show();
			header('Location: /'.$_SESSION['base']);
		} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
			$_SESSION['userData'] = $userDataArray[0];
			UserDataView::showUpdate();
		} else {
			$userData = $userDataArray[0];
			$parms = $userData->getParameters();
			$parms['userId'] = (array_key_exists('userId', $_POST)) ?
				$_POST['userId'] : $userData->getUserId();
			$parms['user_name'] = (array_key_exists('user_name', $_POST)) ?
				$_POST['user_name'] : "";
			$parms['skill_level'] = (array_key_exists('skill_level', $_POST)) ?
				$_POST['skill_level'] : "";
			$parms['skill_areas'] = (array_key_exists('skill_areas', $_POST)) ?
				$_POST['skill_areas'] : array();
			$parms['profile_pic'] = (array_key_exists('profile_pic', $_POST)) ?
				$_POST['profile_pic'] : "";
			$parms['started_hobby'] = (array_key_exists('started_hobby', $_POST)) ?
				$_POST['started_hobby'] : "";
			$parms['fav_color'] = (array_key_exists('fav_color', $_POST)) ?
				$_POST['fav_color'] : "";
			$parms['url'] = (array_key_exists('url', $_POST)) ?
				$_POST['url'] : "";
			$parms['phone'] = (array_key_exists('phone', $_POST)) ?
				$_POST['phone'] : "";
			
			$newUserData = new UserData($parms);
			$newUserData->setUserDataId($userData->getUserDataId());
			$userDataEntry = UserDataDB::updateUserData($newUserData);
			
			if ($userDataEntry->getErrorCount() != 0) {
				$_SESSION['userData'] = array($newUserData);
				//return;
				UserDataView::showUpdate();
			} else {
				HomeView::show();
				header('Location: /'.$_SESSION['base']);
			}
		}
	}
}

?>