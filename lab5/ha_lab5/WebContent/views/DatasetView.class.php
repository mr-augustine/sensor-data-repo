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
		
	}
	
	public static function showUpdate() {
		
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
				echo 'href="/'.$base.'/dataset/update/'.$dataset->getDatasetId().'" ';
				echo '>Update Dataset</a>';
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
				echo '<table>';
				echo '<thead>';
				echo '<tr><th>Name</th><th>Type</th><th>Units</th><th>Num Records</th>';
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
					echo '</tr>'."\n";
				}
				echo '</tbody>';
				echo '</table>';
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
}
?>