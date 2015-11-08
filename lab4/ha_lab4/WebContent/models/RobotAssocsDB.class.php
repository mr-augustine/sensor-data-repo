<?php
class RobotAssocsDB {
	
	public static function addRobotAssoc($robotAssoc) {
		$query = "INSERT INTO RobotAssocs (robotId, creatorId)
				VALUES (:robotId, :creatorId)";
		
		try {
			if (is_null($robotAssoc) || $robotAssoc->getErrorCount() > 0)
				return $robotAssoc;
			
			$db = Database::getDB();
			$statement = $db->prepare($query);
			$statement->bindValue(":robotId", $robotAssoc->getRobotId());
			$statement->bindValue(":creatorId", $robotAssoc->getCreatorId());
			$statement->execute();
			$statement->closeCursor();
			
			$robotAssoc->setRobotAssocId($db->lastInsertId("robotAssocId"));
		} catch (Exception $e) {
			$robotAssoc->setError('robotAssocId', 'ROBOT_ASSOC_INVALID');
		}
		
		return $robotAssoc;
	}
}
?>