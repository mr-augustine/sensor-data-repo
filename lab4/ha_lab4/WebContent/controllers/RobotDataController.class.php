<?php
class RobotDataController {

	public static function run() {
		$action = (array_key_exists('action', $_SESSION)) ? $_SESSION['action'] : "";
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : "";
		
		switch ($action) {
			case "create":
				self::newRobotData();
				break;
			case "show":
				if ($arguments == 'all') {
					$allRobotData = RobotDataDB::getRobotDataBy();
					$allCreators = array();
					
					// Retrieve the creators for each robot
					foreach ($allRobotData as $robotData) {
						$robotsCreatorsUserData = array();
						
						foreach ($robotData->getCreators() as $userDataId) {
							$creatorsArray = UserDataDB::getUserDataBy('userDataId', $userDataId);
							$creator = $creatorsArray[0];
							
							array_push($robotsCreatorsUserData, $creator);
						}
						
						array_push($allCreators, $robotsCreatorsUserData);
					}
					
					$_SESSION['robotData'] = $allRobotData;
					$_SESSION['creators'] = $allCreators;
					$_SESSION['headertitle'] = "botspace robot data";

					RobotDataView::showAll();
				} else {
					$robotDataArray = RobotDataDB::getRobotDataBy('robotId', $arguments);
					$robotData = $robotDataArray[0];
					$creators = array();
					
					foreach ($robotData->getCreators() as $userDataId) {
						$creatorsArray = UserDataDB::getUserDataBy('userDataId', $userDataId);
						$creator = $creatorsArray[0];
						
						array_push($creators, $creator);
					}
					
					$_SESSION['robotData'] = $robotData;
					$_SESSION['creators'] = $creators;
					
					self::show();
				}
				break;
			case "update":
				echo "Update";
				self::updateRobotData();
				break;
			default:
		}
	}
	
	public static function show() {
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : 0;
		$robotData = $_SESSION['robotData'];
		
		// Create an array of UserData objects based on the array of creatorIds
		if (!is_null($robotData)) {
			$creators = array();
			
			foreach ($robotData->getCreators() as $creatorId) {
				$userDataArray = UserDataDB::getUserDataBy('userDataId', $creatorId);
				$userData = $userDataArray[0];
				array_push($creators, $userData);
			}

			$_SESSION['creators'] = $creators;
			
			RobotDataView::show();
		} else {
			HomeView::show();
		}
	}
	
	public static function newRobotData() {
		$robotData = null;
		$newRobotData = null;
		
		if ($_SERVER["REQUEST_METHOD"] == "POST")
			$robotData = new RobotData($_POST);
		
		$_SESSION['robotData'] = $robotData;
		
		if (is_null($robotData) || $robotData->getErrorCount() != 0)
			RobotDataView::showNew();
		else {
			$newRobotData = RobotDataDB::addRobotData($robotData);
			
			if (!is_null($newRobotData) && $newRobotData->getErrorCount() == 0)
				$_SESSION['robotData'] = $newRobotData;
			
			HomeView::show();
		}
	}
	
	public static function updateRobotData() {
		$robotDataArray = RobotDataDB::getRobotDataBy('robotId', $_SESSION['arguments']);
		
		if (empty($robotDataArray)) {
			HomeView::show();
			header('Location: /'.$_SESSION['base']);
		} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
			$_SESSION['robotData'] = $robotDataArray[0];
			RobotDataView::showUpdate();
		} else {
			$robotData = $robotDataArray[0];
			$parms = $robotData->getParameters();
			
			$parms['robot_name'] = (array_key_exists('robot_name', $_POST)) ?
				$_POST['robot_name'] : "";
			$parms['status'] = (array_key_exists('status', $_POST)) ?
				$_POST['status'] : "";
			$parms['creators'] = (array_key_exists('creators', $_POST)) ?
				$_POST['creators'] : array();

			$revisedRobotData = new RobotData($parms);
			$revisedRobotData->setRobotId($robotData->getRobotId());
			$robotDataEntry = RobotDataDB::updateRobotData($revisedRobotData);
			
			if ($robotDataEntry->getErrorCount() != 0) {
				$_SESSION['robotData'] = array($revisedRobotData);
				RobotDataView::showUpdate();
			} else {
				HomeView::show();
				header('Location: /'.$_SESSION['base']);
			}
		}
	}
}
?>