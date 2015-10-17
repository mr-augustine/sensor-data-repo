<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\User.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\UsersDB.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\makeDB.php';


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
  		$userId = UsersDB::addUser($s1);
  		$this->assertGreaterThan(0, $userId, 'The inserted user id should be positive');
  		$afterCount = count(UsersDB::getAllUsers());
  		$this->assertEquals($afterCount, $beforeCount + 1,
  			'The database should have one more user after insertion');
  	}
  
  	public function testInsertDuplicateUser() {
  		ob_start();
  		$myDb = DBMaker::create('botspacetest');
  		Database::clearDB();
  		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
  		$beforeCount = count(UsersDB::getAllUsers());
  		$duplicateTest = array("email" => "altars@gmail.com", "password" => "whatever");
  		$s1 = new User($duplicateTest);
  		$userId = UsersDB::addUser($s1);
  		$this->assertEquals(0, $userId, 'Duplicate attempt should return 0 userId');
  		$afterCount = count(UsersDB::getAllUsers());
  		$this->assertEquals($afterCount, $beforeCount,
  				'The database should have the same number of elements after trying to insert duplicate');
  		ob_get_clean();
  	}
}
?>