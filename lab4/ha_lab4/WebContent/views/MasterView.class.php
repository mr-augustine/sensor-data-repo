<?php
class MasterView {

	private static $STD_FOOTER = <<<EOT
	<footer>
		<hr>
	
		<nav>
		<a href="">Tour</a> |
		<a href="">About</a> |
		<a href="">Help</a> |
		<a href="">Terms</a> |
		<a href="">Privacy</a>
		 | <a href="tests.html">TESTS</a>
		 | <a href="create">CREATE</a>
		 | <a href="show">SHOW</a>
		</nav>
		
		<p>Copyright 2015</p>
	</footer>
EOT;
// The HEREDOC terminator must not be indented
// TODO Can't use variables within HEREDOC for initializing class properties
	
	public static function showHeader() {
		echo '<!DOCTYPE html lang="en"><html><head>';
		echo '<meta charset="utf-8">';
		echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">';
		echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">';
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
		
		if (!is_null($authenticatedUser)) {
			$authenticatedUserId = $authenticatedUser->getUserId();
			$userDataArray = UserDataDB::getUserDataBy('userId', $authenticatedUserId);
			$authenticatedUserData = $userDataArray[0];

			if (!is_null($userDataArray[0]))
				$_SESSION['authenticatedUserData'] = $authenticatedUserData;
		}
		
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
		
		echo '<a class="navbar-brand" href="/'.$base.'/">botspace</a>';
		echo '</div>'; // navbar-header
		
		echo '<div id="navbar" class="navbar-collapse collapse">';
		
		// Show a link to the logged-in user's profile and a logout button
		if (!is_null($authenticatedUser)) {
			
			echo '<ul class="nav navbar-nav">';
			echo '<li class="active"><a href="/'.$base.'/user/show/'.
					$authenticatedUserId.'">Profile</a></li>';
			echo '</ul>';
			
			echo '<form class="navbar-form navbar-right"
					method="post" action="/'.$base.'/logout">';
			echo '<div class="form-group">';
			echo '<span class="label label-default">Hey '.
					$authenticatedUserData->getUserName().'</span>&nbsp; &nbsp;';
			echo '</div>';
			echo '<button type="submit" class="btn btn-success">Log out</button>';
			echo '</form>';
		} 
		
		// Show the login and signup buttons
		else {
			echo '<form class="navbar-form navbar-right"
						method="post" action="/'.$base.'/login">';
			//echo '<div class="form-group">';
			echo '<button type="submit" class="btn btn-success">Log in</button>';
			//echo '</div>';
			echo '&nbsp &nbsp';
			//echo '<div class="form-group">';
			echo '<a class="btn btn-primary" href="/'.$base.'/signup" role="button">Sign up</a></p>';
			//echo '</div>';
			echo '</form>';
		}
		
		
		//echo '</ul>'; //navbar-nav
		echo '</div>'; // navbar-collapse collapse
		echo '</div>'; // container-fluid
		echo '</nav>';
	}

	public static function showFooter() {
		$footer = (array_key_exists('footertitle', $_SESSION))?
			$_SESSION['footertitle']:"";
		echo $footer;
		echo '<footer>'."\n";
		echo MasterView::$STD_FOOTER."\n";
		echo "\t</body>\n</html>";	
     }
}
?>