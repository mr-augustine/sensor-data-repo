<?php
class ProfileController {
	
	public static function run() {
		$action = $_SESSION['action'];
		$arguments = $_SESSION['arguments'];
		
		switch ($action) {
			case "show":
				// Prepare all data that will be displayed in the ProfileView
				// --datasets associated with the user
				// --number of sensors associated
				// --total number of measurements per sensor
				// --?member since
				break;
			case "update":
				
				break;
			default:
		}
	}
}
?>