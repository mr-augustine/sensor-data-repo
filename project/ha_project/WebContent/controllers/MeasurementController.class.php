<?php
class MeasurementController {
	
	public static function run() {
		$action = (array_key_exists('action', $_SESSION)) ? $_SESSION['action'] : "";
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : "";
		
		switch ($action) {
			case "create":
				self::newMeasurement();
				break;
			default:
				HomeView::show();
		}
	}
	
	private function show() {
		
	}
	
	private function newMeasurement() {
		$measurement = null;
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
			$measurement = new Measurement($_POST);
		
		$_SESSION['measurement'] = $measurement;
		
		if (is_null($measurement) || $measurement->getErrorCount() != 0) {
			MeasurementView::showNew();
		} else {
			$newMeasurement = MeasurementsDB::addMeasurement($measurement);
			
			if ($newMeasurement->getErrorCount() == 0)
				$_SESSION['measurement'] = $newMeasurement;
			
			SensorView::show();
			header('Location: /'.$_SESSION['base'].'/sensor/show/'.$_SESSION['sensor']->getSensorId());
		}
		
	}
	
	private function updateMeasurement() {
		
	}
	
	private function UserCanEditTargetMeasurement($targetMeasurementUserId) {
		return LoginController::UserIsLoggedIn($targetMeasurementUserId);
	}
}
?>