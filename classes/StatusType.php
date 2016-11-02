<?php
	require_once('JsonDataObject.php');
Class StatusType extends JsonDataObject
{
	public $statusTypeId;
	public $name;
	public $lastUpdateDate;
	public $lastUpdateId;
  function __construct() {}
    
	public function getAll(){		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			//$stmt =  $pdo->prepare("select statusTypeId,name,lastUpdateDate,lastUpdateId from statustype;");
			$stmt =  $pdo->prepare("select distinct status 'name' from listings where status is not null order by status;");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function get($statusTypeId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select statusTypeId,name,lastUpdateDate,lastUpdateId from statustype where statusTypeId = :statusTypeId;");
			$stmt->bindParam(':statusTypeId',$statusTypeId, PDO::PARAM_INT);
			$stmt->execute();
			$StatusType = new StatusType;
			if($statusTypeId > 0){
				$StatusType = $stmt->fetchObject('StatusType');
			}
			return $StatusType;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function save(){
		$pdo;
		$stmt;

		try {
			if($this->statusTypeId > 0){
					$pdo = getPDO();
					$stmt =  $pdo->prepare("update statustype set
											name = :name,
											lastUpdateDate = :lastUpdateDate,
											lastUpdateId = :lastUpdateId,
 											where statusTypeId = :statusTypeId;");
					$stmt->bindParam(':statusTypeId', $this->statusTypeId, PDO::PARAM_INT);
					$stmt->bindParam(':name',$this->name, PDO::PARAM_STR);
					$stmt->bindParam(':lastUpdateDate',$this->lastUpdateDate, PDO::PARAM_STR);
					$stmt->bindParam(':lastUpdateId',$this->lastUpdateId, PDO::PARAM_STR);
					$stmt->execute();
			}else{
					$pdo = getPDO();
				$stmt =  $pdo->prepare("insert into statustype(name,lastUpdateDate,lastUpdateId)values(:name,:lastUpdateDate,:lastUpdateId);");
					$stmt->bindParam(':name',$this->name, PDO::PARAM_STR);
					$stmt->bindParam(':lastUpdateDate',$this->lastUpdateDate, PDO::PARAM_STR);
					$stmt->bindParam(':lastUpdateId',$this->lastUpdateId, PDO::PARAM_STR);
				$stmt->execute();
				$this->statusTypeId = $pdo->lastInsertId();
			}
			if($stmt->rowCount() > 0){
				return $this->get($this->statusTypeId);
			}else{
				throw new Exception(($this->statusTypeId > 0 ? "Update" : "Insert") . "  failed.");
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function delete($statusTypeId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("delete from statustype where statusTypeId = :statusTypeId;");
			$stmt->bindParam(':statusTypeId',$statusTypeId, PDO::PARAM_INT);
			$stmt->execute();
			if($stmt->rowCount() == 0){
				throw new Exception("Could not remove StatusType.");
			}else{
				Return "StatusType removed successfully.";
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
}
?>
