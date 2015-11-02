<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Skill.class.php';

class SkillTest extends PHPUnit_Framework_TestCase {
	
	public function testValidSkillCreate() {
		$validTest = array("skill_name" => "computer-vision");
		$s1 = new Skill($validTest);
		
		$this->assertTrue(is_a($s1, 'Skill') && $s1->getErrorCount() == 0,
			'It should create a valid Skill object when valid input is provided');
	}
	
	public function testInvalidSkillName() {
		$invalidTest = array("skill_name" => "compooter-vision");
		$s1 = new Skill($invalidTest);
		
		$this->assertTrue(!empty($s1->getError('skill_name')) && 
			(strcmp(Messages::getError('SKILL_AREA_INVALID'), $s1->getError('skill_name')) == 0),
			'It should have a skill_name error if the name is invalid');
	}
}
?>