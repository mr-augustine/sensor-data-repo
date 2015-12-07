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
				$sensors = SensorsDB::getSensorsBy('sensor_id', $arguments);
				$_SESSION['sensor'] = $sensors[0];
				self::updateSensor();
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
		$sensor = $_SESSION['sensor'];
		
		if (empty($sensor)) {
			HomeView::show();
			header('Location: /'.$_SESSION['base']);
		} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
			SensorView::showUpdate();
		} else {
			$params = $sensor->getParameters();
			$params['sensor_name'] = (array_key_exists('sensor_name', $_POST)) ? $_POST['sensor_name'] : '';
			$params['description'] = (array_key_exists('description', $_POST)) ? $_POST['description'] : '';
			
			$updatedSensor = new Sensor($params);
			$updatedSensor->setSensorId($sensor->getSensorId());
			$returnedSensor = SensorsDB::updateSensor($updatedSensor);
			
			if ($returnedSensor->getErrorCount() == 0) {
				// Show the Sensor View which should display the updated params
				SensorView::show();
				header('Location: /'.$_SESSION['base'].'/sensor/show/'.$sensor->getSensorId());
			} else {
				// Carry over the measurements, if any
				$updatedSensor->setMeasurements($sensor->getMeasurements());
				
				$_SESSION['sensor'] = $updatedSensor;
				SensorView::showUpdate();
			}
		}
	}
	
	private function UserCanEditTargetSensor($targetSensorUserId) {
		return LoginController::UserIsLoggedIn($targetSensorUserId);
	}
}
?>