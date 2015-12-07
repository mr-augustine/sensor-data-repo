<?php
class SensorView {
	
	public static function show() {
		$_SESSION['headertitle'] = 'Sensor Summary';
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
		
		echo '<script src="/'.$base.'/js/UpdateSensorUnits.js"></script>';
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
		echo '<select onchange="updateSensorUnits()" id="sensorType" class="form-control" name="sensor_type" tabindex="2">'."\n";
		$sensorTypes = Sensor::$VALID_SENSOR_TYPES;
		sort($sensorTypes);
		foreach ($sensorTypes as $sensorType) {
			echo '<option value="'.$sensorType.'"';
			if (isset($sensor) && $sensor->getSensorType() == $sensorType) { echo ' selected'; }
			echo '>'.$sensorType.'</option>'."\n";
		}
		echo '</select><br><br>'."\n";
		
		echo 'Sensor Units:&nbsp';
		echo '<span class="error">';
		if (isset($sensor)) { echo $sensor->getError('sensor_units'); }
		echo '</span><br><br>'."\n";
		echo '<select id="sensorUnits" class="form-control" name="sensor_units" tabindex="3">'."\n";
		// This section is handled by UpdateSensorUnits.js
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
		$sensor = (array_key_exists('sensor', $_SESSION)) ? $_SESSION['sensor'] : null;
		$dataset = (array_key_exists('dataset', $_SESSION)) ? $_SESSION['dataset'] : null;
		$user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		$_SESSION['headertitle'] = 'Sensor Data Repo | Sensor Edit';
		$_SESSION['styles'] = array('site.css');
		MasterView::showHeader();
		MasterView::showNavBar();
		
		if (!is_null($sensor)) {
			echo '<h1>Sensor Edit</h1>';
			
			echo '<section>';
			echo '<form method="POST" action="/'.$base.'/sensor/update/'.$sensor->getSensorId().'">';
			
			echo '<fieldset><legend>Summary Info</legend>';
			echo 'Dataset Name:&nbsp<a href="/'.$base.'/dataset/show/'.$dataset->getDatasetId().
				'">'.$dataset->getDatasetName().'</a><br><br>'."\n";
			echo 'Sensor Name:&nbsp<input type="text" name="sensor_name" ';
			if (!is_null($sensor)) { echo 'value="'.$sensor->getSensorName().'" '; }
			echo 'tabindex="1" required>'."\n";
			echo '<span class="error">';
			if (!is_null($sensor)) { echo $sensor->getError('sensor_name'); }
			echo '</span><br><br>'."\n";
			
			echo 'Sensor Type:&nbsp'.$sensor->getSensorType().'<br><br>'."\n";
			echo 'Sensor Units:&nbsp'.$sensor->getSensorUnits().'<br><br>'."\n";
			echo 'Sequence Type:&nbsp'.$sensor->getSequenceType().'<br><br>'."\n";
			
			echo 'Description:';
			echo '<span class="error">';
			if (isset($sensor)) { echo $sensor->getError('description'); }
			echo '<span><br><br>'."\n";
			echo '<textarea class="form-control" name="description" tabindex="2" rows="2">';
			if (isset($sensor)) { echo $sensor->getDescription(); }
			echo '</textarea>';
			echo '<br><br>';
			
			echo '<p><input type="submit" name="submit" value="Submit">';
			echo '&nbsp&nbsp';
			echo '<a href="/'.$base.'/sensor/show/'.$sensor->getSensorId().'">Cancel</a><br>';
			echo '</form>';
			echo '</section>';
		}
	}
	
	private function showDetails() {
		$sensor = (array_key_exists('sensor', $_SESSION)) ? $_SESSION['sensor'] : null;
		$dataset = (array_key_exists('dataset', $_SESSION)) ? $_SESSION['dataset'] : null;
		$user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
	
		if (!is_null($sensor)) {
			echo '<h1>Sensor Summary</h1>';
			
			$targetSensorUserId = $dataset->getUserId();
			if (self::CurrentUserCanEditTargetSensor($targetSensorUserId)) {
				echo '<p>';
				echo '<a class="btn btn-primary" ';
				echo 'role="button" ';
				echo 'href="/'.$base.'/sensor/update/'.$sensor->getSensorId().'"';
				echo '>Update Sensor</a>';
				echo '&nbsp&nbsp';
				echo '<a class="btn btn-success" ';
				echo 'role="button" ';
				echo 'href="/'.$base.'/measurement/create">Add Measurements</a>';
				echo '</p>';
			}
			
			echo '<section>';
			echo '<fieldset><legend>Summary Info</legend>';
			echo 'Dataset Name:&nbsp<a href="/'.$base.'/dataset/show/'.$dataset->getDatasetId().
				'">'.$dataset->getDatasetName().'</a><br><br>'."\n";
			echo 'Sensor Name:&nbsp'.$sensor->getSensorName().'<br><br>'."\n";
			echo 'Sensor Type:&nbsp'.$sensor->getSensorType().'<br><br>'."\n";
			echo 'Sensor Units:&nbsp'.$sensor->getSensorUnits().'<br><br>'."\n";
			echo 'Sequence Type:&nbsp'.$sensor->getSequenceType().'<br><br>'."\n";
			echo 'Description:&nbsp'.$sensor->getDescription().'<br><br>'."\n";
			echo '</fieldset></section>';
			
			echo '<section>';
			echo '<h2>Sensor Measurements</h2>';
			
			if (count($sensor->getMeasurements()) > 0) {
				echo '<div class="table-responsive">';
				echo '<table class="table table-striped">';
				echo '<thead>';
				echo '<tr><th>';
				
				if ($sensor->getSequenceType() == 'TIME-CODED')
					echo 'Timestamp';
				else
					echo 'Sequence Number';
				
				echo '</th>';
				echo '<th>Measurement</th><tr></thead>'."\n";
				
				echo '<tbody>';
				foreach ($sensor->getMeasurements() as $measurement) {
					echo '<tr>';
					echo '<td>';
					
					if ($sensor->getSequenceType() == 'TIME-CODED')
						echo $measurement->getMeasurementTimestamp();
					else
						echo $measurement->getMeasurementIndex();
					echo '</td>';
					echo '<td>'.$measurement->getMeasurementValue().'</td></tr>'."\n";
				}
				echo '</tbody>';
				echo '</table>';
				echo '</div>';
			} else {
				echo '<p>No measurements associated with this sensor</p>';
			}
			echo '</section>';
		} else {
			echo '<p>Unknown sensor</p>';
		}
		echo '<br><br>';
	}
	
	private function CurrentUserCanEditTargetSensor($targetSensorUserId) {
		return LoginController::UserIsLoggedIn($targetSensorUserId);
	}
}
?>