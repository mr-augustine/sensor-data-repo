<?php
class MeasurementView {
	
	public static function show() {
		$_SESSION['headertitle'] = 'Measurement Summary';
		$_SESSION['styles'] = array('site.css');
		
		MasterView::showHeader();
		MasterView::showNavBar();
		self::showDetails();
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showNew() {
		$measurement = (array_key_exists('measurement', $_SESSION)) ? $_SESSION['measurement'] : null;
		$sensor = (array_key_exists('sensor', $_SESSION)) ? $_SESSION['sensor'] : null;
		$dataset = (array_key_exists('dataset', $_SESSION)) ? $_SESSION['dataset'] : null;
		$user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		$_SESSION['headertitle'] = "Sensor Data Repo | Create a Measurement";
		$_SESSION['styles'] = array('site.css');
		MasterView::showHeader();
		MasterView::showNavBar();
		
		if (!isset($user) || !LoginController::UserIsLoggedIn($user->getUserId())) {
			echo '<br><br>';
			echo '<p>You must log in to create a new Measurement';
			return;
		}
		
		if (!isset($sensor)) {
			echo '<br><br>';
			echo '<p>You must select a Sensor before creating a Measurement</p>';
			return;
		}
		
		if (!isset($dataset)) {
			echo '<br><br>';
			echo '<p>You must select a Sensor from a Dataset before creating a Measurement</p>';
			return;
		}
		
		echo '<h1>Create a Measurement</h1>';
		echo '<section>';
		echo '<form action="/'.$base.'/measurement/create" method="POST">';
		
		if (isset($measurement) && array_key_exists('measurement_id', $measurement->getErrors()))
			echo 'Error: '.$measurement->getError('measurement_id')."<br>";
		
		echo 'Sensor ID:&nbsp'.$sensor->getSensorId().'<br><br>';
		echo '<input type="hidden" name="sensor_id" value="'.$sensor->getSensorId().'">';
		echo '<input type="hidden" name="sensorType" value="'.$sensor->getSensorType().'">';
		echo '<input type="hidden" name="sequenceType" value="'.$sensor->getSequenceType().'">';
		
		
		echo 'Measurement Index:&nbsp<input type="text" name="measurement_index" ';
		if (isset($measurement)) { echo 'value="'.$measurement->getMeasurementIndex().'" '; }
		echo 'tabindex="1" required>'."\n";
		echo '<span class="error">';
		if (isset($measurement)) { echo $measurement->getError('measurement_index'); }
		echo '</span><br><br>'."\n";
		
		echo 'Timestamp:&nbsp<input type="text" name="measurement_timestamp" ';
		if (isset($measurement)) { echo 'value="'.$measurement->getMeasurementTimestamp().'" '; }
		echo 'tabindex="2" ';
		if ($sensor->requiresTimestampedMeasurements()) { echo 'required'; }
		echo '>'."\n";
		echo '<span class="error">';
		if (isset($measurement) && $sensor->requiresTimestampedMeasurements()) { echo $measurement->getError('measurement_timestamp'); }
		echo '</span><br><br>'."\n";
		
		echo 'Value:&nbsp<input type="text" name="measurement_value" ';
		if (isset($measurement)) { echo 'value="'.$measurement->getMeasurementValue().'" '; }
		echo 'tabindex="3" required>'."\n";
		echo '<span class="error">';
		if (isset($measurement)) { echo $measurement->getError('measurement_value'); }
		echo '</span><br><br>'."\n";
		
		echo '<p><input type="submit" name="submit" value="Submit">';
		echo '&nbsp&nbsp';
		echo '<a href="/'.$base.'/sensor/show/'.$sensor->getSensorId().'">Cancel</a><br>';
		echo '</form>';
		echo '</section>';
	}
	
	public static function showUpdate() {
		
	}
	
	private function showDetails() {
		
	}
}
?>