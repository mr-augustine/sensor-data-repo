<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Skill.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\SkillsDB.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';

class SkillsDBTest extends PHPUnit_Framework_TestCase {
	
	public function testGetAllSkills() {
		$myDB = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		$skills = SkillsDB::getSkillsBy();
		
		$this->assertEquals(12, count($skills),
				'It should fetch all of the reviews in the test database');
	}
	
	public function testGetSkillsBySkillName() {
		$myDB = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		$skills = SkillsDB::getSkillsBy('skill_name', 'GPS');
		
		$this->assertEquals(count($skills), 1,
				'The database should return exactly one Skill');
		
		$skill = $skills[0];
		
		$this->assertTrue(strcmp($skill->getSkillName(), 'GPS') == 0,
				'The database should have exactly one Skill with the provided name');
	}
	
	public function testGetSkillsBySkillId() {
		$myDB = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		$skills = SkillsDB::getSkillsBy('skillId', 9);
		
		$this->assertEquals(count($skills), 1,
				'The database should return exactly on Skill');
		
		$skill = $skills[0];
		
		$this->assertEquals(9, $skill->getSkillId(),
				'The database should have exactly one Skill with the provided skillId');
	}
}
?>