<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\SkillAssocs.class.php';

class SkillAssocsTest extends PHPUnit_Framework_TestCase {
	
	public function testValidSkillAssocsCreate() {
		$validSkillId = 11;
		$validUserDataId = 3;
		$s1 = new SkillAssocs($validUserDataId, $validSkillId);
		
		$this->assertTrue(is_a($s1, 'SkillAssocs') && $s1->getErrorCount() == 0, 
				'It should create a valid SkillAssocs object when valid input is provided');
	}
	
	public function testInvalidSkillIdSkillAssocsCreate() {
		$invalidSkillId = -11;
		$validUserDataId = 3;
		$s1 = new SkillAssocs($validUserDataId, $invalidSkillId);
		
		$this->assertTrue(!empty($s1->getError('skillId')) &&
				(strcmp(Messages::getError('SKILL_ID_INVALID'), $s1->getError('skillId')) == 0), 
				'It should have a skillId error if the skillId is invalid');
	}
	
	public function testInvalidUserDataIdSkillAssocsCreate() {
		$validSkillId = 11;
		$invalidUserDataId = -3;
		$s1 = new SkillAssocs($invalidUserDataId, $validSkillId);
		
		$this->assertTrue(!empty($s1->getError('userDataId')) &&
				(strcmp(Messages::getError('USER_DATA_ID_INVALID'), $s1->getError('userDataId')) == 0),
				'It should have a userDataId error if the userDataId is invalid');
	}
}
?>