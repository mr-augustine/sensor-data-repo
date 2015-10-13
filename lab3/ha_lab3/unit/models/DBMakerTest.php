<?php
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'DBMaker.php';


class makeDBTest extends PHPUnit_Framework_TestCase {
	
  public function testDatabaseCreate() {
    $myDb = DBMaker::create ('botspacetest');
  }
}
?>