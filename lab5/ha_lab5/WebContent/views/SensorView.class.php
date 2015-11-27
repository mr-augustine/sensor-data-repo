<?php
class SensorView {
	
	public static function show() {
		$_SESSION['headertitle'] = 'Dataset Summary';
		$_SESSION['styles'] = array('site.css');
		
		MasterView::showHeader();
		MasterView::showNavBar();
		self::showDetails();
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showAll() {
		
	}
	
	public static function showNew() {
		$sensor = (array_key_exists('sensor', $_SESSION)) ? $_SESSION['sensor'] : null;
		$dataset = (array_key_exists('dataset', $_SESSION)) ? $_SESSION['dataset'] : null;
		$user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		$_SESSION['headertitle'] = "Sensor Data Repo | Create a Sensor";
		$_SESSION['styles'] = array('site.css');
		MasterView::showHeader();
		MasterView::showNavBar();
		
		if (!isset($user) || !LoginController::UserIsLoggedIn($user->getUserId())) {
			echo '<br><br>';
			echo '<p>You must log in to create a new Sensor</p>';
			return;
		}

		if (!isset($dataset)) {
			echo '<br><br>';
			echo '<p>You must select a dataset before creating a Sensor</p>';
			return;
		}
		
		echo '<h1>Create a Sensor</h1>';
		echo '<section>';
		echo '<form action="/'.$base.'/sensor/create" method="POST">';
		
		if (isset($sensor) && array_key_exists('sensor_id', $sensor->getErrors()))
			echo 'Error: '.$sensor->getError('sensor_id')."<br>";

		
		echo 'Sensor Name:&nbsp<input type="text" name="sensor_name" ';
		if (isset($sensor)) { echo 'value="'.$sensor->getSensorName().'"'; }
		echo 'tabindex="1" required>'."\n";
		echo '<span class="error">';
		if (isset($sensor)) { echo $sensor->getError('sensor_name'); }
		echo '</span><br><br>'."\n";
		
		echo 'Sensor Type:&nbsp';
		echo '<span class="error">';
		if (isset($sensor)) { echo $sensor->getError('sensor_type'); }
		echo '</span><br><br>'."\n";
		echo '<select class="form-control" name="sensor_type" tabindex="2">'."\n";
		foreach (Sensor::$VALID_SENSOR_TYPES as $sensorType) {
			echo '<option value="'.$sensorType.'"';
			if (isset($sensor) && $sensor->getSensorType() == $sensorType) { echo ' selected'; }
			echo '>'.$sensorType.'</option>'."\n";
		}
		echo '</select><br><br>'."\n";
		
		echo 'Sensor Units:&nbsp';
		echo '<span class="error">';
		if (isset($sensor)) { echo $sensor->getError('sensor_units'); }
		echo '</span><br><br>'."\n";
		echo '<select class="form-control" name="sensor_units" tabindex="3">'."\n";
		foreach (Sensor::$VALID_SENSOR_UNITS as $sensorUnits) {
			echo '<option value="'.$sensorUnits.'"';
			if (isset($sensor) && $sensor->getSensorUnits() == $sensorUnits) { echo ' selected'; }
			echo '>'.$sensorUnits.'</option>'."\n";
		}
		echo '</select><br><br>'."\n";
		
		echo 'Sequence Type:&nbsp';
		echo '<span class="error">';
		if (isset($sensor)) { echo $sensor->getError('sequence_type'); }
		echo '</span><br><br>'."\n";
		$nextTabIndex = 4;
		foreach (Sensor::$VALID_SENSOR_SEQUENCE_TYPES as $sequenceType) {
			echo '<input type="radio" name="sequence_type" value="'.$sequenceType.
			'" tabindex="'.$nextTabIndex++.'">'.$sequenceType."&nbsp&nbsp";
		}
		echo '<br><br>'."\n";
	
		echo 'Description:';
		echo '<span class="error">';
		if (isset($sensor)) { echo $sensor->getError('description'); }
		echo '<span><br><br>'."\n";
		echo '<textarea class="form-control" name="description" tabindex="'.
			$nextTabIndex++.'" rows="2">';
		if (isset($sensor)) { echo $sensor->getDescription(); }
		echo '</textarea>';
		echo '<br><br>';
		
		echo '<input type="hidden" name="dataset_id" value="'.$dataset->getDatasetId().'">';
		echo '<p><input type="submit" name="submit" value="Submit">';
		echo '&nbsp&nbsp';
		echo '<a href="/'.$base.'/dataset/show/'.$dataset->getDatasetId().'">Cancel</a><br>';
		echo '</form>';
		echo '</section>';
	}
	
	public static function showUpdate() {
		
	}
	
	private function showDetails() {
		
	}
	
	private function CurrentUserCanEditTargetSensor($targetSensorUserId) {
		return LoginController::UserIsLoggedIn($targetSensorUserId);
	}
}
?>