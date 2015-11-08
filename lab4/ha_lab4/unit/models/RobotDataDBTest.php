<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\RobotDataDB.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\RobotData.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';

class RobotDataDBTest extends PHPUnit_Framework_TestCase {
	
	public function testGetAllRobotData() {
		$myDb = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		$robotData = RobotDataDB::getRobotDataBy();
		
		$this->assertEquals(3, count($robotData),
				'It should fetch all of the robot data in the test database');
	}
	
	public function testValidRobotDataCreate() {
		$myDb = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		
		$validTest = array("robot_name" => "David-8", "creators" => array(5), 
				"status" => "in-development");
		$s1 = new RobotData($validTest);
		
		$beforeCount = count(RobotDataDB::getRobotDataBy());
		$newRobotData = RobotDataDB::addRobotData($s1);
		
		$this->assertEquals(0, $newRobotData->getErrorCount(),
				'The inserted robot data should have no errors');
		
		$afterCount = count(RobotDataDB::getRobotDataBy());
		$this->assertEquals($afterCount, $beforeCount + 1,
				'The database should have one more robot data entry after insertion');
	}
	
	public function testInsertDuplicateRobotData() {
		$myDb = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		
		$beforeCount = count(RobotDataDB::getRobotDataBy());
		$robotDataCopy = RobotDataDB::getRobotDataBy('robotId', 2);
		$robotDataCopy = $robotDataCopy[0];
		
		$this->assertEquals(0, $robotDataCopy->getErrorCount(),
				'The robot data copy object should have no errors');
		
		$dupRobotData = RobotDataDB::addRobotData($robotDataCopy);
		
		$afterCount = count(RobotDataDB::getRobotDataBy());
		
		$this->assertTrue(!empty($dupRobotData->getError('robotId')) &&
				(strcmp(Messages::getError('ROBOT_DATA_INVALID'), $dupRobotData->getError('robotId')) == 0),
				'It should have a robotDataId error if the robot data is a duplicate');
		
		$this->assertEquals($afterCount, $beforeCount,
				'There should be no additional robot data entries after the insertion attempt');
	}
}
?>