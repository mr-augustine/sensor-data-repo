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
require_once dirname (__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';

class SignupControllerTest extends PHPUnit_Framework_TestCase {
	/**
	 * @runInSeparateProcess
	 */
	public function testCallRunFromPost() {
		
	}
	
	/**
	 * @runInSeparateProcess
	 */
	public function testCallRunFromGet() {
	
	}
}
?>