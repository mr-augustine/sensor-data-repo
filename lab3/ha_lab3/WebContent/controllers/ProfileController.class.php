<?php
class ProfileController {
		
	public static function run() {
// 		if ($_SERVER["REQUEST_METHOD"] == "POST") {
// 			$user = new User($_POST);  
// 			if ($user->getErrorCount() == 0) 
// 				HomeView::show();		
// 		    else  
// 				LoginView::show($user);
// 		} else  // Initial link
			$validUserData = array("user_name" => "Admiral_Ackbar",
					"skill_level" => "expert",
					"skill_areas" => array("system-design", "programming", "wiring"),
					"profile_pic" => "ackbar.jpg",
					"started_hobby" => "1983-05",
					"fav_color" => "#ff0000",
					"url" => "http://www.itsatrap.com",
					"phone" => "210-458-4436"
			);
			$sampleUser = new UserData($validUserData);
			ProfileView::show($sampleUser);
	}
}
?>