<?php
require_once('JsonDataObject.php');
Class Sale extends JsonDataObject
{
	public $saleId;
	/*single and nullable objects*/
	/*arrays of objects*/
	public $listing;
	/*rest of unkeyed columns*/
	public $price;
	public $saleDate;
	public $notes;
	public $lastUpdateDate;
	public $lastUpdateId;
  function __construct() {}
	public function getAll(){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select saleId,price,saleDate,notes,lastUpdateDate,lastUpdateId from sale;");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function get($saleId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select saleId,price,saleDate,notes,lastUpdateDate,lastUpdateId from sale where saleId = :saleId;");
			$stmt->bindParam(':saleId',$saleId, PDO::PARAM_INT);
			$stmt->execute();
			$Sale = new Sale;
			if($saleId > 0){
				$Sale = $stmt->fetchObject('Sale');
				/*	single and nullable objects*/
				/*arrays of objects*/
				$listing = new Listing();
				$Sale->listing =  $listing->getBySale($Sale->$saleId);
			}
			return $Sale;
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
			if($this->saleId > 0){
					$pdo = getPDO();
					$stmt =  $pdo->prepare("update sale set
											price = :price,
											saleDate = :saleDate,
											notes = :notes,
											lastUpdateDate = :lastUpdateDate,
											lastUpdateId = :lastUpdateId,
 											where saleId = :saleId;");
					$stmt->bindParam(':saleId', $this->saleId, PDO::PARAM_INT);
					$stmt->bindParam(':price',$this->price, PDO::PARAM_INT);
					$stmt->bindParam(':saleDate',$this->saleDate, datetime);
					$stmt->bindParam(':notes',$this->notes, PDO::PARAM_STR);
					$stmt->bindParam(':lastUpdateDate',$this->lastUpdateDate, datetime);
					$stmt->bindParam(':lastUpdateId',$this->lastUpdateId, PDO::PARAM_STR);
					$stmt->execute();
			}else{
					$pdo = getPDO();
				$stmt =  $pdo->prepare("insert into sale(price,saleDate,notes,lastUpdateDate,lastUpdateId)values(:price,:saleDate,:notes,:lastUpdateDate,:lastUpdateId);");
					$stmt->bindParam(':price',$this->price, PDO::PARAM_INT);
					$stmt->bindParam(':saleDate',$this->saleDate, datetime);
					$stmt->bindParam(':notes',$this->notes, PDO::PARAM_STR);
					$stmt->bindParam(':lastUpdateDate',$this->lastUpdateDate, datetime);
					$stmt->bindParam(':lastUpdateId',$this->lastUpdateId, PDO::PARAM_STR);
				$stmt->execute();
				$this->saleId = $pdo->lastInsertId();
			}
			if($stmt->rowCount() > 0){
				return $this->get($this->saleId);
			}else{
				throw new Exception(($this->saleId > 0 ? "Update" : "Insert") . "  failed.");
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function delete($saleId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("delete from sale where saleId = :saleId;");
			$stmt->bindParam(':saleId',$saleId, PDO::PARAM_INT);
			$stmt->execute();
			if($stmt->rowCount() == 0){
				throw new Exception("Could not remove Sale.");
			}else{
				Return "Sale removed successfully.";
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
}
?>
