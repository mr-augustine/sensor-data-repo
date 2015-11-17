<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\RobotData.class.php';

class RobotDataTest extends PHPUnit_Framework_TestCase {
	
	public function testValidRobotDataCreate() {
		$validTest = array("robot_name" => "TARS", "creators" => array("2", "7"),
				"status" => "in-development");
		$s1 = new RobotData($validTest);
		
		$this->assertTrue(is_a($s1, 'RobotData') && $s1->getErrorCount() == 0,
				'It should create a valid RobotData object when valid input is provided');
	}
	
	public function testInvalidCreatorRobotDataCreate() {
		$validRobotName = "TARS";
		$invalidCreators = array("-2");
		$validStatus = "in-development";
		$s1 = new RobotData(array("robot_name" => $validRobotName, 
				"creators" => $invalidCreators, "status" => $validStatus));
		
		$this->assertTrue(!empty($s1->getError('creator')) &&
				(strcmp(Messages::getError('ROBOT_CREATOR_INVALID'), $s1->getError('creator')) == 0),
				'It should have a creator error if the creator id is invalid');
	}
}
?>