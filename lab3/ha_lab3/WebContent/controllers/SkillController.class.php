<?php
class SkillController {
	
	public static function run() {
		$action = (array_key_exists('action', $_SESSION)) ? $_SESSION['action'] : "";
		$arguments = (array_key_exists('arguments', $_SESSION)) ? $_SESSION['arguments'] : "";
		
		switch ($action) {
			case "create":
				self::newSkill();
				break;
			case "show":
				if ($arguments == 'all') {
					$_SESSION['skills'] = SkillsDB::getSkillsBy();
					$_SESSION['headertitle'] = "botspace skills";
					
					SkillView::showAll();
				} else {
					$skill = SkillsDB::getSkillsBy('skillId', $arguments);
					$_SESSION['skill'] = $skill[0];
					self::show();
				}
				break;
			case "update":
				echo "Update";
				self::updateUser();
				break;
			default:
		}
	}
	
	public static function show() {
		
	}
	
	public static function newSkill() {
		// Are we there yet?
	}
	
	public static function updateSkill() {
		// Do you really want to update a Skill?
	}
}

?>