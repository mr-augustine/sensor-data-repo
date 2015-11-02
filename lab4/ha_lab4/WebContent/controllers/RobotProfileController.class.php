<?php
class RobotProfileController {
		
	public static function run() {
// 		if ($_SERVER["REQUEST_METHOD"] == "POST") {
// 			$user = new User($_POST);  
// 			if ($user->getErrorCount() == 0) 
// 				HomeView::show();		
// 		    else  
// 				LoginView::show($user);
// 		} else  // Initial link
			$validRobotData = array("robot_name" => "MSE-6",
					"creator" => "Admiral_Ackbar",
					"status" => "in-development"
			);
			$sampleRobot = new RobotData($validRobotData);
			RobotProfileView::show($sampleRobot);
	}
}
?>