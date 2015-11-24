<?php
class DatasetsDB {
	
	// Inserts a Dataset object into the Dataset table and returns
	// the Dataset with the dataset_id property set, if successful;
	// otherwise, returns the Dataset unchanged. Sets a dataset_id error
	// if there is a db issue.
	public static function addDataset($dataset) {
		$query = "INSERT INTO Datasets (user_id, dataset_name, description) VALUES 
				(:user_id, :dataset_name, :description)";
		
		try {
			if (is_null($dataset) || $dataset->getErrorCount() > 0)
				return $dataset;
			
			$db = Database::getDB();
			$statement = $db->prepare($query);
			$statement->bindValue(':user_id', $dataset->getUserId());
			$statement->bindValue(':dataset_name', $dataset->getDatasetName());
			$statement->bindValue(':description', $dataset->getDescription());
			$statement->execute();
			$statement->closeCursor();
			
			$newDatasetId = $db->lastInsertId('dataset_id');
			$dataset->setDatasetId($newDatasetId);
			
			$dateCreatedArray = DatasetsDB::getDatasetsValuesBy('dataset_id', $newDatasetId, 'date_created');
			$dataset->setDateCreated($dateCreatedArray[0]);
		} catch (Exception $e) {
			$dataset->setError('dataset_id', 'DATASET_INVALID');
		}
		
		return $dataset;
	}

	// Returns an array of Datasets that meet the criteria specified.
	// If unsuccessful, this function returns an empty array.
	public static function getDatasetsBy($type = null, $value = null) {
		$datasetRows = DatasetsDB::getDatasetRowsBy($type, $value);
	
		return DatasetsDB::getDatasetsArray($datasetRows);
	}
	
	// Returns an array of the rows from the Datasets table whose $type
	// field has value $value. Throws an exception if unsuccessful.
	public static function getDatasetRowsBy($type = null, $value = null) {
		$allowedTypes = ['dataset_id', 'user_id', 'dataset_name'];
		$datasetRows = array();
		
		try {
			$db = Database::getDB();
			$query = "SELECT dataset_id, user_id, dataset_name, description, date_created 
					FROM Datasets";
			
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for Datasets");
				
				$query = $query . " WHERE ($type = :$type)";
				$statement = $db->prepare($query);
				$statement->bindParam(":$type", $value);
			} else {
				$statement = $db->prepare($query);
			}
			
			$statement->execute();
			$datasetRows = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor();
		} catch (Exception $e) {
			echo "<p>Error getting dataset rows by $type: ".$e->getMessage()."</p>";
		}
		
		return $datasetRows;
	}
	
	// Returns an array of Dataset objects extracted from $rows
	public static function getDatasetsArray($rows) {
		$datasets = array();
	
		if (!empty($rows)) {
			// Convert the array of arrays into an array of Datasets
			// and set the id and date_created fields
			foreach ($rows as $datasetRow) {
				$dataset = new Dataset($datasetRow);
	
				$datasetId = $datasetRow['dataset_id'];
				$dataset->setDatasetId($datasetId);
	
				$datasetDateCreated = $datasetRow['date_created'];
				$dataset->setDateCreated($datasetDateCreated);
				
				// TODO: We should also get the dataset's associated sensors
				// Coordinate this in the controller
				array_push($datasets, $dataset);
			}
		}
	
		return $datasets;
	}
	
	// Returns the $column of Datasets whose $type maches $value
	public static function getDatasetsValuesBy($type = null, $value = null, $column) {
		$datasetRows = DatasetsDB::getDatasetRowsBy($type, $value);
		
		return DatasetsDB::getDatasetValues($datasetRows, $column);
	}
	
	// Returns an array of values from the $column extracted from $rows
	public static function getDatasetValues($rows, $column) {
		$datasetValues = array();
		
		foreach ($rows as $datasetRow) {
			$datasetValue = $datasetRow[$column];
			array_push($datasetValues, $datasetValue);
		}

		return $datasetValues;
	}
	
	// Updates a Dataset entry in the Datasets table
	// Only the name and description fields should be editable
	public static function updateDataset($dataset) {
		try {
			$db = Database::getDB();
			
			if (is_null($dataset) || $dataset->getErrorCount() > 0)
				return $dataset;
			
			$checkDataset = DatasetsDB::getDatasetsBy('dataset_id', $dataset->getDatasetId());
			
			if (empty($checkDataset)) {
				$dataset->setError('dataset_id', 'DATASET_DOES_NOT_EXIST');
				return $dataset;
			}
			if ($dataset->getErrorCount() > 0)
				return $dataset;
			
			$query = "UPDATE Datasets SET dataset_name = :dataset_name, 
					description = :description
					WHERE dataset_id = :dataset_id";
			
			$statement = $db->prepare($query);
			$statement->bindValue(':dataset_name', $dataset->getDatasetName());
			$statement->bindValue(':description', $dataset->getDescription());
			$statement->bindValue(':dataset_id', $dataset->getDatasetId());
			$statement->execute();
			$statement->closeCursor();
		} catch (Exception $e) {
			$dataset->setError('dataset_id', 'DATASET_COULD_NOT_BE_UPDATED');
		}
		
		return $dataset;
	}
}
?>