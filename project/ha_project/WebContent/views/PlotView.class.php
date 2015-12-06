<?php
class PlotView {
	
	public static function show() {
		$_SESSION['headertitle'] = 'Chart';
		$_SESSION['styles'] = array('site.css');
		
		MasterView::showHeader();
		MasterView::showNavBar();
		self::showDetails();
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showColumnChart() {
		$measurements = (array_key_exists('measurements', $_SESSION)) ? $_SESSION['measurements'] : null;
		$sensor = (array_key_exists('sensor', $_SESSION)) ? $_SESSION['sensor'] : null;
		$dataset = (array_key_exists('dataset', $_SESSION)) ? $_SESSION['dataset'] : null;
		$xLabel = (array_key_exists('xLabel', $_SESSION)) ? $_SESSION['xLabel'] : "";
		$yLabel = (array_key_exists('yLabel', $_SESSION)) ? $_SESSION['yLabel'] : "";
		$plotTitle = (array_key_exists('plotTitle', $_SESSION)) ? $_SESSION['plotTitle'] : "";
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : '';
		$_SESSION['headertitle'] = 'Sensor Data Repo | Column Chart';
		$_SESSION['styles'] = array('site.css');
		MasterView::showHeader();
		MasterView::showNavBar();
		
		self::writeChartHeader();
		
		echo "\n\n".'<script type="text/javascript">'."\n";
		echo 'google.setOnLoadCallback(drawChart);'."\n\n";
		
		echo 'function drawChart() {'."\n";
		echo 'var data = google.visualization.arrayToDataTable(['."\n";
		echo "\t".'[\''.$xLabel.'\', \''.$yLabel.'\', {role: \'style\'}]';

		foreach ($measurements as $measurement) {
			echo ",\n\t\t".'[\'';
			if ($sensor->requiresTimestampedMeasurements())
				echo $measurement->getTimestamp();
			else
				echo $measurement->getMeasurementIndex();
			
			if ($sensor->getSensorType() == 'BINARY')
				echo '\', '.self::TranslatedBinaryValue($measurement->getMeasurementValue()).', ';
			else
				echo '\', '.$measurement->getMeasurementValue().', ';
			echo '\'color: blue\']';
		}
		echo "\n\t\t".']);'."\n\n";
		
		echo 'var view = new google.visualization.DataView(data);'."\n";
		
		echo 'var options = {'."\n";
		echo "\t".'title: \''.$plotTitle.'\','."\n";
		echo "\t".'hAxis: { title: \''.$xLabel.'\' },'."\n";
		echo "\t".'vAxis: { title: \''.$yLabel.'\' },'."\n";
		echo "\t".'legend: { position: \'none\' }'."\n";
		echo '};'."\n";
		
		echo "\t".'var chart = new google.visualization.ColumnChart(document.getElementById(\'column_chart\'));'."\n";
		echo "\t".'chart.draw(view, options);'."\n";
		echo '}'."\n";
		echo '</script>'."\n";
		
		echo '<div id="column_chart" style="width: 900px; height 500px"></div>'."\n";
	}
	
	public static function showLineChart() {
		$measurements = (array_key_exists('measurements', $_SESSION)) ? $_SESSION['measurements'] : null;
		$sensor = (array_key_exists('sensor', $_SESSION)) ? $_SESSION['sensor'] : null;
		$dataset = (array_key_exists('dataset', $_SESSION)) ? $_SESSION['dataset'] : null;
		$xLabel = (array_key_exists('xLabel', $_SESSION)) ? $_SESSION['xLabel'] : "";
		$yLabel = (array_key_exists('yLabel', $_SESSION)) ? $_SESSION['yLabel'] : "";
		$plotTitle = (array_key_exists('plotTitle', $_SESSION)) ? $_SESSION['plotTitle'] : "";
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : '';
		$_SESSION['headertitle'] = 'Sensor Data Repo | Line Chart';
		$_SESSION['styles'] = array('site.css');
		MasterView::showHeader();
		MasterView::showNavBar();
		
		self::writeChartHeader();
		
		echo "\n\n".'<script type="text/javascript">'."\n";
      	echo 'google.setOnLoadCallback(drawChart);'."\n\n";

      	echo 'function drawChart() {'."\n";
        echo 'var data = google.visualization.arrayToDataTable(['."\n";
        echo "\t".'[\''.$xLabel.'\', \''.$yLabel.'\']';
        
        foreach ($measurements as $measurement) {
        	echo ",\n\t\t".'[\'';
        	if ($sensor->requiresTimestampedMeasurements())
        		echo $measurement->getTimestamp();
        	else
        		echo $measurement->getMeasurementIndex();
        	echo '\', '.$measurement->getMeasurementValue().']';
        }
        echo "\n\t\t".']);'."\n\n";

        echo "\t".'var options = {'."\n";
        echo "\t".'title: \''.$plotTitle.'\','."\n";
        echo "\t".'hAxis: { title: \''.$xLabel.'\' },'."\n";
        echo "\t".'vAxis: { title: \''.$yLabel.'\' },'."\n";
        echo "\t".'curveType: \'function\','."\n";
        echo "\t".'legend: { position: \'none\' }'."\n";
        echo '};'."\n";

        echo "\t".'var chart = new google.visualization.LineChart(document.getElementById(\'curve_chart\'));'."\n";

        echo "\t".'chart.draw(data, options);'."\n";
      	echo '}'."\n";
    	echo '</script>'."\n";
    	
    	echo '<div id="curve_chart" style="width: 900px; height: 500px"></div>'."\n";
	}
	
	private function writeChartHeader() {
		echo '<script type="text/javascript"'."\n";
		echo "\t".'src="https://www.google.com/jsapi?autoload={'."\n";
        echo "\t\t".'\'modules\':[{'."\n";
        echo "\t\t".'\'name\':\'visualization\','."\n";
        echo "\t\t".'\'version\':\'1\','."\n";
        echo "\t\t".'\'packages\':[\'corechart\']'."\n";
        echo "\t\t".'}]'."\n";
        echo "\t\t".'}"></script>'."\n";
	}
	
	private function TranslatedBinaryValue($measurementValue) {
		$translatedBinaryValue = '';
		
		switch ($measurementValue) {
			case '1':
			case 'YES':
			case 'TRUE':
			case 'ON':
				$translatedBinaryValue = 1;
				break;
			default:
				$translatedBinaryValue = 0;
		}
		
		return $translatedBinaryValue;
	}
}
?>
