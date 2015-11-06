<?php
class ProfileController {
		
	public static function run() {
		$action = $_SESSION['action'];
		$arguments = $_SESSION['arguments'];
		
		switch ($action) {
			case "show":
				$users = UsersDB::getUsersBy('userId', $arguments);
				
				if (count($users) > 0) {
					$user = $users[0];
					
					self::setProfileDataForUser($user->getUserId());
					ProfileView::show();
				}

// 				$user = null;
// 				$userData = null;
				
// 				$users = UsersDB::getUsersBy('userId', $arguments);
				
// 				if (count($users) > 0) {
// 					$user = $users[0];
// 					$userDataArray = UserDataDB::getUserDataBy('userId', $user->getUserId());
					
// 					if (count($userDataArray) > 0)
// 						$userData = $userDataArray[0];
// 				}

// 				$_SESSION['user'] = $user;
// 				$_SESSION['userData'] = $userData;
				
// 				ProfileView::show();
				
				break;
			case "update":
				break;
			default:
		}
	}
	
	// Sets the 'user', 'userData', 'skillAssocs', and 'userRobots' keys in the
	// $_SESSION super global; returns true if all are set and valid, false otherwise
	public static function setProfileDataForUser($userId) {
		$retVal = false;
		
		if (empty($userId) || !is_numeric($userId))
			return $retVal;
		
		$user = null;
		$userData = null;
		$skillAssocs = null;
		$userRobots = null;
		
		$users = UsersDB::getUsersBy('userId', $userId);
		
		if (count($users) > 0) {
			$user = $users[0];
			
			if ($user->getErrorCount() != 0)
				return $retVal;
			
			$userDataArray = UserDataDB::getUserDataBy('userId', $userId);
			
			if (count($userDataArray) > 0)
				$userData = $userDataArray[0];
			
			if ($userData->getErrorCount() != 0)
				return $retVal;
			
			$skillAssocs = SkillAssocsDB::getSkillAssocsBy('userDataId', $userData->getUserDataId());
			
			foreach ($skillAssocs as $skillAssoc) {
				if ($skillAssoc->getErrorCount() != 0)
					return $retVal;
			}
			
			// TODO: Fetch the user's robots from the Robots table
			$userRobots = array();
			
			$_SESSION['user'] = $user;
			$_SESSION['userData'] = $userData;
			$_SESSION['skillAssocs'] = $skillAssocs;
			$_SESSION['userRobots'] = $userRobots;
			
			$retVal = true;
		}
		
		return $retVal;
	}
// 		if ($_SERVER["REQUEST_METHOD"] == "POST") {
// 			$user = new User($_POST);  
// 			if ($user->getErrorCount() == 0) 
// 				HomeView::show();		
// 		    else  
// 				LoginView::show($user);
// 		} else {
			
// 			$userDataArray = UserDataDB::getUserDataBy('userId', $userId);
		
// 			$validUserData = array("user_name" => "Admiral_Ackbar",
// 					"skill_level" => "expert",
// 					"skill_areas" => array("system-design", "programming", "wiring"),
// 					"profile_pic" => "ackbar.jpg",
// 					"started_hobby" => "1983-05",
// 					"fav_color" => "#ff0000",
// 					"url" => "http://www.itsatrap.com",
// 					"phone" => "210-458-4436"
// 			);
// 			$sampleUser = new UserData($validUserData);
// 			ProfileView::show($sampleUser);
// 		}

}
?>