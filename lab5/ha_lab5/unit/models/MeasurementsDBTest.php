<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Measurement.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\MeasurementsDB.class.php';

class MeasurementsDBTest extends PHPUnit_Framework_TestCase {
	
	public function testGetAllMeasurements() {
		
	}
	
	public function testValidMeasurementCreate() {
		
	}
	
	public function testInsertDuplicateMeasurement() {
		// No two measurements should have the same index
		
	}
	
	public function testGetMeasurementsBySensorId() {
		
	}
	
	public function testGetMeasurementsByMeasurementIndex() {
		
	}
	
	public function testGetMeasurementByMeasurementId() {
		
	}
}
?>