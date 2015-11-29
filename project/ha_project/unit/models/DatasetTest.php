<?php
require_once dirname(__FILE__).'\..\..\WebContent\models\Messages.class.php';
require_once dirname(__FILE__).'\..\..\WebContent\models\Dataset.class.php';

class DatasetTest extends PHPUnit_Framework_TestCase {
	
	public function testValidDatasetCreate() {
		$validTest = array('user_id' => 1, 'dataset_name' => 'Franklin Park Run',
			'description' => 'Valid description');
		$validDataset = new Dataset($validTest);
		
		$this->assertTrue(is_a($validDataset, 'Dataset'),
				'It should created a Dataset object when valid input is provided');
		$this->assertEquals(0, $validDataset->getErrorCount(),
				'The Dataset object should be error-free');
	}
	
	public function testInvalidDatasetName() {
		$invalidTest = array('user_id' => 1, 'dataset_name' => 'Inv@l!d Name',
				'description' => 'Valid description');
		$invalidDataset = new Dataset($invalidTest);
		
		$this->assertEquals(1, $invalidDataset->getErrorCount(),
				'The Dataset object should have exactly 1 error');
		$this->assertTrue(!empty($invalidDataset->getError('dataset_name')),
				'The Dataset should have a dataset_name error');
	}
	
	public function testInvalidDatasetDescription() {
		$invalidTest = array('user_id' => 1, 'dataset_name' => 'Franklin Park Run',
				'description' => 'This description is 256 characters long '.
				'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna. Nunc viverra imperdiet enim. Fusce est. Vivamus a tel');
		$invalidDataset = new Dataset($invalidTest);
		
		$this->assertEquals(1, $invalidDataset->getErrorCount(),
				'The Dataset object should have exactly 1 error');
		$this->assertTrue(!empty($invalidDataset->getError('description')),
				'The Dataset should have a description error');
	}
}
?>