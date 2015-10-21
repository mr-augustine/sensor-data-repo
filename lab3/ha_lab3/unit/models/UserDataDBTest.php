<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\UserData.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\UserDataDB.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.php';

class UserDataDBTest extends PHPUnit_Framework_TestCAse {
	
	public function testGetAllUserData() {
		$myDb = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		$usersData = UserDataDB::getUserDataBy();
		
		$this->assertEquals(1, count($usersData), 
				'It should fetch all of the user data in the test database');
	}
	
	public function testValidUserDataCreate() {
		$myDb = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		
		// UserData is not associated with userId yet
		$validTest = array("user_name" => "altars2000", "skill_level" => "novice",
				"skill_areas" => array("programming", "ultrasonic", "wiring"),
				"profile_pic" => "no-photo.jpg", "started_hobby" => "2015-10",
				"fav_color" => "#00ff00", "url" => "http://www.askjeeves.com",
				"phone" => "210-555-4444");
		$s1 = new UserData($validTest);
		$s1->setUserId(3);
		$beforeCount = count(UserDataDB::getUserDataBy());
		$newUserData = UserDataDB::addUserData($s1);

		$this->assertEquals(0, $s1->getErrorCount(),
				'The inserted user data should have no errors');
		
		$afterCount = count(UserDataDB::getUserDataBy());
		$this->assertEquals($afterCount, $beforeCount + 1,
				'The database should have one more user data after insertion');
	}
	
	public function testInvalidUserDataCreate() {
		$this->assertTrue(false, 'Test not implmented yet');
	}
	
	public function testGetUserDataByUserId() {
		$this->assertTrue(false, 'Test not implmented yet');
	}
	
	public function testGetUserDataByUserName() {
		$this->assertTrue(false, 'Test not implmented yet');
	}
	
	public function testGetUserDataBySkillLevel() {
		$this->assertTrue(false, 'Test not implmented yet');
	}
	
	public function testGetUserDataBySkillArea() {
		$this->assertTrue(false, 'Test not implmented yet');
	}
}
?>