<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\DatasetsDB.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Dataset.class.php';

class DatasetsDBTest extends PHPUnit_Framework_TestCase {
	
	public function testGetAllDatasets() {
		
	}
	
	public function testInsertValidDataset() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		
		$validTest = array('dataset_name' => 'Franklin Park Run',
				'description' => 'A walk in the park with my robot');
		$validDataset = new Dataset($validTest);
		
		$beforeCount = count(DatasetsDB::getDatasetsBy());
		$newDataset = DatasetsDB::addDataset($validDataset);
		
		$this->assertEquals(0, $newDataset->getErrorCount(),
				'The inserted dataset should be error-free');
		
		$afterCount = count(DatasetsDB::getDatasetsBy());
		$this->assertEquals($afterCount, $beforeCount + 1,
				'The database should have one more dataset after insertion');
	}
	
	public function testInsertInvalidDataset() {
		
	}
	
	public function testInsertDuplicateDataset() {
		
	}
	
	public function testGetDatasetByDatasetId() {
		
	}
	
	public function testGetDatasetByDatasetName() {
		
	}
	
	public function testUpdateDatasetName() {
		
	}
	
	public function testUpdateDatasetDescription() {
		
	}
}
?>