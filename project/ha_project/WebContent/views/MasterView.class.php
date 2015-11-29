<?php
class MasterView {
	
	public static function showHeader() {
		echo '<!DOCTYPE html lang="en"><html><head>';
		echo '<meta charset="utf-8">';
		echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">';
		echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">';
		echo '<link rel="stylesheet" href="css\site.css">';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>';
		echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>';
		
		$styles = (array_key_exists('styles', $_SESSION)) ? $_SESSION['styles'] : array();
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		
		foreach ($styles as $style)
			echo '<link href="/'.$base.'/css/'.$style. '" rel="stylesheet">';
		
		$title = (array_key_exists('headertitle', $_SESSION)) ? $_SESSION['headertitle'] : "";
		
		echo "<title>$title</title>\n";
		echo "</head>\n\t<body>\n";
	}
	
	public static function showNavBar() {
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		$authenticatedUser = (array_key_exists('authenticatedUser', $_SESSION)) ?
			$_SESSION['authenticatedUser'] : null;
		
		echo '<nav class="navbar navbar-inverse navbar-fixed-top">';
		echo '<div class="container-fluid">';
		echo '<div class="navbar-header">';
		
		// Hamburger
		echo '<button type="button" class="navbar-toggle collapsed"';
		echo 'data-toggle="collapse" data-target="#navbar"';
		echo 'aria-expanded="false" aria-controls="navbar">';
		echo '<span class="icon-bar"></span>';
		echo '<span class="icon-bar"></span>';
		echo '<span class="icon-bar"></span>';
		echo '</button>';
		
		echo '<a class="navbar-brand" href="/'.$base.'/">Sensor Data Repo</a>';
		echo '</div>'; // navbar-header
		
		echo '<div id="navbar" class="navbar-collapse collapse">';
		
		// Show a link to the Upload Data page and a logout button
		if (!is_null($authenticatedUser)) {
			echo '<ul class="nav navbar-nav">';
			echo '<li class="active"><a href="/'.$base.'/profile/show/'.
					$authenticatedUser->getUserId().'">Profile</a></li>';
			echo '</ul>';
			
			echo '<form class="navbar-form navbar-right"
					method="post" action="/'.$base.'/logout">';
			echo '<div class="form-group">';
			echo '<span class="label label-default">Hey '.
					$authenticatedUser->getUsername().'</span>&nbsp; &nbsp;';
			echo '</div>';
			echo '<button type="submit" class="btn btn-success">Log out</button>';
			echo '</form>';
		}
		
		// Show the login and signup buttons
		else {
			echo '<form class="navbar-form navbar-right"
						method="get" action="/'.$base.'/login">';
			echo '<button type="submit" class="btn btn-success">Log in</button>';
			echo '&nbsp &nbsp';
			echo '<a class="btn btn-primary" href="/'.$base.'/signup" role="button">Sign up</a></p>';
			echo '</form>';
		}
		
		echo '</div>';
		echo '</div>';
		echo '</nav>';
	}
	
	public static function showFooter() {
		$footer = (array_key_exists('footertitle', $_SESSION)) ?
			$_SESSION['footertitle'] : "";
		
		echo $footer;
		
		$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		
		echo '<hr>';
		echo '<footer>';
		
		echo '<ul>';
		echo '<li>&copy; 2015 Sensor Data Repo</li>';
		echo '<li><a href="/'.$base.'/terms.html">Terms</a></li>';
		echo '<li><a href="/'.$base.'/privacy.html">Privacy</a></li>';
		echo '<li><a href="/'.$base.'/help.html">Help</a></li>';
		echo '</ul>';
		
		// TODO: Perhaps a mini logo should go here
		
		// Not valid for this project iteration
// 		echo '<ul class="footer-right">';
// 		echo '<li><a href="/'.$base.'/tests.html">TESTS</a></li>';
// 		echo '<li><a href="/'.$base.'/create">CREATE</a></li>';
// 		echo '<li><a href="/'.$base.'/show">SHOW</a></li>';
// 		echo '</ul>';
		
		echo '</footer>';
	}
	
	public static function showPageEnd() {
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>';
		echo '<script src="../../dist/js/bootstrap.min.js"></script>';
		echo '<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>';
		echo '</body></html>';
	}
}
?>