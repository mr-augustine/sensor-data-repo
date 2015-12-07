<?php
class DatasetView {
	
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
		$user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
		$dataset = (array_key_exists('dataset', $_SESSION)) ? $_SESSION['dataset'] : null;
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		$_SESSION['headertitle'] = "Sensor Data Repo | Create a Dataset";
		$_SESSION['styles'] = array('site.css');
		MasterView::showHeader();
		MasterView::showNavBar();
		
		if (!isset($user) || !LoginController::UserIsLoggedIn($user->getUserId())) {
			echo '<br><br>';
			echo '<p>You must log in to create a new Dataset</p>';
			return;
		}

		echo '<h1>Create a Dataset</h1>';
		echo '<section>';
		echo '<form action="/'.$base.'/dataset/create" method="POST">';
		
		if (isset($dataset) && array_key_exists('dataset_id', $dataset->getErrors()))
			echo 'Error: '.$dataset->getError('dataset_id')."<br>";
		
		echo 'Dataset Name:&nbsp<input type="text" name="dataset_name" ';
		if (isset($dataset)) { echo 'value="'.$dataset->getDatasetName().'"'; }
		echo 'tabindex="1" required>'."\n";
		echo '<span class="error">';
		if (isset($dataset)) { echo $dataset->getError('dataset_name'); }
		echo '</span><br><br>'."\n";
		
		echo 'Description:';
		echo '<span class="error">';
		if (isset($dataset)) { echo $dataset->getError('description'); }
		echo '</span><br><br>'."\n";
		echo '<textarea class="form-control" name="description" tabindex="2" rows="4">';
		if (isset($dataset)) { echo $dataset->getDescription(); }
		echo '</textarea>';
		echo '<br><br>';
		
		echo '<input type="hidden" name="user_id" value="'.$user->getUserId().'">';
		echo '<p><input type="submit" name="submit" value="Submit">';
		echo '&nbsp&nbsp';
		echo '<a href="/'.$base.'/profile/show/'.$user->getUserId().'">Cancel</a><br>';
		echo '</form>';
		echo '</section>';
	}
	
	public static function showUpdate() {
		$user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
		$dataset = (array_key_exists('dataset', $_SESSION)) ? $_SESSION['dataset'] : array();
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		$_SESSION['headertitle'] = 'Sensor Data Repo | Dataset Edit';
		$_SESSION['styles'] = array('site.css');
		MasterView::showHeader();
		MasterView::showNavBar();
		
		if (!is_null($dataset)) {
			echo '<h1>Dataset Edit</h1>';
			
			echo '<section>';
			echo '<form method="POST" action="/'.$base.'/dataset/update/'.$dataset->getDatasetId().'">';
			
			echo 'Dataset Name:&nbsp<input type="text" name="dataset_name" ';
			if (!is_null($dataset)) { echo 'value="'.$dataset->getDatasetName().'"'; }
			echo 'tabindex="1" required>'."\n";
			echo '<span class="error">';
			if (!is_null($dataset)) { echo $dataset->getError('dataset_name'); }
			echo '</span><br><br>'."\n";
			
			echo 'Created:&nbsp'.$dataset->getDateCreated().'<br><br>'."\n";
			echo 'Created by:&nbsp<a href="/'.$base.'/profile/show/'.$dataset->getUserId().
				'">'.$user->getUsername().'</a><br><br>'."\n";
			
			echo 'Description:';
			echo '<span class="error">';
			if (!is_null($dataset))
				echo $dataset->getError('description');
			echo '</span><br><br>'."\n";
			echo '<textarea class="form-control" name="description" rows="4">';
			if (!is_null($dataset))
				echo $dataset->getDescription();
			echo '</textarea>';
			echo '<br><br>';
			
			// Carry over the non-editable properties of Dataset
			//echo '<input type="hidden" name="dataset_id" value="'.$dataset->getDatasetId().'" />';
			
			echo '<p><input type="submit" name="submit" value="Submit">';
			echo '&nbsp&nbsp';
			echo '<a href="/'.$base.'/dataset/show/'.$dataset->getDatasetId().'">Cancel</a><br>';
			echo '</form>';
			echo '</section>';
		} else {
			echo '<p>Unknown dataset</p>';
		}
		
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	private function showDetails() {
		$user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
		$dataset = (array_key_exists('dataset', $_SESSION)) ? $_SESSION['dataset'] : array();
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		
		if (!is_null($dataset)) {
			echo '<h1>Dataset Summary</h1>';
			
			$targetDatasetUserId = $dataset->getUserId();
			if (self::CurrentUserCanEditTargetDataset($targetDatasetUserId)) {
				echo '<p>';
				echo '<a class="btn btn-primary" ';
				echo 'role="button" ';
				echo 'href="/'.$base.'/dataset/update/'.$dataset->getDatasetId().'"';
				echo '>Update Dataset</a>';
				echo '&nbsp&nbsp';
				echo '<a class="btn btn-success" ';
				echo 'role="button" ';
				echo 'href="/'.$base.'/sensor/create">Add Sensor</a>';
				echo '</p>';
			}
			
			echo '<section>';
			echo '<fieldset><legend>Summary Info</legend>';
			echo 'Dataset Name:&nbsp'.$dataset->getDatasetName().'<br><br>'."\n";
			echo 'Created:&nbsp'.$dataset->getDateCreated().'<br><br>'."\n";
			echo 'Created by:&nbsp<a href="/'.$base.'/profile/show/'.$dataset->getUserId().
				'">'.$user->getUsername().'</a><br><br>'."\n";
			echo 'Description:&nbsp'.$dataset->getDescription().'<br><br>'."\n";
			echo '</fieldset></section>';
			
			echo '<section>';
			echo '<h2>Dataset Sensors</h2>';
			
			if (count($dataset->getSensors()) > 0) {
				echo '<div class="table-responsive">';
				echo '<table class="table table-striped">';
				echo '<thead>';
				echo '<tr><th>Name</th><th>Type</th><th>Units</th><th>Num Records</th><th>Plot</th></tr>';
				echo '</thead>'."\n";
				
				echo '<tbody>';
				foreach ($dataset->getSensors() as $sensor) {
					$numRecords = count(MeasurementsDB::getMeasurementsBy('sensor_id', $sensor->getSensorId()));
					
					echo '<tr>';
					echo '<td><a href="/'.$base.'/sensor/show/'.$sensor->getSensorId().
						'">'.$sensor->getSensorName().'</a></td>';
					echo '<td>'.$sensor->getSensorType().'</td>';
					echo '<td>'.$sensor->getSensorUnits().'</td>';
					echo "<td>$numRecords</td>";
					
					if ($numRecords > 0)
						echo "<td>".self::LinksToPlotTypes($sensor->getSensorType(), $sensor->getSensorId())."<td>";
					else 
						echo "<td>No data</td>";
					echo '</tr>'."\n";
				}
				echo '</tbody>';
				echo '</table>';
				echo '</div>';
			} else {
				echo '<p>No sensors associated with this dataset</p>';
			}
			echo '</section>';
			
		} else {
			echo '<p>Unknown dataset</p>';
		}
		echo '<br><br>';
	}
	
	private function CurrentUserCanEditTargetDataset($targetDatasetUserId) {
		return LoginController::UserIsLoggedIn($targetDatasetUserId);
	}
	
	private function LinksToPlotTypes($sensorType, $sensorId) {
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		$linksToPlotTypes = '';
		
		switch ($sensorType) {
			// Line Only
			case 'ALTITUDE':
			case 'HEADING':
			case 'RATE':
			case 'TEMPERATURE':
				$linksToPlotTypes = '<a href="/'.$base.'/plot/line/'.$sensorId.'">Line</a>';
				break;
			
			// Column Only
			case 'BINARY':
			case 'RANGE':
				$linksToPlotTypes = '<a href="/'.$base.'/plot/column/'.$sensorId.'">Column</a>';
				break;
			
			// Line and Column
			case 'COUNT':
				$linksToPlotTypes = '<a href="/'.$base.'/plot/line/'.$sensorId.'">Line</a>';
				$linksToPlotTypes = $linksToPlotTypes.',&nbsp';
				$linksToPlotTypes = $linksToPlotTypes.'<a href="/'.$base.'/plot/column/'.$sensorId.'">Column</a>';
				break;
			
			// Chart not implemented yet
			default:
				$linksToPlotTypes = 'Not Plotable Yet';
				break;
		}
		
		return $linksToPlotTypes;
	}
}
?>