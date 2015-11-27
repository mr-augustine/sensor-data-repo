<?php
class DatasetController {
	
	public static function run() {
		$action = (array_key_exists('action', $_SESSION)) ? $_SESSION['action'] : "";
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : "";
		
		switch ($action) {
			case "create":
				self::newDataset();
				break;
			case "show":
				if ($arguments == 'all') {
					$_SESSION['datasets'] = DatasetsDB::getDatasetsBy();
					$_SESSION['headertitle'] = 'Sensor Data Repo | Datasets';
					
					DatasetView::showAll();
				} else {
					$datasets = DatasetsDB::getDatasetsBy('dataset_id', $arguments);
					
					if (count($datasets) > 0) {
						$dataset = $datasets[0];
						$_SESSION['dataset'] = $dataset;
					
						$users = UsersDB::getUsersBy('user_id', $dataset->getUserId());
						
						if (count($users) > 0) {
							$_SESSION['user'] = $users[0];
							self::show();
						} else
							HomeView::show();
					} else
						HomeView::show();
				}
				break;
			case "update":
				$datasets = DatasetsDB::getDatasetsBy('dataset_id', $arguments);
				$_SESSION['dataset'] = $datasets[0];
				self::updateDataset();
				break;
			default:
		}
	}
	
	private function show() {
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : 0;
		$dataset = $_SESSION['dataset'];
		
		if (!is_null($dataset)) {
			// Populate the Dataset with its sensors
			$sensors = SensorsDB::getSensorsBy('dataset_id', $dataset->getDatasetId());
			$dataset->setSensors($sensors);
			
			// Update the session dataset
			$_SESSION['dataset'] = $dataset;
			DatasetView::show();
		} else {
			HomeView::show();
			header('Location: /'.$_SESSION['base']);
		}
	}
	
	private function newDataset() {
		$dataset = null;
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
			$dataset = new Dataset($_POST);
		
		$_SESSION['dataset'] = $dataset;
		
		if (is_null($dataset) || $dataset->getErrorCount() != 0) {
			DatasetView::showNew();
		} else {
			$newDataset = DatasetsDB::addDataset($dataset);
			
			if ($newDataset->getErrorCount() == 0)
				$_SESSION['dataset'] = $newDataset;
			
			ProfileView::show();
			header('Location: /'.$_SESSION['base'].'/profile/show/'.$newDataset->getUserId());
		}
	}
	
	private function updateDataset() {
		$dataset = $_SESSION['dataset'];
		
		if (empty($dataset)) {
			HomeView::show();
			header('Location: /'.$_SESSION['base']);
		} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
			DatasetView::showUpdate();
		} else {
			$params = $dataset->getParameters();
			$params['dataset_name'] = (array_key_exists('dataset_name', $_POST)) ? $_POST['dataset_name'] : '';
			$params['description'] = (array_key_exists('description', $_POST)) ? $_POST['description'] : '';
			
			$updatedDataset = new Dataset($params);
			$updatedDataset->setDatasetId($dataset->getDatasetId());
			$returnedDataset = DatasetsDB::updateDataset($updatedDataset);
			
			if ($returnedDataset->getErrorCount() == 0) {
				// Show the Dataset view which should display the updated params
				DatasetView::show();
				header('Location: /'.$_SESSION['base'].'/dataset/show/'.$dataset->getDatasetId());
			} else {
				// Carry over the sensors, if any
				$updatedDataset->setSensors($dataset->getSensors());
				
				$_SESSION['dataset'] = $updatedDataset;
				DatasetView::showUpdate();
			}
		}
	}
	
	private function UserCanEditTargetDataset($targetDatasetUserId) {
		return LoginController::UserIsLoggedIn($targetDatasetUserId);
	}
}
?>