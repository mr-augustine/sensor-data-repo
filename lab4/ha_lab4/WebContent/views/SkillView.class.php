<?php
class SkillView {
	
	public static function show() {
		$_SESSION['headertitle'] = "Skill details";
		$_SESSION['styles'] = array('site.css');
		
		MasterView::showHeader();
		MasterView::showNavBar();
		SkillView::showDetails();
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showAll() {
		$_SESSION['styles'] = array('site.css');
		
		if (array_key_exists('headertitle', $_SESSION)) {
			MasterView::showHeader();
		}
		MasterView::showNavBar();
		
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
		MasterView::showPageEnd();
	}
	
	public static function showDetails() {
	
	}
	
	public static function showNew() {
	
	}
	
	public static function showUpdate() {
	
	}
}

?>