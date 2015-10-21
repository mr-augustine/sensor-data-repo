<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\User.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\UsersDB.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.php';


class UsersDBTest extends PHPUnit_Framework_TestCase {
	
	public function testGetAllUsers() {
  		$myDb = DBMaker::create('botspacetest');
  	  	Database::clearDB();
  	  	$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
  	  	$users = UsersDB::getAllUsers();
  	  	$this->assertEquals(4, count($users), 
  	  		'It should fetch all of the users in the test database');

  	  	foreach ($users as $user) 
          	$this->assertTrue(is_a($user, 'User'), 
        		'It should return valid User objects');
  	}
  
	public function testInsertValidUser() {
  		$myDb = DBMaker::create('botspacetest');
  		Database::clearDB();
  		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
  		$beforeCount = count(UsersDB::getAllUsers());
  		$validTest = array("email" => "validemail@somewhere.com", "password" => "22222222");
  		$s1 = new User($validTest);
  		$newUser = UsersDB::addUser($s1);
  		$this->assertEquals(0, $newUser->getErrorCount(),
  				'The inserted user should have no errors');
  		$afterCount = count(UsersDB::getAllUsers());
  		$this->assertEquals($afterCount, $beforeCount + 1,
  			'The database should have one more user after insertion');
  	}

  	public function testInsertInvalidUser() {
  		$myDb = DBMaker::create('botspacetest');
  		Database::clearDB();
  		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
  		$beforeCount = count(UsersDB::getAllUsers());
  		$invalidTest = array("email" => "invalidemail@", "password" => "22222222");
  		$s1 = new User($invalidTest);
  		$newUser = UsersDB::addUser($s1);
  		$this->assertGreaterThan(0, $newUser->getErrorCount(),
  				'The user should return with an error');
  		$afterCount = count(UsersDB::getAllUsers());
  		$this->assertEquals($afterCount, $beforeCount,
  				'The database should have no additional users after insertion');
  	}
  	
  	public function testInsertDuplicateUser() {
  		ob_start();
  		$myDb = DBMaker::create('botspacetest');
  		Database::clearDB();
  		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
  		$beforeCount = count(UsersDB::getAllUsers());
  		$duplicateTest = array("email" => "altars@gmail.com", "password" => "whatever");
  		$s1 = new User($duplicateTest);
  		$newUser = UsersDB::addUser($s1);
  		$this->assertGreaterThan(0, $newUser->getErrorCount(),
  				'Duplicate attempt should return with an error');
  		$afterCount = count(UsersDB::getAllUsers());
  		$this->assertEquals($afterCount, $beforeCount,
  				'The database should have the same number of elements after trying to insert duplicate');
  		ob_get_clean();
  	}
  	
}
?>