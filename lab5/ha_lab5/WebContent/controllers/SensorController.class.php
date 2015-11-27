<?php
class SensorController {
	
	public static function run() {
		$action = (array_key_exists('action', $_SESSION)) ? $_SESSION['action'] : "";
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : "";
		
		switch ($action) {
			case "create":
				self::newSensor();
				break;
			case "show":
				if ($arguments == 'all') {
					$_SESSION['sensors'] = SensorsDB::getSensorsBy();
					$_SESSION['headertitle'] = 'Sensor Data Repo | Sensors';
					
					SensorView::showAll();
				} else {
					$sensors = SensorsDB::getSensorsBy('sensor_id', $arguments);
					
					if (count($sensors) > 0) {
						$sensor = $sensors[0];
						$_SESSION['sensor'] = $sensor;
						
						$datasets = DatasetsDB::getDatasetsBy('dataset_id', $sensor->getDatasetId());
						
						if (count($datasets) > 0) {
							$_SESSION['dataset'] = $datasets[0];
							self::show();
						} else 
							HomeView::show();
					}
					else
						HomeView::show();
				}
				break;
			case "update":
				break;
			default:
		}
	}
	
	private function show() {
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : 0;
		$sensor = $_SESSION['sensor'];
		$dataset = $_SESSION['dataset'];
		
		if (!is_null($sensor)) {
			// Populate the Sensor with its measurements
			$measurements = MeasurementsDB::getMeasurementsBy('sensor_id', $sensor->getSensorId());
			$sensor->setMeasurements($measurements);
			
			// Update the session sensor
			$_SESSION['sensor'] = $sensor;
			SensorView::show();
		} else {
			HomeView::show();
			header('Location: /'.$_SESSION['base']);
		}
	}
	
	private function newSensor() {
		$sensor = null;
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
			$sensor = new Sensor($_POST);
		
		$_SESSION['sensor'] = $sensor;
		
		if (is_null($sensor) || $sensor->getErrorCount() != 0) {
			SensorView::showNew();
		} else {
			$newSensor = SensorsDB::addSensor($sensor);
			
			if ($newSensor->getErrorCount() == 0)
				$_SESSION['sensor'] = $newSensor;
			
			DatasetView::show();
			header('Location: /'.$_SESSION['base'].'/dataset/show/'.$newSensor->getDatasetId());
		}
	}
	
	private function updateSensor() {
		
	}
	
	private function UserCanEditTargetSensor($targetSensorUserId) {
		return LoginController::UserIsLoggedIn($targetSensorUserId);
	}
}
?>