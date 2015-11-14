<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\views\HomeView.class.php';

class HomeViewTest extends PHPUnit_Framework_TestCase {
	
	public function testGetLastNUsers() {
		$myDB = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		
		$numUsersToFetch = 3;
		
		$lastNUsers = HomeView::getLastNRegisteredUsers($numUsersToFetch);
		print_r($lastNUsers);
		$this->assertEquals(count($lastNUsers), $numUsersToFetch,
				'It should fetch the number of users specified');
	}
}
?>