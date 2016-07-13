<?php
	require_once('JsonDataObject.php');
Class Listing extends JsonDataObject
{
	public $listingId;
	public $propertyId;
	public $agentId;
	public $saleId;
	/*single and nullable objects*/
	public $agent;
	public $property;
	public $sale;
	/*arrays of objects*/
	public $listingprice;
	public $listingstatus;
	public $openhouse;
	/*rest of unkeyed columns*/
	public $mls;
	public $title;
	public $descriptionShort;
	public $descriptionLong;
	public $publicRemarks;
	public $marketingId;
	public $youTubeId;
	public $shortSale;
	public $featured;
	public $frontPage;
	public $lastUpdateDate;
	public $lastUpdateId;

  function __construct($obj = NULL) {
		if(isset($obj)){
			$this->buildFromObject($obj);
		}
	}

	public function buildFromObject($obj){

		$instance = objectToObject($obj,'Listing');
		$instance->property = objectToObject($obj->property,'Property');
		$instance->listingstatus = objectToObject($obj->listingstatus,'ListingStatus');

		return $instance;
	}

	public function getAll(){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select
																lst.listingId,
																lst.propertyId,
																lst.agentId,
																lst.saleId,
																lst.mls,
																lst.title,
																lst.descriptionShort,
																lst.descriptionLong,
																lst.publicRemarks,
																lst.marketingId,
																lst.youTubeId,
																lst.shortSale,
																lst.featured,
																lst.frontPage,
																lst.lastUpdateDate,
																lst.lastUpdateId,
																ls.statusTypeId,
																p.address
																from listing lst
																inner join listingstatus ls
																	on lst.listingId = ls.listingId
																inner join (select max(listingStatusId) maxLs, listingId from listingstatus group by listingId) maxLS
																	on maxLS.listingId = ls.listingId
																	and maxLs.maxLs = ls.listingStatusId
																inner join property p
																	on lst.propertyId = p.propertyId;");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function get($listingId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select
															lst.listingId,lst.propertyId,lst.agentId,lst.saleId,lst.mls,lst.title,lst.descriptionShort,lst.descriptionLong,lst.publicRemarks,lst.marketingId,lst.youTubeId,lst.shortSale,lst.featured,lst.frontPage,lst.lastUpdateDate,lst.lastUpdateId
															from listing lst
															inner join listingstatus ls
																on lst.listingId = ls.listingId
															inner join (select max(listingStatusId) maxLs, listingId from listingstatus group by listingId) maxLS
																on maxLS.listingId = ls.listingId
																and maxLs.maxLs = ls.listingStatusId
															where lst.listingId = :listingId;");
			$stmt->bindParam(':listingId',$listingId, PDO::PARAM_INT);
			$stmt->execute();
			$Listing = new Listing();
			if($listingId > 0){
				$Listing = $stmt->fetchObject('Listing');
				/*	single and nullable objects*/
				/*
				$agent = new Agent();
				$Listing->agent =  $agent->get($Listing->agentId);
				*/
				$property = new Property(null);
				$Listing->property =  $property->get($Listing->propertyId);

				$listingstatus = new Listingstatus(null);
				$Listing->listingstatus =  $listingstatus->getByListingId($Listing->listingId);
				$listingprice = new Listingprice;
				$Listing->listingprice =  $listingprice->getByListingId($Listing->listingId);
				/*
				$sale = new Sale();
				$Listing->sale =  $sale->get($Listing->saleId);

				$openhouse = new Openhouse();
				$Listing->openhouse =  $openhouse->getByListing($Listing->$listingId);
				*/
			}
			return $Listing;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function getByListingprice($listingpriceId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select column names here from listingprice where listingpriceId  = :listingpriceId;");
			$stmt->bindParam(':listingpriceId',$listingpriceId, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function getByListingStatus($statusTypeId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select
																	lst.listingId,
																	lst.propertyId,
																	lst.agentId,
																	lst.saleId,
																	lst.mls,
																	lst.title,
																	lst.descriptionShort,
																	lst.descriptionLong,
																	lst.publicRemarks,
																	lst.marketingId,
																	lst.youTubeId,
																	lst.shortSale,
																	lst.featured,
																	lst.frontPage,
																	lst.lastUpdateDate,
																	lst.lastUpdateId
															from listing lst
															inner join listingstatus ls
																on lst.listingId = ls.listingId
															inner join (select max(listingStatusId) maxLs, listingId from listingstatus group by listingId) maxLS
																on maxLS.listingId = ls.listingId
															where ls.statusTypeId  = :statusTypeId;");
			$stmt->bindParam(':statusTypeId',$statusTypeId, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function getByOpenhouse($openhouseId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select column names here from openhouse where openhouseId  = :openhouseId;");
			$stmt->bindParam(':openhouseId',$openhouseId, PDO::PARAM_INT);
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
			if($this->listingId > 0){
					$pdo = getPDO();
					$stmt =  $pdo->prepare("update listing set
											propertyId = :propertyId,
											agentId = :agentId,
											saleId = :saleId,
											mls = :mls,
											title = :title,
											descriptionShort = :descriptionShort,
											descriptionLong = :descriptionLong,
											publicRemarks = :publicRemarks,
											marketingId = :marketingId,
											youTubeId = :youTubeId,
											shortSale = :shortSale,
											featured = :featured,
											frontPage = :frontPage,
											lastUpdateDate = now(),
											lastUpdateId = :lastUpdateId
 											where listingId = :listingId;");
					$stmt->bindParam(':listingId', $this->listingId, PDO::PARAM_INT);
					$stmt->bindParam(':propertyId',$this->propertyId, PDO::PARAM_INT);
					$stmt->bindParam(':agentId',$this->agentId, PDO::PARAM_INT);
					if(is_null($this->saleId)){
						$stmt->bindValue(':saleId',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':saleId',$this->saleId, PDO::PARAM_INT);
					}

					$stmt->bindParam(':mls',$this->mls, PDO::PARAM_INT);
					$stmt->bindParam(':title',$this->title, PDO::PARAM_STR);
					$stmt->bindParam(':descriptionShort',$this->descriptionShort, PDO::PARAM_STR);
					if(is_null($this->descriptionLong)){
						$stmt->bindValue(':descriptionLong',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':descriptionLong',$this->descriptionLong, PDO::PARAM_STR);
					}

					if(is_null($this->publicRemarks)){
						$stmt->bindValue(':publicRemarks',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':publicRemarks',$this->publicRemarks, PDO::PARAM_STR);
					}

					if(is_null($this->marketingId)){
						$stmt->bindValue(':marketingId',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':marketingId',$this->marketingId, PDO::PARAM_INT);
					}

					if(is_null($this->youTubeId)){
						$stmt->bindValue(':youTubeId',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':youTubeId',$this->youTubeId, PDO::PARAM_STR);
					}

					if(is_null($this->shortSale)){
						$stmt->bindValue(':shortSale',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':shortSale',$this->shortSale, PDO::PARAM_INT);
					}

					if(is_null($this->featured)){
						$stmt->bindValue(':featured',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':featured',$this->featured, PDO::PARAM_INT);
					}

					if(is_null($this->frontPage)){
						$stmt->bindValue(':frontPage',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':frontPage',$this->frontPage, PDO::PARAM_INT);
					}

					$stmt->bindParam(':lastUpdateId',$_SESSION[con_userid], PDO::PARAM_STR);
					$stmt->execute();

					try {
						$this->property = $this->property->save();
					}catch(Exception $e){
						throw new Exception($e->getMessage());
					}

					try {
						$this->listingstatus->listingStatusId = -1;
						$this->listingstatus = $this->listingstatus->save();
					}catch(Exception $e){
						throw new Exception($e->getMessage());
					}


			}else{
					$pdo = getPDO();
					$stmt =  $pdo->prepare("insert into listing(propertyId,agentId,saleId,mls,title,descriptionShort,descriptionLong,publicRemarks,marketingId,youTubeId,shortSale,featured,frontPage,lastUpdateDate,lastUpdateId)
																	values(:propertyId,:agentId,:saleId,:mls,:title,:descriptionShort,:descriptionLong,:publicRemarks,:marketingId,:youTubeId,:shortSale,:featured,:frontPage,now(),:lastUpdateId);");
					$stmt->bindParam(':propertyId',$this->propertyId, PDO::PARAM_INT);
					$stmt->bindParam(':agentId',$this->agentId, PDO::PARAM_INT);
					if(is_null($this->saleId)){
						$stmt->bindValue(':saleId',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':saleId',$this->saleId, PDO::PARAM_INT);
					}

					$stmt->bindParam(':mls',$this->mls, PDO::PARAM_INT);
					$stmt->bindParam(':title',$this->title, PDO::PARAM_STR);
					$stmt->bindParam(':descriptionShort',$this->descriptionShort, PDO::PARAM_STR);
					if(is_null($this->descriptionLong)){
						$stmt->bindValue(':descriptionLong',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':descriptionLong',$this->descriptionLong, PDO::PARAM_STR);
					}

					if(is_null($this->publicRemarks)){
						$stmt->bindValue(':publicRemarks',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':publicRemarks',$this->publicRemarks, PDO::PARAM_STR);
					}

					if(is_null($this->marketingId)){
						$stmt->bindValue(':marketingId',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':marketingId',$this->marketingId, PDO::PARAM_INT);
					}

					if(is_null($this->youTubeId)){
						$stmt->bindValue(':youTubeId',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':youTubeId',$this->youTubeId, PDO::PARAM_STR);
					}

					if(is_null($this->shortSale)){
						$stmt->bindValue(':shortSale',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':shortSale',$this->shortSale, PDO::PARAM_INT);
					}

					if(is_null($this->featured)){
						$stmt->bindValue(':featured',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':featured',$this->featured, PDO::PARAM_INT);
					}

					if(is_null($this->frontPage)){
						$stmt->bindValue(':frontPage',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':frontPage',$this->frontPage, PDO::PARAM_INT);
					}

					$stmt->bindParam(':lastUpdateId',$_SESSION[con_userid], PDO::PARAM_STR);
				$stmt->execute();
				$this->listingId = $pdo->lastInsertId();
			}

			if($stmt->rowCount() > 0){
				return $this->get($this->listingId);
			}else{
				return (($this->listingId > 0 ? "Update" : "Insert") . "  did not result in any changes.");
			}

		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function delete($listingId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("delete from listing where listingId = :listingId;");
			$stmt->bindParam(':listingId',$listingId, PDO::PARAM_INT);
			$stmt->execute();
			if($stmt->rowCount() == 0){
				throw new Exception("Could not remove Listing.");
			}else{
				Return "Listing removed successfully.";
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
}
?>
