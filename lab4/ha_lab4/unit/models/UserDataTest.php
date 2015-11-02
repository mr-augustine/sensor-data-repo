<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\UserData.class.php';

class UserDataTest extends PHPUnit_Framework_TestCase {
	
	public function testValidAllFieldsUserDataCreate() {
		$validTest = array("userId" => 2, "user_name" => "test-user123", "skill_level" => "novice",
				"skill_areas" => array("programming", "ultrasonic", "wiring"),
				"profile_pic" => "no-photo.jpg", "started_hobby" => "2015-10-01",
				"fav_color" => "#00ff00", "url" => "http://www.askjeeves.com",
				"phone" => "210-555-4444");
		$s1 = new UserData($validTest);
		//print_r($s1->getErrors());
		$this->assertTrue(is_a($s1, 'UserData') && $s1->getErrorCount() == 0,
				'It should create a valid UserData object when valid input is provided');
	}
	
	public function testValidMandatoryOnlyFieldsUserDataCreate() {
		$validTest = array("userId" => 2, "user_name" => "test-user123", "skill_level" => "novice",
				"started_hobby" => "2015-10-01", "fav_color" => "#00ff00");
		$s1 = new UserData($validTest);
		//print_r($s1->getErrors());
		$this->assertTrue(is_a($s1, 'UserData') && $s1->getErrorCount() == 0,
				'It should create a valid UserData object when valid input is provided');
	}
	
	public function testInsertDuplicateUserData() {
		ob_start();
		
		$myDb = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		
		$beforeCount = count(UserDataDB::getUserDataBy());
		$userDataCopy = UserDataDB::getUserDataRowSetsBy('userDataId', 1);
		$userDataCopy = $userDataCopy[0];
		
		$s1 = new UserData($userDataCopy);
		$insertedUserData = UserDataDB::addUserData($s1);
		
		$this->assertGreaterThan(0, $insertedUserData->getErrorCount(),
				'Duplicate attempt should return with an error');
		
		$afterCount = count(UserDataDB::getUserDataBy());
		$this->assertEquals($afterCount, $beforeCount,
				'The database should have the same number of elements after the insertion attempt');
		
		ob_get_clean();
	}
	
	// Add tests for invalid fields
}
?>