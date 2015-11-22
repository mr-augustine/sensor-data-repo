<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Measurement.class.php';

class MeasurementTest extends PHPUnit_Framework_TestCase {
	
	public function testValidMeasurementCreate() {
		$validTest = array('measurement_id' => 0,
				'measurement_index' => 0,
				'measurement_value' => 98.6,
				'measurement_timestamp' => '2015-11-21 18:15:23.123456',
				'sensor_id' => 1,
				'sensorType' => 'DISTANCE',
				'sequenceType' => 'TIME_CODED'
		);
		
		$newMeasurement = new Measurement($validTest);
		
		$this->assertTrue(false, 'Test not implemented yet');
	}
	
	public function testInvalidMeasurementId() {
		$this->assertTrue(false, 'Test not implemented yet');
	}
	
	public function testInvalidMeasurementIndex() {
		$this->assertTrue(false, 'Test not implemented yet');
	}
	
	public function testInvalidMeasurementValue() {
		$this->assertTrue(false, 'Test not implemented yet');
	}
	
	public function testInvalidMeasurementTimestamp() {
		$this->assertTrue(false, 'Test not implemented yet');
	}
	
	public function testInvalidSensorId() {
		$this->assertTrue(false, 'Test not implemented yet');
	}
}
?>