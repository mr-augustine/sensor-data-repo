<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\DatasetsDB.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Dataset.class.php';

class DatasetsDBTest extends PHPUnit_Framework_TestCase {
	
	public function testGetAllDatasets() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		
		$datasets = DatasetsDB::getDatasetsBy();
		
		$this->assertEquals(1, count($datasets),
				'It should fetch all of the datasets in the test database');
		
		foreach ($datasets as $dataset)
			$this->assertTrue(is_a($dataset, 'Dataset'),
					'It should return valid Dataset objects');
	}
	
	public function testInsertValidDataset() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		
		$validTest = array('user_id' => 1, 'dataset_name' => 'Franklin Park Run',
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
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		
		$invalidTest = array('user_id' => 1, 'dataset_name' => '',
				'description' => 'A walk in the park with my robot');
		$invalidDataset = new Dataset($invalidTest);
		
		$beforeCount = count(DatasetsDB::getDatasetsBy());
		$newDataset = DatasetsDB::addDataset($invalidDataset);
		
		$this->assertGreaterThan(0, $newDataset->getErrorCount(),
				'The inserted dataset should return with an error');
		
		$afterCount = count(DatasetsDB::getDatasetsBy());
		$this->assertEquals($afterCount, $beforeCount,
				'The database should have no additional datasets after insertion');
	}
	
	public function testInsertDuplicateDataset() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		
		$duplicateTest = array('user_id' => 1, 'dataset_name' => 'Lincoln Park Run');
		$duplicateDataset = new Dataset($duplicateTest);
		
		$beforeCount = count(DatasetsDB::getDatasetsBy());
		$newDataset = DatasetsDB::addDataset($duplicateDataset);
		
		$this->assertGreaterThan(0, $newDataset->getErrorCount(),
				'The inserted dataset should return with an error');
		
		$afterCount = count(DatasetsDB::getDatasetsBy());
		$this->assertEquals($afterCount, $beforeCount,
				'The database should have no additional datasets after insertion');
	}
	
	public function testGetDatasetByUserId() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		$testUserId = 1;
		$datasets = DatasetsDB::getDatasetsBy('user_id', $testUserId);
		
		$this->assertEquals(1, count($datasets),
				'The database should return exactly one datasets with the provided user id');
		
		$dataset = $datasets[0];
		$this->assertEquals($testUserId, $dataset->getUserId(),
				'The database should return the dataset with the provided user id');
	}
	
	public function testGetDatasetByDatasetId() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		$testDatasetId = 1;
		$datasets = DatasetsDB::getDatasetsBy('dataset_id', $testDatasetId);
		
		$this->assertEquals(1, count($datasets),
				'The database should return exactly one dataset with the provided id');
		
		$dataset = $datasets[0];
		$this->assertEquals($testDatasetId, $dataset->getDatasetId(),
				'The database should return the dataset with the provided id');
	}
	
	public function testGetDatasetByDatasetName() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		$testDatasetName = 'Lincoln Park Run';
		$datasets = DatasetsDB::getDatasetsBy('dataset_name', $testDatasetName);
		
		$this->assertEquals(1, count($datasets),
				'The database should return exactly one dataset with the provided name');
		
		$dataset = $datasets[0];
		$this->assertEquals($testDatasetName, $dataset->getDatasetName(),
				'The database should return the dataset with the provided name');
	}
	
	public function testUpdateDatasetName() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		$testDatasetId = 1;
		
		$datasets = DatasetsDB::getDatasetsBy('dataset_id', $testDatasetId);
		$dataset = $datasets[0];
		
		$this->assertEquals($dataset->getDatasetName(), 'Lincoln Park Run',
				'Before the update, it should have email Lincoln Park Run');
		
		$params = $dataset->getParameters();
		$params['dataset_name'] = 'Updated Lincoln Park Run';
		$newDataset = new Dataset($params);
		$newDataset->setDatasetId($testDatasetId);
		
		$returnedDataset = DatasetsDB::updateDataset($newDataset);
		
		$this->assertEquals($returnedDataset->getDatasetName(), $params['dataset_name'],
				'After the update it should have the name '.$params['dataset_name']);
		$this->assertTrue(empty($returnedDataset->getErrors()),
				'The updated dataset should have no errors');
	}
	
	public function testUpdateDatasetDescription() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		$testDatasetId = 1;
		
		$datasets = DatasetsDB::getDatasetsBy('dataset_id', $testDatasetId);
		$dataset = $datasets[0];
		
		$this->assertTrue(empty($dataset->getDescription()),
				'Before the update, it should have an empty description');
		
		$params = $dataset->getParameters();
		$params['description'] = 'Updated description';
		$newDataset = new Dataset($params);
		$newDataset->setDatasetId($testDatasetId);
		
		$returnedDataset = DatasetsDB::updateDataset($newDataset);
		
		$this->assertEquals($returnedDataset->getDescription(), $params['description'],
				'After the update it should have the name '.$params['description']);
	}
}
?>