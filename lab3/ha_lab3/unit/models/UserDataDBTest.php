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
		$validTest = array("userId" => 3, "user_name" => "altars2000", "skill_level" => "novice",
				"skill_areas" => array("programming", "ultrasonic", "wiring"),
				"profile_pic" => "no-photo.jpg", "started_hobby" => "2015-10-01",
				"fav_color" => "#00ff00", "url" => "http://www.askjeeves.com",
				"phone" => "210-555-4444");
		$s1 = new UserData($validTest);

		$beforeCount = count(UserDataDB::getUserDataBy());
		$newUserData = UserDataDB::addUserData($s1);

		$this->assertEquals(0, $s1->getErrorCount(),
				'The inserted user data should have no errors');
		
		$afterCount = count(UserDataDB::getUserDataBy());
		$this->assertEquals($afterCount, $beforeCount + 1,
				'The database should have one more user data after insertion');
	}
	
	public function testInvalidUserDataCreate() {
		// Use an output buffer to handle the expected error message from the
		// invalid insertion attempt
		ob_start();
		$myDb = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		
		// UserData is not associated with userId yet
		$validTest = array("userId" => 4, "user_name" => "the-original-mr-roboto", 
				"skill_level" => "invalid_skill_level",
				"skill_areas" => array("programming", "ultrasonic", "wiring"),
				"profile_pic" => "no-photo.jpg", "started_hobby" => "2015-10-01",
				"fav_color" => "#00ff00", "url" => "http://www.askjeeves.com",
				"phone" => "210-555-4444");
		$s1 = new UserData($validTest);
		
		$beforeCount = count(UserDataDB::getUserDataBy());
		$newUserData = UserDataDB::addUserData($s1);
		
		$this->assertTrue($s1->getErrorCount() > 0,
				'The user data should have an error');
		
		$afterCount = count(UserDataDB::getUserDataBy());
		$this->assertEquals($afterCount, $beforeCount,
				'The database should not have any additional user data entries after insertion');
		ob_get_clean();
	}
	
	public function testGetUserDataByUserId() {
		$myDb = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		$testUserId = 1;
		$userDataArray = UserDataDB::getUserDataBy('userId', $testUserId);
		
		$this->assertEquals(count($userDataArray), 1,
				'The database should return exactly one UserData entry');
		
		$userData = $userDataArray[0];
		
		$this->assertEquals($userData->getUserId(), $testUserId,
				'The database should return exactly one user data with the provided userId');
	}
	
	public function testGetUserDataByUserName() {
		$myDb = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		$testUserName = 'jabituya';
		$userDataArray = UserDataDB::getUserDataBy('user_name', $testUserName);
		
		$this->assertEquals(count($userDataArray), 1,
				'The database should return exactly one UserData entry');
		
		$userData = $userDataArray[0];
		
		$this->assertEquals($userData->getUserName(), $testUserName,
				'The database should return exactly one user data with the provided user name');
	}
	
	public function testGetUserDataBySkillLevel() {
		$myDb = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		$testSkillLevel = "advanced";
		$userDataArray = UserDataDB::getUserDataBy('skill_level', $testSkillLevel);
		
		foreach ($userDataArray as $userData) {
			$this->assertTrue(strcmp($userData->getSkillLevel(), $testSkillLevel) == 0, 
					'The database should return only user data with the specified skill level');
		}
	}
	
	public function testUpdateUserData() {
		$myDB = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		$testUserDataId = 1;
		$userDataArray = UserDataDB::getUserDataBy('userDataId', $testUserDataId);
		$userData = $userDataArray[0];
		
		$params = $userData->getParameters();
		$this->assertEquals($userData->getUserName(), 'jabituya',
				'Before the update it should have username jabituya');
		
// 		echo "userData params: "; print_r($params); echo "\n";
// 		echo "userData error count = ".$userData->getErrorCount()."\n";
// 		echo "error['started_hobby'] = ".$userData->getError('started_hobby')."\n";
// 		echo "error['fav_color'] = ".$userData->getError('fav_color')."\n";
		
		$testUserDataRowsArray = UserDataDB::getUserDataRowSetsBy('userDataId', $testUserDataId);
		$testUserDataRow = $testUserDataRowsArray[0];
		//echo "userDataRow: "; print_r($testUserDataRow); echo "\n";
		
		$params['user_name'] = 'jabituya2000';
		$newUserData = new UserData($params);
		$newUserData->setUserDataId($testUserDataId);
		
		//echo "newUserData error count: ".$userData->getErrorCount();
		
		$userData = UserDataDB::updateUserData($newUserData);
		
		echo "userData error count: ".$userData->getErrorCount()."\n";
		print_r($userData->getErrors());

		$this->assertEquals($userData->getUserName(), 'jabituya2000',
				'After the update it should have username jabituya2000');
		$this->assertTrue(empty($userData->getErrors()),
				'The updated user data should have no errors');
	}
	
	// TODO: Implement this feature later
	/*public function testGetUserDataBySkillArea() {
		$this->assertTrue(false, 'Test not implmented yet');
	}*/
}
?>