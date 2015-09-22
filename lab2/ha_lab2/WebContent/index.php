<?php
	include("includer.php");   
	$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	//echo "URL: $url <br>";
	$urlPieces = split("/", $url);
	
	print_r($urlPieces);
	if (count($urlPieces) < 2)
		$control = "none";
	else 
		$control = $urlPieces[2];
	
	switch ($control) {
		case "login":
			LoginController::run();
			break;
		default:
			HomeView::show();
	};
?>

Hello