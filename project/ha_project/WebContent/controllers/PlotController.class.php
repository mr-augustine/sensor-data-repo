<?php
class PlotController {
	
	public static function run() {
		$action = (array_key_exists('action', $_SESSION)) ? $_SESSION['action'] : "";
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : "";
		
		if (is_numeric($arguments)) {
			$measurements = MeasurementsDB::getMeasurementsBy('sensor_id', $arguments);
			
			if (count($measurements) > 0) {
				$sensorId = $measurements[0]->getSensorId();
				$sensorArray = SensorsDB::getSensorsBy('sensor_id', $sensorId);
			
				if (count($sensorArray) > 0)
					$sensor = $sensorArray[0];
				else
					HomeView::show();
			
				$datasetArray = DatasetsDB::getDatasetsBy('dataset_id', $sensor->getDatasetId());
			
				if (count($datasetArray) > 0)
					$dataset = $datasetArray[0];
				else
					HomeView::show();
			
				$_SESSION['measurements'] = $measurements;
				$_SESSION['sensor'] = $sensor;
				$_SESSION['dataset'] = $dataset;
			} else {
				HomeView::show();
			}
			
			switch ($action) {
				case "column";
					self::showColumnChart();
					break;
				case "line":
					self::showLineChart();
					break;
				default:
					HomeView::show();
			}
		} else {
			HomeView::show();
		}
		
	}
	
	private function showColumnChart() {
		$measurements = $_SESSION['measurements'];
		$sensor = $_SESSION['sensor'];
		$dataset = $_SESSION['dataset'];
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		
		if (isset($sensor) && isset($dataset)) {
			$plotTitle = $dataset->getDatasetName().' > '.$sensor->getSensorName();
			$yLabel = $sensor->getSensorType().' ('.$sensor->getSensorUnits().')';
			
			if ($sensor->getSequenceType() == 'TIME-CODED')
				$xLabel = 'Timestamp';
			else
				$xLabel = 'Sequence Number';
			
			$_SESSION['plotTitle'] = $plotTitle;
			$_SESSION['yLabel'] = $yLabel;
			$_SESSION['xLabel'] = $xLabel;
				
			PlotView::showColumnChart();
		} else {
			HomeView::show();
			header('Location: /'.$_SESSION['base']);
		}
	}
	
	
	private function showLineChart() {
		$measurements = $_SESSION['measurements'];
		$sensor = $_SESSION['sensor'];
		$dataset = $_SESSION['dataset'];
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		
		if (isset($sensor) && isset($dataset)) {
			/*$plotTitle = '<a href="/'.$base.'/dataset/show/'.$dataset->getDatasetId().'">'.$dataset->getDatasetName().'</a>'.
				' > <a href="/'.$base.'/sensor/show/'.$sensor->getSensorId().'">'.$sensor->getSensorName().'</a>';*/
			$plotTitle = $dataset->getDatasetName().' > '.$sensor->getSensorName();
			$yLabel = $sensor->getSensorType().' ('.$sensor->getSensorUnits().')';
			
			if ($sensor->getSequenceType() == 'TIME-CODED')
				$xLabel = 'Timestamp';
			else
				$xLabel = 'Sequence Number';
			
			$_SESSION['plotTitle'] = $plotTitle;
			$_SESSION['yLabel'] = $yLabel;
			$_SESSION['xLabel'] = $xLabel;
			
			PlotView::showLineChart();
		} else {
			HomeView::show();
			header('Location: /'.$_SESSION['base']);
		}
	}
}
?>