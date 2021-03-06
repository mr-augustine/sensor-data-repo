<?php
	// Use an output buffer
	ob_start();	
	include("includer.php");
	//session_start();
	$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	
	// $ctrl_act_arg === Control, Action, Arguments
	list($fill, $base, $ctrl_act_args) =
		explode('/', $url, 3) + array("", "", "");
	list($control, $action, $arguments) =
		explode('/', $ctrl_act_args, 3) + array("", "", "");
	
	$_SESSION['base'] = $base;
	$_SESSION['control'] = $control;
	$_SESSION['action'] = $action;
	$_SESSION['arguments'] = $arguments;
	
	//print_r("base=".$base.",control=".$control.",action=".$action.",args=".$arguments);
	
	switch ($control) {
		case "login":
			LoginController::run();
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