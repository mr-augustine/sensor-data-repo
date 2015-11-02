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
		$title = (array_key_exists('headertitle', $_SESSION))?
			$_SESSION['headertitle']:"";
		
		echo "<!DOCTYPE html>\n";
		echo "<html>\n";
		echo "<head>\n";
		echo "<title>$title</title>\n";
		echo "</head>\n\t<body>\n";
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