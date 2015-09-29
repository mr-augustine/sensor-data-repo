<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Messages tests</h1>

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
echo "USER_NAME_HAS_INVALID_CHARS: " .Messages::getError("USER_NAME_HAS_INVALID_CHARS")."<br>";
echo "SKILL_AREA_INVALID: " .Messages::getError("SKILL_AREA_INVALID")."<br>";
echo "SKILL_LEVEL_INVALID: " .Messages::getError("SKILL_LEVEL_INVALID")."<br>";
echo "SKILL_LEVEL_NOT_SET: " .Messages::getError("SKILL_LEVEL_NOT_SET")."<br>";
echo "PASSWORD_EMPTY: " .Messages::getError("PASSWORD_EMPTY")."<br>";
echo "PASSWORD_TOO_SHORT: " .Messages::getError("PASSWORD_TOO_SHORT")."<br>";
echo "PROFILE_PIC_WRONG_TYPE: " .Messages::getError("PROFILE_PIC_WRONG_TYPE")."<br>";
echo "HOBBY_DATE_EMPTY: " .Messages::getError("HOBBY_DATE_EMPTY")."<br>";
echo "HOBBY_DATE_FORMAT_INVALID: " .Messages::getError("HOBBY_DATE_FORMAT_INVALID")."<br>";
echo "HOBBY_DATE_INVALID: " .Messages::getError("HOBBY_DATE_INVALID")."<br>";
echo "FAV_COLOR_EMPTY: " .Messages::getError("FAV_COLOR_EMPTY")."<br>";
echo "FAV_COLOR_INVALID: " .Messages::getError("FAV_COLOR_INVALID")."<br>";
echo "URL_INVALID: " .Messages::getError("URL_INVALID")."<br>";
echo "PHONE_NUMBER_INVALID: " .Messages::getError("PHONE_NUMBER_INVALID")."<br>";


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
echo "USER_NAME_HAS_INVALID_CHARS: " .Messages::getError("USER_NAME_HAS_INVALID_CHARS")."<br>";
echo "SKILL_AREA_INVALID: " .Messages::getError("SKILL_AREA_INVALID")."<br>";
echo "SKILL_LEVEL_INVALID: " .Messages::getError("SKILL_LEVEL_INVALID")."<br>";
echo "SKILL_LEVEL_NOT_SET: " .Messages::getError("SKILL_LEVEL_NOT_SET")."<br>";
echo "PASSWORD_EMPTY: " .Messages::getError("PASSWORD_EMPTY")."<br>";
echo "PASSWORD_TOO_SHORT: " .Messages::getError("PASSWORD_TOO_SHORT")."<br>";
echo "PROFILE_PIC_WRONG_TYPE: " .Messages::getError("PROFILE_PIC_WRONG_TYPE")."<br>";
echo "HOBBY_DATE_EMPTY: " .Messages::getError("HOBBY_DATE_EMPTY")."<br>";
echo "HOBBY_DATE_FORMAT_INVALID: " .Messages::getError("HOBBY_DATE_FORMAT_INVALID")."<br>";
echo "HOBBY_DATE_INVALID: " .Messages::getError("HOBBY_DATE_INVALID")."<br>";
echo "FAV_COLOR_EMPTY: " .Messages::getError("FAV_COLOR_EMPTY")."<br>";
echo "FAV_COLOR_INVALID: " .Messages::getError("FAV_COLOR_INVALID")."<br>";
echo "URL_INVALID: " .Messages::getError("URL_INVALID")."<br>";
echo "PHONE_NUMBER_INVALID: " .Messages::getError("PHONE_NUMBER_INVALID")."<br>";

?>

<h2>It should allow change of locale</h2>
<?php 
Messages::$locale = 'German';
Messages::reset();

echo "EMAIL_EMPTY: " .Messages::getError("EMAIL_EMPTY")."<br>";
echo "EMAIL_INVALID: " .Messages::getError("EMAIL_INVALID")."<br>";
echo "USER_NAME_EMPTY: " .Messages::getError("USER_NAME_EMPTY")."<br>";
echo "USER_NAME_TOO_SHORT: " .Messages::getError("USER_NAME_TOO_SHORT")."<br>";
echo "USER_NAME_HAS_INVALID_CHARS: " .Messages::getError("USER_NAME_HAS_INVALID_CHARS")."<br>";
echo "SKILL_AREA_INVALID: " .Messages::getError("SKILL_AREA_INVALID")."<br>";
echo "SKILL_LEVEL_INVALID: " .Messages::getError("SKILL_LEVEL_INVALID")."<br>";
echo "SKILL_LEVEL_NOT_SET: " .Messages::getError("SKILL_LEVEL_NOT_SET")."<br>";
echo "PASSWORD_EMPTY: " .Messages::getError("PASSWORD_EMPTY")."<br>";
echo "PASSWORD_TOO_SHORT: " .Messages::getError("PASSWORD_TOO_SHORT")."<br>";
echo "PROFILE_PIC_WRONG_TYPE: " .Messages::getError("PROFILE_PIC_WRONG_TYPE")."<br>";
echo "HOBBY_DATE_EMPTY: " .Messages::getError("HOBBY_DATE_EMPTY")."<br>";
echo "HOBBY_DATE_FORMAT_INVALID: " .Messages::getError("HOBBY_DATE_FORMAT_INVALID")."<br>";
echo "HOBBY_DATE_INVALID: " .Messages::getError("HOBBY_DATE_INVALID")."<br>";
echo "FAV_COLOR_EMPTY: " .Messages::getError("FAV_COLOR_EMPTY")."<br>";
echo "FAV_COLOR_INVALID: " .Messages::getError("FAV_COLOR_INVALID")."<br>";
echo "URL_INVALID: " .Messages::getError("URL_INVALID")."<br>";
echo "PHONE_NUMBER_INVALID: " .Messages::getError("PHONE_NUMBER_INVALID")."<br>";

?>
</body>
</html>

