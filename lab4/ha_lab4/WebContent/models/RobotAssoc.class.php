<?php
include_once ("Messages.class.php");

class RobotAssoc {

	private $errorCount;
	private $errors;

	private $robotAssocId;
	private $robotId;
	private $creatorId;

	public function __construct($robotId = null, $creatorId = null) {
		$this->robotId = $robotId;
		$this->creatorId = $creatorId;

		Messages::reset();
		$this->initialize();
	}

	public function getError($errorName) {
		if (isset($this->errors[$errorName]))
			return $this->errors[$errorName];
		else
			return "";
	}

	public function setError($errorName, $errorValue) {
		$this->errors[$errorName] = Messages::getError($errorValue);
		$this->errorCount++;
	}

	public function getErrorCount() {
		return $this->errorCount;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function getParameters() {
		$paramArray = array("robotAssocId" => $this->robotAssocId,
				"robotId" => $this->robotId, "creatorId" => $this->creatorId);

		return $paramArray;
	}

	public function getRobotAssocId() {
		return $this->robotAssocId;
	}

	public function getRobotId() {
		return $this->robotId;
	}

	public function getCreatorId() {
		return $this->creatorId;
	}

	public function setRobotAssocId($id) {
		$this->robotAssocId = $id;
	}

	private function initialize() {
		$this->errorCount = 0;
		$errors = array();

		if (is_null($this->robotId) || is_null($this->creatorId))
			$this->initializeEmpty();
		else {
			$this->robotId = trim($this->robotId);
			$this->robotId = stripslashes($this->robotId);
			$this->robotId = htmlspecialchars($this->robotId);
			$this->creatorId = trim($this->creatorId);
			$this->creatorId = stripslashes($this->creatorId);
			$this->creatorId = htmlspecialchars($this->creatorId);
				
			$this->validateRobotId();
			$this->validateCreatorId();
		}
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
		$this->robotAssocId = "";
		$this->robotId = "";
		$this->creatorIds = array();
	}

	private function validateRobotId() {
		if (empty($this->robotId))
			$this->setError('robotId', "ROBOT_ID_EMPTY");
		elseif (!is_numeric($this->robotId) || $this->robotId < 0)
		$this->setError('robotId', "ROBOT_ID_INVALID");
	}

	private function validateCreatorId() {
		if (empty($this->creatorId))
			$this->setError('creatorId', "CREATOR_ID_EMPTY");
		elseif (!is_numeric($this->creatorId) || $this->creatorId < 0)
		$this->setError('creatorId', "CREATOR_ID_INVALID");
	}
}
?>