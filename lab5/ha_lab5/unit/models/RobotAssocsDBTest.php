<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\RobotAssoc.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\RobotAssocsDB.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';

class RobotAssocsDBTest extends PHPUnit_Framework_TestCase {
	
	public function testGetAllRobotAssocs() {
		$mdDB = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		$robotAssocs = RobotAssocsDB::getRobotAssocsBy();
		
		$this->assertEquals(3, count($robotAssocs),
				'It should fetch all of the robot associations in the test database');
	}
	
	public function testValidRobotAssocsCreate() {
		$myDB = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		
		$validRobotId = 1;
		$validCreatorId = 2;
		$s1 = new RobotAssoc($validRobotId, $validCreatorId);
		
		$beforeCount = count(RobotAssocsDB::getRobotAssocsBy());
		$newRobotAssoc = RobotAssocsDB::addRobotAssoc($s1);
		
		$this->assertEquals(0, $s1->getErrorCount(),
				'The inserted robot association should have no errors');
		
		$afterCount = count(RobotAssocsDB::getRobotAssocsBy());
		$this->assertEquals($afterCount, $beforeCount + 1,
				'The database should have one more robot association entry after insertion');
	}
	
	public function testInsertDuplicateRobotAssoc() {
		$myDB = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		
		$beforeCount = count(RobotAssocsDB::getRobotAssocsBy());
		$robotAssocCopy = RobotAssocsDB::getRobotAssocsRowsBy('robotAssocId', 2);
		$robotAssocCopy = $robotAssocCopy[0];
		
		$s1 = new RobotAssoc($robotAssocCopy);
		$dupRobotAssoc = RobotAssocsDB::addRobotAssoc($s1);
		
		$afterCount = count(RobotAssocsDB::getRobotAssocsBy());
		
		$this->assertTrue(!empty($dupRobotAssoc->getError('robotAssocId')) &&
				(strcmp(Messages::getError('ROBOT_ASSOC_INVALID'), $s1->getError('robotAssocId')) == 0),
				'It should have a robotAssocId error if the robot association is a duplicate');
		
		$this->assertEquals($afterCount, $beforeCount,
				'There should be no additional robot association entries after the insertion attempt');
	}
}
?>