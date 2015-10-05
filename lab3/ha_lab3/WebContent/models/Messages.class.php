<?php
class Messages {
	public static $errors = array();
	public static $locale = "English";
	
	public static function setErrors($filename) {
		$array = array();
		foreach (file($filename) as $line) {
			list($key, $value) = explode(' ', $line, 2) + array(NULL, NULL);
			if ($value !== NULL)
				$array[$key] = $value;
		}
		self::$errors = $array;
	}
	
	public static function getError($errorName) {
		if (isset(self::$errors, $errorName))
			return self::$errors[$errorName];
		else 
			return "";
	}
	
	public static function reset() {
		 $pathDir = dirname(__FILE__);
		 $fileName = $pathDir . DIRECTORY_SEPARATOR . "../resources/errors_".self::$locale.".txt";
		 self::setErrors($fileName);	 
	}
	
}