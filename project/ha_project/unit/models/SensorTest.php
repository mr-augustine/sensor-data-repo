<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Sensor.class.php';

class SensorTest extends PHPUnit_Framework_TestCase {
	
	public function testValidSensorCreate() {
		$validTest = array('sensor_id' => 1,
			'dataset_id' => 1,
			'sensor_name' => 'sensor_0',
			'sensor_type' => 'TEMPERATURE',
			'sensor_units' => 'DEGREES-FAHRENHEIT',
			'sequence_type' => 'TIME-CODED',
			'description' => 'In the garage by the workbench',
			'measurements' => array());
		$validSensor = new Sensor($validTest);
		
		$this->assertTrue(is_a($validSensor, 'Sensor'),
				'It should create a Sensor object when valid input is provided');
		$this->assertEquals(0, $validSensor->getErrorCount(),
				'The Sensor object should be error-free');
	}
	
	public function testInvalidSensorName() {
		$invalidTest = array('sensor_id' => 1,
			'dataset_id' => 1,
			'sensor_name' => 'invalid@sensorname',
			'sensor_type' => 'TEMPERATURE',
			'sensor_units' => 'DEGREES-FAHRENHEIT',
			'sequence_type' => 'TIME-CODED',
			'description' => 'In the garage by the workbench',
			'measurements' => array());
		$invalidSensor = new Sensor($invalidTest);

		$this->assertEquals(1, $invalidSensor->getErrorCount(),
				'The Sensor object should have exactly 1 error');
		$this->assertTrue(!empty($invalidSensor->getError('sensor_name')),
				'The Sensor should have a sensor_name error');
	}
	
	public function testInvalidSensorType() {
		$invalidTest = array('sensor_id' => 1,
			'sensor_name' => 'sensor_0',
			'dataset_id' => 1,
			'sensor_type' => 'INVALID_TYPE',
			'sensor_units' => 'DEGREES-FAHRENHEIT',
			'sequence_type' => 'TIME-CODED',
			'description' => 'In the garage by the workbench',
			'measurements' => array());
		$invalidSensor = new Sensor($invalidTest);
		
		$this->assertEquals(1, $invalidSensor->getErrorCount(),
				'The Sensor object should have exactly 1 error');
		$this->assertTrue(!empty($invalidSensor->getError('sensor_type')),
				'The Sensor should have a sensor_type error');
	}
	
	public function testInvalidSensorUnits() {
		$invalidTest = array('sensor_id' => 1,
			'dataset_id' => 1,
			'sensor_name' => 'sensor_0',
			'sensor_type' => 'TEMPERATURE',
			'sensor_units' => 'INVALID_UNITS',
			'sequence_type' => 'TIME-CODED',
			'description' => 'In the garage by the workbench',
			'measurements' => array());
		$invalidSensor = new Sensor($invalidTest);
		
		$this->assertEquals(1, $invalidSensor->getErrorCount(),
				'The Sensor object should have exactly 1 error');
		$this->assertTrue(!empty($invalidSensor->getError('sensor_units')),
				'The Sensor should have a sensor_units error');
	}
	
	public function testInvalidSequenceType() {
		$invalidTest = array('sensor_id' => 1,
			'dataset_id' => 1,
			'sensor_name' => 'sensor_0',
			'sensor_type' => 'TEMPERATURE',
			'sensor_units' => 'DEGREES-FAHRENHEIT',
			'sequence_type' => 'INVALID_SEQUENCE',
			'description' => 'In the garage by the workbench',
			'measurements' => array());
		$invalidSensor = new Sensor($invalidTest);
		
		$this->assertEquals(1, $invalidSensor->getErrorCount(),
				'The Sensor object should have exactly 1 error');
		$this->assertTrue(!empty($invalidSensor->getError('sequence_type')),
				'The Sensor should have a sequence_type error');
	}
	
	public function testInvalidDescription() {
		$invalidTest = array('sensor_id' => 1,
			'dataset_id' => 1,
			'sensor_name' => 'sensor_0',
			'sensor_type' => 'TEMPERATURE',
			'sensor_units' => 'DEGREES-FAHRENHEIT',
			'sequence_type' => 'TIME-CODED',
			'description' => 'This description is 132 characters long'.
				' Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna ',
			'measurements' => array());
		$invalidSensor = new Sensor($invalidTest);
		
		$this->assertEquals(1, $invalidSensor->getErrorCount(),
				'The Sensor object should have exactly 1 error');
		$this->assertTrue(!empty($invalidSensor->getError('description')),
				'The Sensor should have a description error');
	}
}
?>