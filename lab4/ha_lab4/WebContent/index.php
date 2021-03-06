<?php
	// Use an output buffer
	ob_start();	
	include("includer.php");
	
	session_start();
	
	$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	
	list($fill, $base, $control, $action, $arguments) =
		explode('/', $url, 5) + array("", "", "", "", null);
	
	$_SESSION['base'] = $base;
	$_SESSION['control'] = $control;
	$_SESSION['action'] = $action;
	$_SESSION['arguments'] = $arguments;
	
	if (!isset($_SESSION['authenticated']))
		$_SESSION['authenticated'] = false;
	
	switch ($control) {
		case "login":
			LoginController::run();
			break;
		case "logout":
			LogoutController::run();
			break;
		case "signup":
			SignupController::run();
			break;
		case "profile":
			ProfileController::run();
			break;
		case "mystery":
			RobotProfileController::run();
			break;
		case "create":
			CreateView::show();
			break;
		case "show":
			ShowView::show();
			break;
		case "user":
			UserController::run();
			break;
		case "userdata":
			UserDataController::run();
			break;
		case "skill":
			SkillController::run();
			break;
		case "skillassoc":
			SkillAssocController::run();
			break;
		case "robotdata":
			RobotDataController::run();
			break;
		default:
			HomeView::show(array(null));
	};
	
	ob_end_flush();
?>