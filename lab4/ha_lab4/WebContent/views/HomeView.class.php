<?php
class HomeView {

  	public static function show() {  
  		$_SESSION['headertitle'] = "botspace";
  		$_SESSION['styles'] = array('jumbotron.css', 'site.css');
  		
  		MasterView::showHeader();
  		MasterView::showNavBar();
  		HomeView::showDetails();
  		MasterView::showFooter();
  		MasterView::showPageEnd();
  	}
  	
  	public static function showDetails() {
  		$base = $_SESSION['base'];
  		$_SESSION['footertitle'] = 'test username/pass = mwatney@mars.com/aaaaaaaa';
  		
  		echo '<div class="jumbotron">';
  		echo '<div class="container">';

  		echo '<img class="logo" src="/'.$base.'/resources/images/botspace-badge.png" alt="botspace badge">';
  		echo '<br><br>';
  		echo '<p><strong>Botspace</strong> is the free, simple, and structured way to share your robot projects with a community of peers.</p>';
  		echo '<p>Talk to other hobbyists about their creations, or ask for help with your own. Botspace is a community to help you make your robots awesome!</p>';
  		echo '</div>';
  		echo '</div>';
  		
  		echo '<aside><section>';
  		echo '<h2>Robot Showcase</h2>';
  		echo '<ul>';
  		echo '<li><a href="">Robot 1</a></li>';
  		echo '<li><a href="">Robot 2</a></li>';
  		echo '<li><a href="">Robot 3</a></li>';
  		echo '</ul></section>';
  		echo '<section>';
  		echo '<h2>Newest Members</h2>';
  		echo '<ul>';
  		echo '<li><a href="">Human 1</a></li>';
  		echo '<li><a href="">Human 2</a></li>';
  		echo '<li><a href="">Human 3</a></li>';
  		echo '</ul></section>';
  		echo '<aside>';
  	}
  	
  	public static function userLoggedIn() {
  		return (array_key_exists("authenticatedUser", $_SESSION) && !is_null($_SESSION['authenticatedUser']));
  	}
}
?>