<?php
class RobotDataView {
	
	public static function show() {
		$_SESSION['headertitle'] = "RobotData details";
		$_SESSION['styles'] = array('site.css');
		MasterView::showHeader();
		RobotDataView::showDetails();
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showAll() {
		$_SESSION['styles'] = array('site.css');
		if (array_key_exists('headertitle', $_SESSION)) {
			MasterView::showHeader();
		}
		MasterView::showNavBar();
		
		$robotData = (array_key_exists('robotData', $_SESSION)) ? $_SESSION['robotData'] : array();
		$creators = (array_key_exists('creators', $_SESSION)) ? $_SESSION['creators'] : array();
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		
		echo "<h1>botspace user data list</h1>";
		echo "<table>";
		echo "<thead>";
		echo "<tr><th>robotId</th><th>robot_name</th><th>creatorId</th><th>Show</th><th>Update</th>";
		echo "</thead>"."\n";
		
		echo "<tbody>";
		foreach ($robotData as $key => $data) {
			echo '<tr>';
			echo '<td>'.$data->getRobotId().'</td>';
			echo '<td>'.$data->getRobotName().'</td>';
			
			echo '<td>';
			foreach ($creators[$key] as $creator) {
			//foreach ($data->getCreators() as $creatorId) {
				echo $creator->getUserName()." ";
				//echo $creatorId." ";
			}
			echo '</td>';

			echo '<td><a href="/'.$base.'/robotdata/show/'.$data->getRobotId().'">Show</a></td>';
			echo '<td><a href="/'.$base.'/robotdata/update/'.$data->getRobotId().'">Update</a></td>';
			echo '<tr>'."\n";
		}
		echo "</tbody>";
		echo "</table>\n";
		
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showDetails() {
		$robotData = (array_key_exists('robotData', $_SESSION)) ? $_SESSION['robotData'] : array();
		$creators = (array_key_exists('creators', $_SESSION)) ? $_SESSION['creators'] : array();
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		
		if (is_null($robotData))
			echo '<p>Unknown robot data</p>';
		else {
			echo '<h1>RobotData for robotId '.$robotData->getRobotId().'</h1>'."\n";
			
			echo '<section>';
			echo '<fieldset><legend>Robot Data</legend>'."\n";
			echo 'Robot Name: '.$robotData->getRobotName().'<br><br>'."\n";
			echo 'Status: '.$robotData->getStatus().'<br><br>'."\n";
			echo 'Creators: ';
			
			foreach ($creators as $creator) {
				echo '<a href="/'.$base.'/user/show/'.$creator->getUserDataId().'">'.$creator->getUserName().'</a>&nbsp'."\n";
			}
			
			echo "<br><br>"."\n";
			echo '</fieldset><br>';
			echo '</section>';
		}
	}
	
	public static function showNew() {
		$robotData = (array_key_exists('robotData', $_SESSION)) ? $_SESSION['robotData'] : null;
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		$_SESSION['headertitle'] = "botspace RobotData Creator";
		$_SESSION['styles'] = array('site.css');
		MasterView::showHeader();
		MasterView::showNavBar();
		
		echo '<h1>Create a new RobotData entry</h1>';
		
		if ($_SESSION['authenticated'] == false) {
			echo '<p>You must log in to create a robot data entry</p>';
			return;
		}
		
		echo '<form action="/'.$base.'/robotdata/create/new" method="POST">';
		if (!is_null($robotData) && array_key_exists('robotId', $robotData->getErrors()))
			echo 'Error: '.$robotData->getError('robotId')."<br>";
		
		echo 'Robot Name: <input type="text" name="robot_name"';
			if (!is_null($robotData)) { echo 'value="'.$robotData->getRobotName().'"'; }
		echo ' tabindex="1" required>'."\n";
		echo '<span class="error">';
			if (!is_null($robotData)) { echo $robotData->getError('robot_name'); }
		echo '</span><br><br>'."\n";
		
		echo 'Status: <input type="text" name="status"';
			if (!is_null($robotData)) { echo 'value="'.$robotData->getStatus().'"'; }
		echo ' tabindex="2" required>'."\n";
		echo '<span class="error">';
			if (!is_null($robotData)) { echo $robotData->getError('status'); }
		echo '</span><br><br>'."\n";
		
		echo 'Creator';
		if (!is_null($robotData)) {
			if (count($robotData->getCreators()) > 1) { echo "s"; }
			
			echo ': ';
		}
		
		if (!is_null($robotData)) {
			$creators = $robotData->getCreators();
			
			foreach ($creators as $creator) {
				echo '<input type="text" name="creators[]" value="'.$creator.'" required><br>'."\n";
			}
		} else {
			echo '<input type="text" name="creators[]" value="" required>'."\n";
		}
		
		echo '<br><br>';
		echo '<p><input type="submit" name="submit" value="Submit">';
		echo '&nbsp&nbsp';
		echo '<a href="/'.$base.'/robotdata/show/all">Cancel</a><br>';
		echo '</form>';
		
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showUpdate() {
	
	}
}

?>