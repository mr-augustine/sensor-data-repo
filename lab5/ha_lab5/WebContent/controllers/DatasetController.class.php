<?php
class DatasetController {
	
	public static function run() {
		$action = (array_key_exists('action', $_SESSION)) ? $_SESSION['action'] : "";
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : "";
		
		switch ($action) {
			case "create":
				break;
			case "show":
				if ($arguments == 'all') {
					$_SESSION['datasets'] = DatasetsDB::getDatasetsBy();
					$_SESSION['headertitle'] = 'Sensor Data Repo | Datasets';
					
					DatasetView::showAll();
				} else {
					$datasets = DatasetsDB::getDatasetsBy('dataset_id', $arguments);
					$_SESSION['dataset'] = $datasets[0];
					self::show();
				}
				break;
			case "update":
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
	
	private static function newDataset() {
		
	}
	
	private function updateDataset() {
		
	}
	
	private function UserCanEditTargetDataset($targetDatasetUserId) {
		return LoginController::UserIsLoggedIn($targetDatasetUserId);
	}
}
?>