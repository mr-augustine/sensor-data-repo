<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\User.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\UsersDB.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';


class UsersDBTest extends PHPUnit_Framework_TestCase {
	
	public function testGetAllUsers() {
  		$myDb = DBMaker::create('botspacetest');
  	  	Database::clearDB();
  	  	$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
  	  	$users = UsersDB::getUsersBy();
  	  	$this->assertEquals(8, count($users), 
  	  		'It should fetch all of the users in the test database');

  	  	foreach ($users as $user) 
          	$this->assertTrue(is_a($user, 'User'), 
        		'It should return valid User objects');
  	}
  
	public function testInsertValidUser() {
  		$myDb = DBMaker::create('botspacetest');
  		Database::clearDB();
  		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
  		$beforeCount = count(UsersDB::getUsersBy());
  		$validTest = array("email" => "validemail@somewhere.com", "password" => "22222222");
  		$s1 = new User($validTest);
  		$newUser = UsersDB::addUser($s1);
  		$this->assertEquals(0, $newUser->getErrorCount(),
  				'The inserted user should have no errors');
  		$afterCount = count(UsersDB::getUsersBy());
  		$this->assertEquals($afterCount, $beforeCount + 1,
  			'The database should have one more user after insertion');
  	}

  	public function testInsertInvalidUser() {
  		$myDb = DBMaker::create('botspacetest');
  		Database::clearDB();
  		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
  		$beforeCount = count(UsersDB::getUsersBy());
  		$invalidTest = array("email" => "invalidemail@", "password" => "22222222");
  		$s1 = new User($invalidTest);
  		$newUser = UsersDB::addUser($s1);
  		$this->assertGreaterThan(0, $newUser->getErrorCount(),
  				'The user should return with an error');
  		$afterCount = count(UsersDB::getUsersBy());
  		$this->assertEquals($afterCount, $beforeCount,
  				'The database should have no additional users after insertion');
  	}
  	
  	public function testInsertDuplicateUser() {
  		ob_start();
  		$myDb = DBMaker::create('botspacetest');
  		Database::clearDB();
  		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
  		$beforeCount = count(UsersDB::getUsersBy());
  		$duplicateTest = array("email" => "altars@gmail.com", "password" => "whatever");
  		$s1 = new User($duplicateTest);
  		$newUser = UsersDB::addUser($s1);
  		$this->assertGreaterThan(0, $newUser->getErrorCount(),
  				'Duplicate attempt should return with an error');
  		$afterCount = count(UsersDB::getUsersBy());
  		$this->assertEquals($afterCount, $beforeCount,
  				'The database should have the same number of elements after trying to insert duplicate');
  		ob_get_clean();
  	}
  	
  	public function testGetUsersByEmail() {
  		$myDb = DBMaker::create('botspacetest');
  		Database::clearDB();
  		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
  		$testUserEmail = 'charlie.g@hotmail.com';
  		$users = UsersDB::getUsersBy('email', $testUserEmail);
  		
  		$this->assertTrue(count($users) == 1, 
  				'The database should return exactly one user with the provided email');
  		
  		$user = $users[0];
  		
  		$this->assertTrue(strcmp($user->getEmail(), $testUserEmail) == 0, 
  				'The database should return exactly one user with the provided email');;
  	}
  	
  	public function testGetNonexistentUserByUserId() {
  		$myDB = DBMaker::create('botspacetest');
  		Database::clearDB();
  		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
  		$testUserId = 0;
  		$users = UsersDB::getUsersBy('userId', $testUserId);
  		
  		$this->assertEquals(count($users), 0,
  				'The database should return zero results');
  	}
  	
  	public function testUpdateUserEmail() {
  		$myDB = DBMaker::create('botspacetest');
  		Database::clearDB();
  		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
  		$testUserId = 1;
  		$users = UsersDB::getUsersBy('userId', $testUserId);
  		$user = $users[0];
  		
  		$params = $user->getParameters();
  		$this->assertEquals($user->getEmail(), 'bjabituya@yahoo.com',
  				'Before the update it should have email bjabituya@yahoo.com');
  		
  		$params['email'] = 'bjabituya2000@yahoo.com';
  		$newUser = new User($params);
  		$newUser->setUserId($testUserId);
  		
  		$user = UsersDB::updateUser($newUser);

  		$this->assertEquals($user->getEmail(), 'bjabituya2000@yahoo.com',
  				'After the update it should have email bjabituya2000@yahoo.com');
  		$this->assertTrue(empty($user->getErrors()),
  				'The updated user should have no errors');
  		
  	}
}
?>