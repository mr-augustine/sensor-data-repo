<?php
class MasterView {
	private static $STD_FOOTER = '
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
	</footer>';
	
	public static function showHeader($title) {
		if (is_null($title))
			$title = "";	
?>	 	
     <!DOCTYPE html>
     <html>
     <head>
     <title><?php echo $title; ?></title>
     </head>
     <body>
<?php  
     }

	public static function showFooter($footer) {
		if (is_null($footer))
			echo self::$STD_FOOTER;	
?>	 	
    </body>
    </html>
 <?php  
     }
}
?>