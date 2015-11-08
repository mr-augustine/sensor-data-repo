<?php
class RobotDataView {
	
	public static function show() {
		$_SESSION['headertitle'] = "RobotData details";
		MasterView::showHeader();
		RobotDataView::showDetails();
		MasterView::showFooter();
	}
	
	public static function showAll() {
		if (array_key_exists('headertitle', $_SESSION)) {
			MasterView::showHeader();
		}
		
		$robotData = (array_key_exists('robotData', $_SESSION)) ? $_SESSION['robotData'] : array();
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		
		echo "<h1>botspace user data list</h1>";
		echo "<table>";
		echo "<thead>";
		echo "<tr><th>robotId</th><th>robot_name</th><th>creatorId</th><th>Show</th><th>Update</th>";
		echo "</thead>"."\n";
		
		echo "<tbody>";
		foreach ($robotData as $data) {
			echo '<tr>';
			echo '<td>'.$data->getRobotId().'</td>';
			echo '<td>'.$data->getRobotName().'</td>';
			
			echo '<td>';
			foreach ($data->getCreators() as $creatorId) {
				//echo $creator->getUserName()." ";
				echo $creatorId." ";
			}
			echo '</td>';

			echo '<td><a href="/'.$base.'/robotdata/show/'.$data->getRobotId().'">Show</a></td>';
			echo '<td><a href="/'.$base.'/robotdata/update/'.$data->getRobotId().'">Update</a></td>';
			echo '<tr>'."\n";
		}
		echo "</tbody>";
		echo "</table>\n";
		
		MasterView::showFooter();
	}
	
	public static function showDetails() {
		$robotData = (array_key_exists('robotData', $_SESSION)) ? $_SESSION['robotData'] : array();
		$creators = (array_key_exists('creators', $_SESSION)) ? $_SESSION['creators'] : array();
		
		if (is_null($robotData))
			echo '<p>Unknown robot data</p>';
		else {
			echo '<h1>RobotData for robotId $'.$robotData->getRobotId().'</h1>'."\n";
			
			echo '<section>';
			echo '<fieldset><legend>Robot Data</legend>'."\n";
			echo 'Robot Name: '.$robotData->getRobotName().'<br><br>'."\n";
			echo 'Status: '.$robotData->getStatus().'<br><br>'."\n";
			echo 'Creators: ';
			
			// TODO: Turn these into links to the users' profiles
			foreach ($creators as $creator) {
				echo $creator->getUserName()." ";
			}
			
			echo "<br><br>"."\n";
			echo '</fieldset><br>';
			echo '</section>';
		}
	}
	
	public static function showNew() {
	
	}
	
	public static function showUpdate() {
	
	}
}

?>