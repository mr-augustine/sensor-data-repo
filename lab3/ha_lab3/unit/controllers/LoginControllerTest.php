<?php
require_once dirname (__FILE__).'\..\..\WebContent\controllers\LoginController.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\models\User.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\models\UsersDB.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\views\HomeView.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\views\LoginView.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\views\MasterView.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';

class LoginControllerTest extends PHPUnit_Framework_TestCase {
	/**
	 * @runInSeparateProcess
	 */	
	public function testCallRunFromPost() {
		ob_start();
		
		DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB($dbName = 'botspacetest', $configPath = 'C:\xampp\myConfig.ini');
		
		$_SERVER['REQUEST_METHOD'] = "POST";
		$_SERVER['HTTP_HOST'] = "localhost";
		$_POST = array("email" =>"asuda@kenbishi.jp", "password" => "zzzzzzzz");
		
		$_SESSION = array("base" => "ha_lab3");
		
		LoginController::run();
		$output = ob_get_clean();
		$this->assertFalse ( empty ( $output ), "It should show something from a POST" );
	}
	
	/**
	 * @runInSeparateProcess
	 */
	public function testCallRunFromGet() {
		ob_start();
		
		DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB($dbName = 'botspacetest', $configPath = 'C:\xampp\myConfig.ini');
		
		$_SERVER['REQUEST_METHOD'] = "GET";
		$_SERVER['HTTP_HOST'] = "localhost";
		
		$_SESSION = array("base" => "ha_labe");
		
		LoginController::run();
		$output = ob_get_clean ();
		$this->assertFalse ( empty ( $output ), "It should show something from a GET" );
	}
}
?>
