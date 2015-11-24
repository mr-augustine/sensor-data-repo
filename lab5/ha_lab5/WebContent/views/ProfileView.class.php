<?php
class ProfileView {
	
	public static function show() {
		$_SESSION['headertitle'] = "UserData details";
		$_SESSION['styles'] = array('site.css');
		
		MasterView::showHeader();
		MasterView::showNavBar();
		UserDataView::showDetails();
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showDetails() {
		$user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
		$datasets = (array_key_exists('datasets', $_SESSION)) ? $_SESSION['datasets'] : array();
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		
		if (!is_null($user)) {
			echo '<h1>Profile for '.$user->getUsername().'</h1>';
			
			if (self::CurrentUserCanEditProfileWithUserDataId($user->getUserId())) {
				echo '<p>';
				echo '<a class="btn btn-primary" ';
				echo 'role="button" ';
				echo 'href="/'.$base.'/user/update/'.$user->getUserId().'" ';
				echo '>Edit Account</a>';
				echo '</p>';
			}
			
			echo '<section>';
			echo '<fieldset><legend>Summary Info</legend>';
			echo 'Username:<tab>'.$user->getUsername().'<br><br>'."\n";
			
			echo 'Datasets:<p>';
			if (count($datasets) > 0) {
				// Show an unordered list of all the user's datasets
				echo '<ul>';
				
				foreach ($datasets as $dataset) {
					echo '<li><a href="/'.$base.'/dataset/show/'.$dataset->getDatasetId().
						'">'.$dataset->getDatasetName().'</a></li>';	
				}
			} else {
				echo 'No datasets created yet';
			}
			echo '</p>';
			
			echo '</fieldset><br>';
			echo '</section>';
		} else {
			echo '<p>Unknown user</p>';
		}
	}
	
	public static function CurrentUserCanEditProfileWithUserDataId($id) {
		$canEdit = false;
		
		if (array_key_exists('authenticated', $_SESSION) &&
				$_SESSION['authenticated'] == true &&
				array_key_exists('authenticatedUser', $_SESSION) &&
				!is_null($_SESSION['authenticatedUser'])) {
			
			$authenticatedUser = $_SESSION['authenticatedUser'];
			
			if ($authenticatedUser->getUserId() == $id)
				$canEdit = true;
		}
		
		return $canEdit;
	}
}
?>