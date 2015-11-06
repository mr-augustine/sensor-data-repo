<?php  
class ProfileView {
	
	public static function show() { 
		$userData = (array_key_exists('userData', $_SESSION)) ? $_SESSION['userData'] : null;
		if (!is_null($userData))
			$userName = $userData->getUserName();
		
		$name = $userName."'s ";
		$_SESSION['headertitle'] = ($name != "'s ") ? $name." profile" : "Profile";
		
		MasterView::showHeader();
		MasterView::showNavBar();
		ProfileView::showDetails();
		MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	
	public static function showDetails() {
		
	}
//     <!DOCTYPE html>
// 	<html>
// 	<head>
// 	<meta charset="utf-8">
// 	<meta name= "keywords" content="Botspace Human profile">
// 	<meta name="description" content = "Profile for Human Botspace Member">
// 	<title>Botspace Human Profile</title>
// 	</head>
// 	<body>
	
// 	<a href="home">HOME</a><br><br>
	
// 	Here's the user!<br><br>
// 	<?php echo $_SESSION['userData'];
	
	
// 	<footer>
// 		<hr>
	
// 		<nav>
// 		<a href="">Tour</a> |
// 		<a href="">About</a> |
// 		<a href="">Help</a> |
// 		<a href="">Terms</a> |
// 		<a href="">Privacy</a>
// 		</nav>
// 	</footer>
// 	</body>
// 	</html>

}
?>