<?php
	require_once('JsonDataObject.php');
Class ListingStatus extends JsonDataObject
{
	public $listingStatusId;
	public $listingId;
	public $statusTypeId;
	/*arrays of objects*/
	/*rest of unkeyed columns*/
	public $lastUpdateDate;
	public $lastUpdateId;

  function __construct($obj = NULL) {
		if(isset($obj)){
			return $this->buildFromObject($obj);
		}else{
			return $this;
		}
	}

	public function buildFromObject($obj){
		//$instance = new ListingStatus;
		$instance = objectToObject($obj,'ListingStatus');

    return $instance;
	}

	public function getAll(){		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select listingStatusId,listingId,statusTypeId,lastUpdateDate,lastUpdateId from listingstatus;");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}

	public function get($listingStatusId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select listingStatusId,listingId,statusTypeId,lastUpdateDate,lastUpdateId from listingstatus where listingStatusId = :listingStatusId;");
			$stmt->bindParam(':listingStatusId',$listingStatusId, PDO::PARAM_INT);
			$stmt->execute();
			$ListingStatus = new ListingStatus;
			if($listingStatusId > 0){
				$ListingStatus = $stmt->fetchObject('ListingStatus');
			}
			return $ListingStatus;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
  public function getByListingId($listingId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select
                              ls.listingStatusId,ls.listingId,ls.statusTypeId,ls.lastUpdateDate,ls.lastUpdateId
                              from listingstatus ls
															inner join (select max(listingStatusId) maxLs, listingId from listingstatus group by listingId) maxLS
																on maxLS.listingId = ls.listingId
                              where ls.listingId = :listingId;");
			$stmt->bindParam(':listingId',$listingId, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $result;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}

	public function getCurrentStatusByListingId($listingId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select
                              ls.listingStatusId,ls.listingId,ls.statusTypeId,ls.lastUpdateDate,ls.lastUpdateId
                              from listingstatus ls
															inner join (select max(listingStatusId) maxLs, listingId from listingstatus group by listingId) maxLS
																on maxLS.listingId = ls.listingId
																and maxLS.maxLs = ls.listingStatusId
                              where ls.listingId = :listingId;");
			$stmt->bindParam(':listingId',$listingId, PDO::PARAM_INT);
			$stmt->execute();
			$ListingStatus = new ListingStatus;
			$ListingStatus = $stmt->fetchObject('ListingStatus');

			return $ListingStatus;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}

	public function hasNewStatus($listingId, $statusTypeId){
		return $this->getCurrentStatusByListingId->statusTypeId <> $statusTypeId;
	}

	public function save(){
		$pdo;
		$stmt;

		try {
			if($this->listingStatusId > 0){
					$pdo = getPDO();
					$stmt =  $pdo->prepare("update listingstatus set
											listingId = :listingId,
											statusTypeId = :statusTypeId,
											lastUpdateDate = :lastUpdateDate,
											lastUpdateId = :lastUpdateId
 											where listingStatusId = :listingStatusId;");
					$stmt->bindParam(':listingStatusId', $this->listingStatusId, PDO::PARAM_INT);
					$stmt->bindParam(':listingId',$this->listingId, PDO::PARAM_INT);
					$stmt->bindParam(':statusTypeId',$this->statusTypeId, PDO::PARAM_INT);
					$stmt->bindParam(':lastUpdateDate',$this->lastUpdateDate, PDO::PARAM_STR);
					$stmt->bindParam(':lastUpdateId',$this->lastUpdateId, PDO::PARAM_STR);
					$stmt->execute();
			}else{
					if($this->hasNewStatus($this->listingId, $this->statusTypeId)){
						$pdo = getPDO();
			      $stmt =  $pdo->prepare("insert into listingstatus(listingId,statusTypeId,lastUpdateDate,lastUpdateId)values(:listingId,:statusTypeId,:lastUpdateDate,:lastUpdateId);");
						$stmt->bindParam(':listingId',$this->listingId, PDO::PARAM_INT);
						$stmt->bindParam(':statusTypeId',$this->statusTypeId, PDO::PARAM_INT);
						$stmt->bindParam(':lastUpdateDate',$this->lastUpdateDate, PDO::PARAM_STR);
						$stmt->bindParam(':lastUpdateId',$this->lastUpdateId, PDO::PARAM_STR);
						$stmt->execute();
						$this->listingStatusId = $pdo->lastInsertId();
					}
			}

			return $this->get($this->listingStatusId);

		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function delete($listingStatusId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("delete from listingstatus where listingStatusId = :listingStatusId;");
			$stmt->bindParam(':listingStatusId',$listingStatusId, PDO::PARAM_INT);
			$stmt->execute();
			if($stmt->rowCount() == 0){
				throw new Exception("Could not remove ListingStatus.");
			}else{
				Return "ListingStatus removed successfully.";
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
}
?>
