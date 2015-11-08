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
}
?>