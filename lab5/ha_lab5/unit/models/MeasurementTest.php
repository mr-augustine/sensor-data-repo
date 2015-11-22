<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Measurement.class.php';

class MeasurementTest extends PHPUnit_Framework_TestCase {
	
	public function testValidMeasurementCreate() {
		$validTest = array('measurement_id' => 1,
				'measurement_index' => 1,
				'measurement_value' => '98.6',
				'measurement_timestamp' => '2015-11-21 18:15:23.123456',
				'sensor_id' => 1,
				'sensorType' => 'TEMPERATURE',
				'sequenceType' => 'TIME_CODED'
		);
		
		$newMeasurement = new Measurement($validTest);
		
		$this->assertTrue(is_a($newMeasurement, 'Measurement'),
				'It should create a Measurement object when '.
				'valid input is provided');
		$this->assertEquals(0, $newMeasurement->getErrorCount(),
				'The Measurement object should be error-free');
	}
	
	public function testInvalidMeasurementIndex() {
		$invalidTest = array('measurement_id' => '1',
				'measurement_index' => -1,
				'measurement_value' => 98.6,
				'measurement_timestamp' => '2015-11-21 18:15:23.123456',
				'sensor_id' => 1,
				'sensorType' => 'TEMPERATURE',
				'sequenceType' => 'TIME_CODED'
		);
		$invalidMeasurement = new Measurement($invalidTest);
		
		$this->assertEquals(1, $invalidMeasurement->getErrorCount(),
				'The Measurement object should have exactly 1 error');
		
		$this->assertTrue(!empty($invalidMeasurement->getError('measurement_index')),
				'The Measurement should have a measurement_index error');
	}
	
	public function testInvalidMeasurementValue() {
		$invalidTest = array('measurement_id' => 1,
				'measurement_index' => 1,
				'measurement_value' => 'invalid_temperature',
				'measurement_timestamp' => '2015-11-21 18:15:23.123456',
				'sensor_id' => 1,
				'sensorType' => 'TEMPERATURE',
				'sequenceType' => 'TIME_CODED'
		);
		$invalidMeasurement = new Measurement($invalidTest);
		
		$this->assertEquals(1, $invalidMeasurement->getErrorCount(),
				'The Measurement object should have exactly 1 error');
		
		$this->assertTrue(!empty($invalidMeasurement->getError('measurement_value')),
				'The Measurement should have a measurement_value error');
	}
	
	public function testInvalidMeasurementTimestamp() {
		$invalidTest = array('measurement_id' => 1,
				'measurement_index' => 1,
				'measurement_value' => 98.6,
				'measurement_timestamp' => '1915-11-21 18:15:23.123456',
				'sensor_id' => 1,
				'sensorType' => 'TEMPERATURE',
				'sequenceType' => 'TIME_CODED'
		);
		$invalidMeasurement = new Measurement($invalidTest);
		
		$this->assertEquals(1, $invalidMeasurement->getErrorCount(),
				'The Measurement object should have exactly 1 error');
		
		$this->assertTrue(!empty($invalidMeasurement->getError('measurement_timestamp')),
				'The Measurement should have a measurement_timestamp error');
	}
	
	public function testInvalidSensorId() {
		$invalidTest = array('measurement_id' => 1,
				'measurement_index' => 1,
				'measurement_value' => 98.6,
				'measurement_timestamp' => '2015-11-21 18:15:23.123456',
				'sensor_id' => -1,
				'sensorType' => 'TEMPERATURE',
				'sequenceType' => 'TIME_CODED'
		);
		$invalidMeasurement = new Measurement($invalidTest);
		
		$this->assertEquals(1, $invalidMeasurement->getErrorCount(),
				'The Measurement object should have exactly 1 error');
		
		$this->assertTrue(!empty($invalidMeasurement->getError('sensor_id')),
				'The Measurement should have a sensor_id error');
	}
}
?>