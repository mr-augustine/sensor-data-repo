<?php
class HomeView {
  public static function show() {  
		
?>
	<!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8">
	<title>botspace</title>
	</head>
	
	<body>
	<img src="resources/images/botspace-logo.png" alt="bostpace logo" style="width:627px;height:126px;">
	
		<p>Botspace is the free, simple, and structured way to share your robot projects with a community of peers.</p>
		<p>Talk to other hobbyists about their creations, or ask for help with your own. Botspace is a community to help you make your robots awesome!</p>
	
		<form style="display: inline" action="signup" method="get">
	  		<button>Sign up - It's free.</button><br><br>
		</form>
		<form style="display: inline" action="login">
	  		<button>Log in ....</button><br><br>
		</form>
		
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
		
	<footer>
		<hr>
	
		<nav>
		<a href="">Tour</a> |
		<a href="">About</a> |
		<a href="">Help</a> |
		<a href="">Terms</a> |
		<a href="">Privacy</a>
		 | <a href="tests.html">TESTS</a>
		</nav>
		
		<p>Copyright 2015</p>
	</footer>
	</body>
	</html>
<?php
  }
}
?>