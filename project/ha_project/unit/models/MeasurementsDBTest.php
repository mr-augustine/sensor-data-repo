<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Measurement.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\MeasurementsDB.class.php';

class MeasurementsDBTest extends PHPUnit_Framework_TestCase {
	
	public function testGetAllMeasurements() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		
		$measurements = MeasurementsDB::getMeasurementsBy();
		
		$this->assertEquals(9, count($measurements),
				'It should fetch all of the measurements in the test database');
		
		foreach ($measurements as $measurement)
			$this->assertTrue(is_a($measurement, 'Measurement'),
					'It should return valid Measurement objects');
	}
	
	public function testValidMeasurementCreate() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		
		$validTest = array('measurement_index' => 4, 'measurement_value' => 'OFF',
				'measurement_timestamp' => '', 'sensor_id' => 3,
				'sensorType' => 'BINARY', 'sequenceType' => 'SEQUENTIAL');
		$validMeasurement = new Measurement($validTest);
		
		$beforeCount = count(MeasurementsDB::getMeasurementsBy());
		$newMeasurement = MeasurementsDB::addMeasurement($validMeasurement);

		$this->assertEquals(0, $newMeasurement->getErrorCount(),
				'The inserted measurement should be error-free');
		
		$afterCount = count(MeasurementsDB::getMeasurementsBy());
		$this->assertEquals($afterCount, $beforeCount + 1,
				'The database should have one more measurement after insertion');
	}
	
	public function testInsertDuplicateMeasurement() {
		// No two measurements should have the same index
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		
		$duplicateTest = array('measurement_index' => 1, 'measurement_value' => 0.0,
				'measurement_timestamp' => '', 'sensor_id' => 1,
				'sensorType' => 'HEADING', 'sequenceType' => 'SEQUENTIAL');
		$duplicateMeasurement = new Measurement($duplicateTest);
		
		$beforeCount = count(MeasurementsDB::getMeasurementsBy());
		$newMeasurement = MeasurementsDB::addMeasurement($duplicateMeasurement);
		
		$this->assertGreaterThan(0, $newMeasurement->getErrorCount(),
				'The inserted measurement should return with an error');
		
		$afterCount = count(MeasurementsDB::getMeasurementsBy());
		$this->assertEquals($afterCount, $beforeCount,
				'The database should have no additional measurements after the insertion attempt');
	}
	
	public function testGetMeasurementsBySensorId() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		$testSensorId = 3;
		$measurements = MeasurementsDB::getMeasurementsBy('sensor_id', $testSensorId);
		
		$this->assertEquals(3, count($measurements),
				'The database should return exactly three measurements with the provided sensor_id');
		
		foreach ($measurements as $measurement)
			$this->assertEquals($measurement->getSensorId(), $testSensorId,
					'The database should return only those measurements with the provided sensor_id');
	}
	
	public function testGetMeasurementByMeasurementId() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		$testMeasurementId = 2;
		$measurements = MeasurementsDB::getMeasurementsBy('measurement_id', $testMeasurementId);
		
		$this->assertEquals(1, count($measurements),
				'The database should return exactly 1 measurements with the provided measurement_id');
		
		$measurement = $measurements[0];
		$this->assertEquals($measurement->getMeasurementId(), $testMeasurementId,
				'The database should return the measurement with the provided measurement_id');
	}
	
	public function testUpdateMeasurementValue() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		$testMeasurementId = 1;
		
		$measurements = MeasurementsDB::getMeasurementsBy('measurement_id', $testMeasurementId);
		$measurement = $measurements[0];
		
		$this->assertEquals($measurement->getMeasurementValue(), '45.2',
				'Before the update, the measurement should have value 45.2');
		
		$params = $measurement->getParameters();
		$params['measurement_value'] = '25.4';
		$params['sensorType'] = 'HEADING';
		$params['sequenceType'] = 'SEQUENTIAL';
		$newMeasurement = new Measurement($params);
		$newMeasurement->setMeasurementId($testMeasurementId);
		
		$returnedMeasurement = MeasurementsDB::updateMeasurement($newMeasurement);
		
		$this->assertEquals($returnedMeasurement->getMeasurementValue(), $params['measurement_value'],
				'After the update it should have the value '.$params['measurement_value']);
		
		$this->assertTrue(empty($returnedMeasurement->getErrors()),
				'The updated measurement should be error-free');
	}
}
?>