<?php
	require_once('JsonDataObject.php');
Class ListingPrice extends JsonDataObject
{
	public $listingPriceId;
	public $listingId;
	/*single and nullable objects*/
	public $listing;
	/*arrays of objects*/
	/*rest of unkeyed columns*/
	public $price;
	public $lastUpdateDate;
	public $lastUpdateId;
  function __construct() {}
	public function getAll(){		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select listingPriceId,listingId,price,lastUpdateDate,lastUpdateId from listingprice;");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function get($listingPriceId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select listingPriceId,listingId,price,lastUpdateDate,lastUpdateId from listingprice where listingPriceId = :listingPriceId;");
			$stmt->bindParam(':listingPriceId',$listingPriceId, PDO::PARAM_INT);
			$stmt->execute();
			$ListingPrice = new ListingPrice;
			if($listingPriceId > 0){
				$ListingPrice = $stmt->fetchObject('ListingPrice');
			}
			return $ListingPrice;
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
                              lp.listingPriceId,lp.listingId,lp.price,lp.lastUpdateDate,lp.lastUpdateId
                              from listingprice lp
                              where lp.listingId = :listingId;");
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

	public function save(){
		$pdo;
		$stmt;

		try {
			if($this->listingPriceId > 0){
					$pdo = getPDO();
					$stmt =  $pdo->prepare("update listingprice set
											listingId = :listingId,
											price = :price,
											lastUpdateDate = :lastUpdateDate,
											lastUpdateId = :lastUpdateId,
 											where listingPriceId = :listingPriceId;");
					$stmt->bindParam(':listingPriceId', $this->listingPriceId, PDO::PARAM_INT);
					$stmt->bindParam(':listingId',$this->listingId, PDO::PARAM_INT);
					$stmt->bindParam(':price',$this->price, PDO::PARAM_INT);
					$stmt->bindParam(':lastUpdateDate',$this->lastUpdateDate, PDO::PARAM_STR);
					$stmt->bindParam(':lastUpdateId',$this->lastUpdateId, PDO::PARAM_STR);
					$stmt->execute();
			}else{
					$pdo = getPDO();
				$stmt =  $pdo->prepare("insert into listingprice(listingId,price,lastUpdateDate,lastUpdateId)values(:listingId,:price,:lastUpdateDate,:lastUpdateId);");
					$stmt->bindParam(':listingId',$this->listingId, PDO::PARAM_INT);
					$stmt->bindParam(':price',$this->price, PDO::PARAM_INT);
					$stmt->bindParam(':lastUpdateDate',$this->lastUpdateDate, PDO::PARAM_STR);
					$stmt->bindParam(':lastUpdateId',$this->lastUpdateId, PDO::PARAM_STR);
				$stmt->execute();
				$this->listingPriceId = $pdo->lastInsertId();
			}
			if($stmt->rowCount() > 0){
				return $this->get($this->listingPriceId);
			}else{
				throw new Exception(($this->listingPriceId > 0 ? "Update" : "Insert") . "  failed.");
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function delete($listingPriceId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("delete from listingprice where listingPriceId = :listingPriceId;");
			$stmt->bindParam(':listingPriceId',$listingPriceId, PDO::PARAM_INT);
			$stmt->execute();
			if($stmt->rowCount() == 0){
				throw new Exception("Could not remove ListingPrice.");
			}else{
				Return "ListingPrice removed successfully.";
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
}
?>
