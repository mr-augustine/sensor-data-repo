<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\User.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\UsersDB.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';

class UsersDBTest extends PHPUnit_Framework_TestCase {
	
	public function testGetAllUsers() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		$users = UsersDB::getUsersBy();
		
		$this->assertEquals(8, count($users),
				'It should fetch all of the users in the test database');
		
		foreach ($users as $user)
			$this->assertTrue(is_a($user, 'User'),
					'It should return valid User objects');
	}
	
	public function testInsertValidUser() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		
		$validTest = array('username' => 'valid-user', 'password' => '22222222');
		$s1 = new User($validTest);
		
		$beforeCount = count(UsersDB::getUsersBy());
		$newUser = UsersDB::addUser($s1);
		
		$this->assertEquals(0, $newUser->getErrorCount(),
				'The inserted user should have no errors');
		
		$afterCount = count(UsersDB::getUsersBy());
		$this->assertEquals($afterCount, $beforeCount + 1,
				'The database should have one more user after insertion');
	}
	
	public function testInsertInvalidUser() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		
		$beforeCount = count(UsersDB::getUsersBy());
		$invalidTest = array('username' => '', 'password' => 'yyyyyyyy');
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
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		
		$beforeCount = count(UsersDB::getUsersBy());
		$duplicateTest = array('username' => 'mwatney', 'password' => 'validpassword');
		$s1 = new User($duplicateTest);
		$newUser = UsersDB::addUser($s1);
		
		$this->assertGreaterThan(0, $newUser->getErrorCount(),
				'Duplicate attempt should return with an error');
		
		$afterCount = count(UsersDB::getUsersBy());
		$this->assertEquals($afterCount, $beforeCount,
				'The database should have no additional users after insertion');		
		ob_get_clean();
	}
	
	public function testGetUsersByUsername() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		
		$testUsername = 'mwatney';
		$users = UsersDB::getUsersBy('username', $testUsername);
		
		$this->assertEquals(1, count($users),
				'The database should return exactly one user with the provided username');
		
		$user = $users[0];
		$this->assertEquals($user->getUsername(), $testUsername,
				'The database should return exactly one user with the provided username');
	}
	
	public function testGetUsersByUserId() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		
		$testUserId = 2;
		$users = UsersDB::getUsersBy('user_id', $testUserId);
		
		$this->assertEquals(1, count($users),
				'The database should return exactly one user with the provided username');
		
		$user = $users[0];
		$this->assertEquals($user->getUserId(), $testUserId,
				'The database should return exactly one user with the provided username');
	}
	
	public function testGetNonexistentUserByUserId() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		
		$testUserId = 0;
		$users = UsersDB::getUsersBy('user_id', $testUserId);
		
		$this->assertEquals(0, count($users),
				'The database should return exactly one user with the provided username');
	}
	
	public function testUpdateUsername() {
		$myDb = DBMaker::create('sensordatarepotest');
		Database::clearDB();
		$db = Database::getDB('sensordatarepotest', 'C:\xampp\myConfig.ini');
		$testUserId = 1;
		$users = UsersDB::getUsersBy('user_id', $testUserId);
		$user = $users[0];
		
		$params = $user->getParameters();
		$this->assertEquals($user->getUsername(), 'jabituya',
				'Before the update is should have username jabituya');
		
		$params['username'] = 'jabituya2000';
		$newUser = new User($params);
		$newUser->setUserId($testUserId);
		
		$updatedUser = UsersDB::updateUser($newUser);
		
		$this->assertEquals($updatedUser->getUsername(), $params['username'],
				'After the update it should have username '.$params['username']);
		$this->assertTrue(empty($updatedUser->getErrors()),
				'The updated user should have no errors');
	}
}
?>