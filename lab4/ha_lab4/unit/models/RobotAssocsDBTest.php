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
}
?>