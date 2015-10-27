<?php
class SkillAssocView {
	
	public static function show() {
		$_SESSION['headertitle'] = "Skill Associations";
		MasterView::showHeader();
		SkillAssocView::showDetails();
		MasterView::showFooter();
	}
	
	public static function showAll() {
		if (array_key_exists('headertitle', $_SESSION)) {
			MasterView::showHeader();
		}
		
		$skillAssocs = (array_key_exists('skillAssocs', $_SESSION)) ? $_SESSION['skillAssocs'] : array();
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		
		echo "<h1>botspace skill associations list</h1>";
		echo "<table>";
		echo "<thead>";
		echo "<tr><th>skillAssocId</th><th>userDataId</th><th>skillId</th><th>Show</th><th>Update</th></tr>";
		echo "</thead>";
		
		echo "<tbody>";
		foreach ($skillAssocs as $skillAssoc) {
			echo '<tr>';
			echo '<td>'.$skillAssoc->getSkillAssocId().'</td>';
			echo '<td>'.$skillAssoc->getUserDataId().'</td>';
			echo '<td>'.$skillAssoc->getSkillId().'</td>';
			echo '<td><a href="/'.$base.'/skillassoc/show/'.$skillAssoc->getSkillAssocId().'">Show</a></td>';
			echo '<td><a href="/'.$base.'/skillassoc/update/'.$skillAssoc->getSkillAssocId().'">Update</a></td>';
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