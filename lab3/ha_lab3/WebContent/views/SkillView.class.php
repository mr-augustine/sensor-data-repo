<?php
class SkillView {
	
	public static function show() {
		$_SESSION['headertitle'] = "Skill details";
		MasterView::showHeader();
		SkillView::showDetails();
		MasterView::showFooter();
	}
	
	public static function showAll() {
		if (array_key_exists('headertitle', $_SESSION)) {
			MasterView::showHeader();
		}
		
		$skills = (array_key_exists('skills', $_SESSION)) ? $_SESSION['skills'] : array();
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		
		echo "<h1>botspace skills list</h1>";
		echo "<table>";
		echo "<thead>";
		echo "<tr><th>skillId</th><th>skill_name</th><th>Show</th><th>Update</th></tr>";
		echo "</thead>";
		
		echo "<tbody>";
		foreach ($skills as $skill) {
			echo '<tr>';
			echo '<td>'.$skill->getSkillId().'</td>';
			echo '<td>'.$skill->getSkillName().'</td>';
			echo '<td><a href="/'.$base.'/skill/show/'.$skill->getSkillId().'">Show</a></td>';
			echo '<td><a href="/'.$base.'/skill/update/'.$skill->getSkillId().'">Update</a></td>';
			echo '</tr>';
		}
		echo "</tbody>";
		echo "</table>";
		
		MasterView::showFooter();
	}
	
	public static function showDetails() {
	
	}
	
	public static function showNew() {
	
	}
	
	public static function showUpdate() {
	
	}
}

?>