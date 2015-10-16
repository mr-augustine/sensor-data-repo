<?php
class SignupController {

	public static function run() {
		$user = null;
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			//simpleEcho.php;
			$user = new User($_POST);
			$userData = new UserData($_POST);

			if ($user->getErrorCount() == 0 && $userData->getErrorCount() == 0) {
				$_SESSION['user'] = $user;
				$_SESSION['userData'] = $userData;
				
				ProfileView::show($userData);
			} else
				SignupView::show($user, $userData);
		} else  // Initial link
			SignupView::show(null, null);
	}
}
?>