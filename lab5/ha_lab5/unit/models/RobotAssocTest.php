<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\RobotAssoc.class.php';

class RobotAssocTest extends PHPUnit_Framework_TestCase {
	
	public function testValidRobotAssocCreate() {
		$validRobotId = 1;
		$validCreatorId = 20;
		$s1 = new RobotAssoc($validRobotId, $validCreatorId);
		
		$this->assertTrue(is_a($s1, 'RobotAssoc') && $s1->getErrorCount() == 0,
				'It should create a valid RobotAssoc object when valid input is provided');
	}
	
	public function testInvalidRobotIdRobotAssocCreate() {
		$invalidRobotId = -1;
		$validCreatorId = 20;
		$s1 = new RobotAssoc($invalidRobotId, $validCreatorId);
		
		$this->assertTrue(!empty($s1->getError('robotId')) &&
				(strcmp(Messages::getError('ROBOT_ID_INVALID'), $s1->getError('robotId')) == 0),
				'It should have a robotId error if the robotId is invalid');
	}
	
	public function testInvalidCreatorIdRobotAssocCreate() {
		$validRobotId = 1;
		$invalidCreatorId = -20;
		$s1 = new RobotAssoc($validRobotId, $invalidCreatorId);
		
		$this->assertTrue(!empty($s1->getError('creatorId')) &&
				(strcmp(Messages::getError('CREATOR_ID_INVALID'), $s1->getError('creatorId')) == 0),
				'It should have a creatorId error if the creatorId is invalid');
	}
}