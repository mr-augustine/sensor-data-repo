<?php
class ProfileController {
	
	public static function run() {
		$action = (array_key_exists('action', $_SESSION)) ? $_SESSION['action'] : "";
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : "";
		
		switch ($action) {
			case "show":
				// For an individual user, show their profile page
				if (is_numeric($arguments)) {
					self::show();
				}
				break;
			case "update":
				
				break;
			default:
		}
	}
	
	private function show() {
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : 0;
		
		// Identify the target user
		$users = UsersDB::getUsersBy('user_id', $arguments);
		$user = $users[0];
		
		if (!is_null($user)) {
			// Prepare all data to be displayed in the target user's ProfileView
			// --all of their datasets
			// --all of the sensors for each dataset
			// TODO: add 'member since'
			$datasets = DatasetsDB::getDatasetsBy('user_id', $user->getUserId());
			
			foreach ($datasets as $dataset) {
				$sensors = SensorsDB::getSensorsBy('dataset_id', $dataset->getDatasetId());
				$dataset->setSensors($sensors);
			}
			
			$_SESSION['user'] = $user;
			$_SESSION['datasets'] = $datasets;
			
			ProfileView::show();
		} else {
			$_SESSION['user'] = null;
			// TODO:: Consider showing a 'Specified user does not exist' page
			HomeView::show();
		}
	}
}
?>