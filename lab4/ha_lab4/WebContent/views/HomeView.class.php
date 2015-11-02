<?php
class HomeView {

  	public static function show() {  
  		$_SESSION['headertitle'] = "botspace";
  		MasterView::showHeader();
  		HomeView::showDetails();
  		MasterView::showFooter();
  	}
  	
  	public static function showDetails() {
  		$base = $_SESSION['base'];
  		
  		echo '<img src="/'.$base.'/resources/images/botspace-logo.png" alt="botspace logo" style="width:627px;height:126px;">';
		
  		if (HomeView::userLoggedIn())
  			HomeView::showHobbyistGreeting($_SESSION['user']);
  		else 
  			HomeView::showGuestGreeting();
  		
  		echo '<aside><section>';
  		echo '<h2>Robot Showcase</h2>';
  		echo '<ul>';
  		echo '<li><a href="">Robot 1</a></li>';
  		echo '<li><a href="">Robot 2</a></li>';
  		echo '<li><a href="">Robot 3</a></li>';
  		echo '</ul></section>';
  		echo '<section>';
  		echo '<h2>Hobbyist Showcase</h2>';
  		echo '<ul>';
  		echo '<li><a href="">Human 1</a></li>';
  		echo '<li><a href="">Human 2</a></li>';
  		echo '<li><a href="">Human 3</a></li>';
  		echo '</ul></section>';
  		echo '<aside>';
  	}

  	// Assumes $_SESSION was already checked for a valid user
  	public static function showHobbyistGreeting($user) {
  		//print_r($user);
  		echo "<br><br>Welcome, " . $user->getEmail() . "!<br><br>";
  	}
  	
  	public static function showGuestGreeting() {
  		$guestGreeting = <<<GREETING
		<p>Botspace is the free, simple, and structured way to share your robot projects with a community of peers.</p>
		<p>Talk to other hobbyists about their creations, or ask for help with your own. Botspace is a community to help you make your robots awesome!</p>
		
		<form style="display: inline" action="signup" method="get">
	  		<button>Sign up - It's free.</button><br><br>
		</form>
		<form style="display: inline" action="login">
	  		<button>Log in ....</button><br><br>
		</form>
GREETING;
  		
  		echo $guestGreeting;
  	}
  	
  	public static function userLoggedIn() {
  		return (array_key_exists("user", $_SESSION) && !is_null($_SESSION['user']));
  	}
}
?>