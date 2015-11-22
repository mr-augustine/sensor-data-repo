<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Measurement.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\MeasurementsDB.class.php';

class MeasurementsDBTest extends PHPUnit_Framework_TestCase {
	
	public function testGetAllMeasurements() {
		$this->assertTrue(false, 'Test not implemented yet');
	}
	
	public function testValidMeasurementCreate() {
		$this->assertTrue(false, 'Test not implemented yet');
	}
	
	public function testInsertDuplicateMeasurement() {
		// No two measurements should have the same index
		$this->assertTrue(false, 'Test not implemented yet');
	}
	
	public function testGetMeasurementsBySensorId() {
		$this->assertTrue(false, 'Test not implemented yet');
	}
	
	public function testGetMeasurementsByMeasurementIndex() {
		$this->assertTrue(false, 'Test not implemented yet');
	}
	
	public function testGetMeasurementByMeasurementId() {
		$this->assertTrue(false, 'Test not implemented yet');
	}
}
?>