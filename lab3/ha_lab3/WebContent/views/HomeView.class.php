<?php
class HomeView {

  	public static function show($user) {  
  		MasterView::showHeader("botspace");
  		HomeView::showDetails($user);
  		MasterView::showFooter(null);
  	}
  	
  	public static function showDetails($user) {
?>

	<img src="resources/images/botspace-logo.png" alt="botspace logo" style="width:627px;height:126px;">
	
	<?php 	if (!is_null($user) && array_key_exists("user_name", $user))
				HomeView::showHobbyistGreeting($user);
			else
				HomeView::showGuestGreeting();

	?>
	
		<aside>
		<section>
		<h2>Robot Showcase</h2>
		<ul>
			<li><a href="">Robot 1</a></li>
			<li><a href="">Robot 2</a></li>
			<li><a href="">Robot 3</a></li>
		</ul>
		</section>
		
		<section>
		<h2>Hobbyist Showcase</h2>
		<ul>
			<li><a href="">Human 1</a></li>
			<li><a href="">Human 2</a></li>
			<li><a href="">Human 3</a></li>
		</ul>
		</section>
		</aside>
		

<?php
  	}

  	public static function showHobbyistGreeting($user) {
  		echo "<br><br>Welcome, " . $user["user_name"] . "!<br><br>";
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
  	
}
?>