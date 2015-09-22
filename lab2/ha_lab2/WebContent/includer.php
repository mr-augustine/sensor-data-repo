<?php
$pathDir = dirname(__FILE__);
$paths = array('controllers', 'models', 'views');
for ($k = 0; $k < count($paths); $k++) {
	set_include_path(get_include_path() . PATH_SEPARATOR .
			$pathDir . DIRECTORY_SEPARATOR . $paths[$k]);
}
spl_autoload_extensions('.class.php');
spl_autoload_register();
?>