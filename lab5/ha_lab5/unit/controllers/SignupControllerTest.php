<?php
require_once dirname (__FILE__).'\..\..\WebContent\controllers\SignupController.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\models\User.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\models\UsersDB.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\views\HomeView.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\views\LoginView.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\views\MasterView.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\views\ProfileView.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\views\SignupView.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\views\UserDataView.class.php';
require_once dirname (__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';

class SignupControllerTest extends PHPUnit_Framework_TestCase {
	/**
	 * @runInSeparateProcess
	 */
	public function testCallRunFromPost() {
		DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB($dbName = 'botspacetest', $configPath = 'C:\xampp\myConfig.ini');
		
		$_SERVER['REQUEST_METHOD'] = "POST";
		$_SERVER['HTTP_HOST'] = "localhost";
		$_POST = array("email" => "thomas.light@rit.jp", 
			"password" => "99999999", 
			"user_name" => "dr-light",
			"skill_level" => "expert", 
			"skill_areas" => array("system-design", "programming", "machining", "soldering",
			"wiring", "circuit-design", "power-systems", "computer-vision", "ultrasonic",
			"infrared", "gps", "compass"),
			"profile_pic" => "nopicture.jpg",
			"started_hobby" => "1987-06-15",
			"fav_color" => "#0080ff",
			"url" => "http://www.rit.jp",
			"phone" => "123-456-7890"
		);
		
		$_SESSION = array("base" => "ha_lab4");
		
		SignupController::run();
		$output = ob_get_clean();
		$this->assertFalse(empty($output), "It should show something from a POST");
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
		
		$_SESSION = array("base" => "ha_lab3");
		
		SignupController::run();
		$output = ob_get_clean();
		$this->assertFalse(empty($output), "It should show something from a GET");
	}
}
?>