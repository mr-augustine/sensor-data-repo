<?php
class ProfileController {
		
	public static function run() {
		$action = $_SESSION['action'];
		$arguments = $_SESSION['arguments'];
		
		switch ($action) {
			case "show":
				$user = null;
				$userData = null;
				
				$users = UsersDB::getUsersBy('userId', $arguments);
				
				if (count($users) > 0) {
					$user = $users[0];
					$userDataArray = UserDataDB::getUserDataBy('userId', $user->getUserId());
					
					if (count($userDataArray) > 0)
						$userData = $userDataArray[0];
				}

				$_SESSION['user'] = $user;
				$_SESSION['userData'] = $userData;
				
				ProfileView::show();
				
				break;
			case "update":
				break;
			default:
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
}
?>