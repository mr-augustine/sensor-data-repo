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
		MeasurementView::showNew();
	}
	
	private function updateMeasurement() {
		
	}
	
	private function UserCanEditTargetMeasurement($targetMeasurementUserId) {
		return LoginController::UserIsLoggedIn($targetMeasurementUserId);
	}
}
?>