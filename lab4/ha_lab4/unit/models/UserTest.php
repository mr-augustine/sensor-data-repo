<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\User.class.php';

class UserTest extends PHPUnit_Framework_TestCase {
	
  public function testValidUserCreate() {
  	$validTest = array("email" => "validemail@email.com", "password" => "validPassword");
  	$s1 = new User($validTest);
  	
    $this->assertTrue(is_a($s1, 'User') && $s1->getErrorCount() == 0, 
    	'It should create a valid User object when valid input is provided');
  }
  
  public function testInvalidEmail() {
  	$invalidTest = array("email" => "invalidEmail@", "password" => "validPassword");
  	$s1 = new User($invalidTest);
  	
  	$this->assertTrue(!empty($s1->getError('email')),
  		'It should have an email error if the email is invalid');
  }
  
  public function testInvalidPassword() {
  	$invalidTest = array("email" => "validemail@gmail.com", "password" => "nope");
  	$s1 = new User($invalidTest);
  	
  	$this->assertTrue(!empty($s1->getError('password')),
  		'It should have a password error if the password is invalid');
  }
}
?>