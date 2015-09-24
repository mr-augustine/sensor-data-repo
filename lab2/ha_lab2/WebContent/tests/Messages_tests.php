<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>UserData tests</h1>

<?php
include_once("../models/Messages.class.php");
?>

<h2>It should set errors from a file</h2>
<?php 

Messages::setErrors("../resources/errors_English.txt");

echo "EMAIL_EMPTY: " .Messages::getError("EMAIL_EMPTY")."<br>";
echo "EMAIL_INVALID: " .Messages::getError("EMAIL_INVALID")."<br>";
echo "USER_NAME_EMPTY: " .Messages::getError("USER_NAME_EMPTY")."<br>";
echo "USER_NAME_TOO_SHORT: " .Messages::getError("USER_NAME_TOO_SHORT")."<br>";
echo "USER_NAME_INVALID: " .Messages::getError("USER_NAME_HAS_INVALID_CHARS")."<br>";

echo (empty(Messages::getError("USER_NAME_TOO_SHORT")))?
      "Failed: it did not set USER_NAME_TOO_SHORT from file":"";
?>

<h2>It should allow reset</h2>
<?php 
Messages::reset();

echo "EMAIL_EMPTY: " .Messages::getError("EMAIL_EMPTY")."<br>";
echo "EMAIL_INVALID: " .Messages::getError("EMAIL_INVALID")."<br>";
echo "USER_NAME_EMPTY: " .Messages::getError("USER_NAME_EMPTY")."<br>";
echo "USER_NAME_TOO_SHORT: " .Messages::getError("USER_NAME_TOO_SHORT")."<br>";
echo "USER_NAME_INVALID: " .Messages::getError("USER_NAME_HAS_INVALID_CHARS")."<br>";

?>

<h2>It should allow change of locale</h2>
<?php 
Messages::$locale = 'German';
Messages::reset();

echo "EMAIL_EMPTY: " .Messages::getError("EMAIL_EMPTY")."<br>";
echo "EMAIL_INVALID: " .Messages::getError("EMAIL_INVALID")."<br>";
echo "USER_NAME_EMPTY: " .Messages::getError("USER_NAME_EMPTY")."<br>";
echo "USER_NAME_TOO_SHORT: " .Messages::getError("USER_NAME_TOO_SHORT")."<br>";
echo "USER_NAME_INVALID: " .Messages::getError("USER_NAME_HAS_INVALID_CHARS")."<br>";

?>
</body>
</html>

