<?php
class SignupController {

	public static function run() {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			simpleEcho.php;
// 			$user = new User($_POST);
// 			if ($user->getErrorCount() == 0)
// 				HomeView::show();
// 			else
// 				SignupView::show($user);
		} else  // Initial link
			SignupView::show(null);
	}
}
?>