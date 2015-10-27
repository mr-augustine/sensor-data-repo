<?php
class SkillAssocController {
	
	public static function run() {
		$action = (array_key_exists('action', $_SESSION))?$_SESSION['action']:"";
		$arguments = (array_key_exists('arguments', $_SESSION))?$_SESSION['arguments']:"";
		
		switch ($action) {
			case "create":
				self::newSkillAssoc();
				break;
			case "show":
				if ($arguments == 'all') {
					$_SESSION['skillAssocs'] = SkillAssocsDB::getSkillAssocsBy();
					$_SESSION['headertitle'] = "botspace skill associations";
					
					SkillAssocView::showAll();
				} else {
					$skillAssocs = SkillAssocsDB::getSkillAssocsBy('skillAssocId', $arguments);
					$_SESSION['skillAssoc'] = $skillAssocs[0];
					self::show();
				}
				break;
			case "update":
				echo "Update";
				self::updateSkillAssoc();
				break;
			default:
		}
	}
}

?>