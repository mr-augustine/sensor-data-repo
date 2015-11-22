<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Sensor.class.php';

class SensorTest extends PHPUnit_Framework_TestCase {
	
	public function testValidSensorCreate() {
		$validTest = array('sensor_id' => 1,
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
			'sensor_name' => 'sensor_0',
			'sensor_type' => 'TEMPERATURE',
			'sensor_units' => 'DEGREES-FAHRENHEIT',
			'sequence_type' => 'TIME-CODED',
			'description' => 'This description is 256 characters long'.
				'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna. Nunc viverra imperdiet enim. Fusce est. Vivamus a tellus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pharetra nonummy pede. Mauris et orci. Aenean nec lorem. In porttitor. Donec laoreet nonummy augue. Suspendisse dui purus, scelerisque at, vulputate vitae, pretium mattis, nunc. Mauris eget neque at sem venenatis eleifend. Ut nonummy. Fusce aliquet pede non pede. Suspendisse dapibus lorem pellentesque magna. Integer nulla. Donec blandit feugiat ligula. Donec hendrerit, felis et imperdiet euismod, purus ipsum pretium metus, in lacinia nulla nisl eget sapien. Donec ut est in lectus consequat consequat. Etiam eget dui. Aliquam erat volutpat. Sed at lorem in nunc porta tristique. Proin nec augue. Quisque aliquam tempor magna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc ac magna. Maecenas odio dolor, vulputate vel, auctor ac, accumsan id, felis. Pellentesque cursus sagittis felis. Pellentesque porttitor, velit lacinia egestas auctor, diam eros tempus arcu, nec vulputate augue magna vel risus. Cras non magna vel ante adipiscing rhoncus. Vivamus a mi. Morbi neque. Aliquam erat volutpat. Integer ultrices lobortis eros. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin semper, ante vitae sollicitudin posuere, metus quam iaculis nibh, vitae scelerisque nunc massa eget pede. Sed velit urna, interdum vel, ultricies vel, faucibus at, quam. Donec ',
			'measurements' => array());
		$invalidSensor = new Sensor($invalidTest);
		
		$this->assertEquals(1, $invalidSensor->getErrorCount(),
				'The Sensor object should have exactly 1 error');
		$this->assertTrue(!empty($invalidSensor->getError('description')),
				'The Sensor should have a description error');
	}
}
?>