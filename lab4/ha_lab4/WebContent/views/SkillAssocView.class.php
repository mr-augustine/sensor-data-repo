<?php
class SkillAssocView {
	
	public static function show() {
		$_SESSION['headertitle'] = "Skill Associations";
		$_SESSION['styles'] = array('site.css');
		
		MasterView::showHeader();
		MasterView::showNavBar();
		SkillAssocView::showDetails();
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showAll() {
		$_SESSION['styles'] = array('site.css');
		
		if (array_key_exists('headertitle', $_SESSION)) {
			MasterView::showHeader();
		}
		MasterView::showNavBar();
		
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