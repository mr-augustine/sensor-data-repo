<?php
require_once dirname(__FILE__).'\..\..\WebContent\tests\DBMaker.class.php';


class makeDBTest extends PHPUnit_Framework_TestCase {
	
  public function testDatabaseCreate() {
    $myDb = DBMaker::create ('botspacetest');
  }
}
?>