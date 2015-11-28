<?php
class MeasurementView {
	
	public static function show() {
		$_SESSION['headertitle'] = 'Measurement Summary';
		$_SESSION['styles'] = array('site.css');
		
		MasterView::showHeader();
		MasterView::showNavBar();
		self::showDetails();
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showNew() {
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		$_SESSION['headertitle'] = "Sensor Data Repo | Create a Measurement";
		$_SESSION['styles'] = array('site.css');
		MasterView::showHeader();
		MasterView::showNavBar();
		
		echo '<br><br>'."\n";
		echo '<p>This feature is not implemented yet!</p>';
	}
	
	public static function showUpdate() {
		
	}
}
?>