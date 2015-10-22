<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Database.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\SkillAssocs.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\SkillAssocsDB.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';

class SkillAssocsDBTest extends PHPUnit_Framework_TestCase {
	
	public function testGetAllSkillAssocs() {
		$myDB = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		$skillAssocs = SkillAssocsDB::getSkillAssocsBy();

		$this->assertEquals(3, count($skillAssocs),
				'It should fetch all of the skill associations in the test database');
	}
	
	public function testValidSkillAssocsCreate() {
		$myDB = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		
		$validSkillId = 3;
		$validUserDataId = 1;
		$s1 = new SkillAssocs($validUserDataId, $validSkillId);
		
		$beforeCount = count(SkillAssocsDB::getSkillAssocsBy());
		$newSkillAssoc = SkillAssocsDB::addSkillAssoc($s1);
		
		$this->assertEquals(0, $s1->getErrorCount(),
				'The inserted skill association should have no errors');
		
		$afterCount = count(SkillAssocsDB::getSkillAssocsBy());
		$this->assertEquals($afterCount, $beforeCount + 1,
				'The database should have one more skill association entry after insertion');
	}
	
	public function testInvalidSkillAssocsCreate() {
		$myDB = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		
		$invalidSkillId = 0;
		$validUserDataId = 1;
		$s1 = new SkillAssocs($validUserDataId, $invalidSkillId);
		
		$beforeCount = count(SkillAssocsDB::getSkillAssocsBy());
		$newSkillAssoc = SkillAssocsDB::addSkillAssoc($s1);
		
		$this->assertGreaterThan(0, $newSkillAssoc->getErrorCount(),
				'The skill association should return with an error');
		
		$afterCount = count(SkillAssocsDB::getSkillAssocsBy());
		$this->assertEquals($afterCount, $beforeCount,
				'The database should have no additional skill associations after insertion');
	}
	
	public function testGetSkillAssocsBySkillAssocId() {
		$myDB = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		$testSkillAssocId = 2;
		$skillAssocs = SkillAssocsDB::getSkillAssocsBy('skillAssocId', $testSkillAssocId);
		
		$this->assertEquals(count($skillAssocs), 1,
				'The database should return exactly one SkillAssoc');
		
		$skillAssoc = $skillAssocs[0];
		
		$this->assertEquals($skillAssoc->getSkillAssocId(), $testSkillAssocId, 
				'The database should have exactly one SkillAssoc with the provided skillAssocId');
	}

	public function testGetSkillAssocsBySkillId() {
		$myDB = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		$testSkillId = 8;
		$skillAssocs = SkillAssocsDB::getSkillAssocsBy('skillId', $testSkillId);
		
		foreach ($skillAssocs as $skillAssoc) {
			$this->assertEquals($skillAssoc->getSkillId(), $testSkillId,
					'All returned SkillAssocs should have the specified skillId');
		}
	}
	
	public function testGetSkillAssocsByUserDataId() {
		$myDB = DBMaker::create('botspacetest');
		Database::clearDB();
		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
		$testUserDataId = 3;
		$skillAssocs = SkillAssocsDB::getSkillAssocsBy('userDataId', $testUserDataId);
		
		foreach ($skillAssocs as $skillAssoc) {
			$this->assertEquals($skillAssoc->getUserDataId(), $testUserDataId,
					'All returned SkillAssocs should have the specified userDataId');
		}
	}
	
	// The update feature probably should not exist for SkillAssocs
// 	public function testUpdateSkillAssoc() {
// 		$myDB = DBMaker::create('botspacetest');
// 		Database::clearDB();
// 		$db = Database::getDB('botspacetest', 'C:\xampp\myConfig.ini');
// 		$testSkillAssocId = 1;
// 		$testSkillId = 7;
// 		$skillAssocs = SkillAssocsDB::getSkillAssocsBy('skillAssocId', $testSkillAssocId);
// 		$skillAssoc = $skillAssocs[0];
		
// 		$params = $skillAssoc->getParameters();
// 		$this->assertEquals($skillAssoc->getSkillId(), 1,
// 				'Before the update it should have skillId == 1');
		
// 		$params['skillId'] = $testSkillId;
// 		$newSkillAssoc = new SkillAssocs($params);
// 		$newSkillAssoc->setSkillAssocId($testSkillAssocId);
		
// 		$skillAssoc = SkillAssocsDB::updateSkillAssoc($newSkillAssoc);
		
// 		$this->assertEquals($skillAssoc->getSkillId(), $testSkillId,
// 				'After the update it should have the new skillId');
// 		$this->assertTrue(empty($skillAssoc->getErrors()),
// 				'The updated skill association should have no errors');
// 	}
}
?>