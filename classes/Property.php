<?php
	require_once('JsonDataObject.php');
Class Property extends JsonDataObject
{
	public $propertyId;
	public $propertyTypeId;
	public $neighborhoodId;
	public $zoningTypeId;
	public $address;
	public $stateId;
	/*single and nullable objects*/
	public $neighborhood;
	public $propertytype;
	public $state;
	public $zoningtype;
	/*arrays of objects*/
	public $listing;
	/*rest of unkeyed columns*/
	public $areaCode;
	public $subdivision;
	public $location;
	public $latitude;
	public $longitude;
	public $elevation;
	public $unit;
	public $city;
	public $zip;
	public $county;
	public $gated;
	public $floor;
	public $bed;
	public $bath;
	public $stories;
	public $garage;
	public $pool;
	public $spa;
	public $yearBuilt;
	public $schoolElementary;
	public $schoolMiddle;
	public $schoolHigh;
	public $sqFtLiving;
	public $sqFtLot;
	public $acres;
	public $parcelNumber;
	public $lastUpdateDate;
	public $lastUpdateId;
  function __construct() {}
	public function getAll(){		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select propertyId,propertyTypeId,neighborhoodId,zoningTypeId,areaCode,subdivision,location,latitude,longitude,elevation,unit,address,city,stateId,zip,county,gated,floor,bed,bath,stories,garage,pool,spa,yearBuilt,schoolElementary,schoolMiddle,schoolHigh,sqFtLiving,sqFtLot,acres,parcelNumber,lastUpdateDate,lastUpdateId from property;");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function get($propertyId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select propertyId,propertyTypeId,neighborhoodId,zoningTypeId,areaCode,subdivision,location,latitude,longitude,elevation,unit,address,city,stateId,zip,county,gated,floor,bed,bath,stories,garage,pool,spa,yearBuilt,schoolElementary,schoolMiddle,schoolHigh,sqFtLiving,sqFtLot,acres,parcelNumber,lastUpdateDate,lastUpdateId from property where propertyId = :propertyId;");
			$stmt->bindParam(':propertyId',$propertyId, PDO::PARAM_INT);
			$stmt->execute();
			$Property = new Property;
			if($propertyId > 0){
				$Property = $stmt->fetchObject('Property');
				/*	single and nullable objects*/
				$neighborhood = new Neighborhood();
				$Property->neighborhood =  $neighborhood->get($Property->neighborhoodId);
				$propertytype = new Propertytype();
				$Property->propertytype =  $propertytype->get($Property->propertytypeId);
				$state = new State();
				$Property->state =  $state->get($Property->stateId);
				$zoningtype = new Zoningtype();
				$Property->zoningtype =  $zoningtype->get($Property->zoningtypeId);
				/*arrays of objects*/
				$listing = new Listing();
				$Property->listing =  $listing->getByProperty($Property->$propertyId);
			}
			return $Property;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function getByListing($listingId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select column names here from listing where listingId  = :listingId;");
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
			if($this->propertyId > 0){
					$pdo = getPDO();
					$stmt =  $pdo->prepare("update property set
											propertyTypeId = :propertyTypeId,
											neighborhoodId = :neighborhoodId,
											zoningTypeId = :zoningTypeId,
											areaCode = :areaCode,
											subdivision = :subdivision,
											location = :location,
											latitude = :latitude,
											longitude = :longitude,
											elevation = :elevation,
											unit = :unit,
											address = :address,
											city = :city,
											stateId = :stateId,
											zip = :zip,
											county = :county,
											gated = :gated,
											floor = :floor,
											bed = :bed,
											bath = :bath,
											stories = :stories,
											garage = :garage,
											pool = :pool,
											spa = :spa,
											yearBuilt = :yearBuilt,
											schoolElementary = :schoolElementary,
											schoolMiddle = :schoolMiddle,
											schoolHigh = :schoolHigh,
											sqFtLiving = :sqFtLiving,
											sqFtLot = :sqFtLot,
											acres = :acres,
											parcelNumber = :parcelNumber,
											lastUpdateDate = :lastUpdateDate,
											lastUpdateId = :lastUpdateId,
 											where propertyId = :propertyId;");
					$stmt->bindParam(':propertyId', $this->propertyId, PDO::PARAM_INT);
					if(is_null($this->propertyTypeId)){
						$stmt->bindValue(':propertyTypeId',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':propertyTypeId',$this->propertyTypeId, PDO::PARAM_INT);
					}

					if(is_null($this->neighborhoodId)){
						$stmt->bindValue(':neighborhoodId',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':neighborhoodId',$this->neighborhoodId, PDO::PARAM_INT);
					}

					if(is_null($this->zoningTypeId)){
						$stmt->bindValue(':zoningTypeId',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':zoningTypeId',$this->zoningTypeId, PDO::PARAM_INT);
					}

					if(is_null($this->areaCode)){
						$stmt->bindValue(':areaCode',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':areaCode',$this->areaCode, PDO::PARAM_STR);
					}

					if(is_null($this->subdivision)){
						$stmt->bindValue(':subdivision',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':subdivision',$this->subdivision, PDO::PARAM_STR);
					}

					if(is_null($this->location)){
						$stmt->bindValue(':location',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':location',$this->location, PDO::PARAM_STR);
					}

					if(is_null($this->latitude)){
						$stmt->bindValue(':latitude',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':latitude',$this->latitude, PDO::PARAM_INT);
					}

					if(is_null($this->longitude)){
						$stmt->bindValue(':longitude',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':longitude',$this->longitude, PDO::PARAM_INT);
					}

					if(is_null($this->elevation)){
						$stmt->bindValue(':elevation',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':elevation',$this->elevation, PDO::PARAM_INT);
					}

					if(is_null($this->unit)){
						$stmt->bindValue(':unit',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':unit',$this->unit, PDO::PARAM_STR);
					}

					$stmt->bindParam(':address',$this->address, PDO::PARAM_STR);
					$stmt->bindParam(':city',$this->city, PDO::PARAM_STR);
					$stmt->bindParam(':stateId',$this->stateId, PDO::PARAM_INT);
					$stmt->bindParam(':zip',$this->zip, PDO::PARAM_STR);
					if(is_null($this->county)){
						$stmt->bindValue(':county',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':county',$this->county, PDO::PARAM_STR);
					}

					if(is_null($this->gated)){
						$stmt->bindValue(':gated',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':gated',$this->gated, PDO::PARAM_INT);
					}

					$stmt->bindParam(':floor',$this->floor, PDO::PARAM_INT);
					$stmt->bindParam(':bed',$this->bed, PDO::PARAM_INT);
					$stmt->bindParam(':bath',$this->bath, PDO::PARAM_INT);
					$stmt->bindParam(':stories',$this->stories, PDO::PARAM_INT);
					$stmt->bindParam(':garage',$this->garage, PDO::PARAM_INT);
					if(is_null($this->pool)){
						$stmt->bindValue(':pool',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':pool',$this->pool, PDO::PARAM_INT);
					}

					if(is_null($this->spa)){
						$stmt->bindValue(':spa',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':spa',$this->spa, PDO::PARAM_INT);
					}

					$stmt->bindParam(':yearBuilt',$this->yearBuilt, PDO::PARAM_INT);
					if(is_null($this->schoolElementary)){
						$stmt->bindValue(':schoolElementary',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':schoolElementary',$this->schoolElementary, PDO::PARAM_STR);
					}

					if(is_null($this->schoolMiddle)){
						$stmt->bindValue(':schoolMiddle',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':schoolMiddle',$this->schoolMiddle, PDO::PARAM_STR);
					}

					if(is_null($this->schoolHigh)){
						$stmt->bindValue(':schoolHigh',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':schoolHigh',$this->schoolHigh, PDO::PARAM_STR);
					}

					if(is_null($this->sqFtLiving)){
						$stmt->bindValue(':sqFtLiving',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':sqFtLiving',$this->sqFtLiving, PDO::PARAM_INT);
					}

					if(is_null($this->sqFtLot)){
						$stmt->bindValue(':sqFtLot',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':sqFtLot',$this->sqFtLot, PDO::PARAM_INT);
					}

					if(is_null($this->acres)){
						$stmt->bindValue(':acres',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':acres',$this->acres, PDO::PARAM_INT);
					}

					if(is_null($this->parcelNumber)){
						$stmt->bindValue(':parcelNumber',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':parcelNumber',$this->parcelNumber, PDO::PARAM_STR);
					}

					$stmt->bindParam(':lastUpdateDate',$this->lastUpdateDate, PDO::PARAM_STR);
					$stmt->bindParam(':lastUpdateId',$this->lastUpdateId, PDO::PARAM_STR);
					$stmt->execute();
			}else{
					$pdo = getPDO();
				$stmt =  $pdo->prepare("insert into property(propertyTypeId,neighborhoodId,zoningTypeId,areaCode,subdivision,location,latitude,longitude,elevation,unit,address,city,stateId,zip,county,gated,floor,bed,bath,stories,garage,pool,spa,yearBuilt,schoolElementary,schoolMiddle,schoolHigh,sqFtLiving,sqFtLot,acres,parcelNumber,lastUpdateDate,lastUpdateId)values(:propertyTypeId,:neighborhoodId,:zoningTypeId,:areaCode,:subdivision,:location,:latitude,:longitude,:elevation,:unit,:address,:city,:stateId,:zip,:county,:gated,:floor,:bed,:bath,:stories,:garage,:pool,:spa,:yearBuilt,:schoolElementary,:schoolMiddle,:schoolHigh,:sqFtLiving,:sqFtLot,:acres,:parcelNumber,:lastUpdateDate,:lastUpdateId);");
					if(is_null($this->propertyTypeId)){
						$stmt->bindValue(':propertyTypeId',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':propertyTypeId',$this->propertyTypeId, PDO::PARAM_INT);
					}

					if(is_null($this->neighborhoodId)){
						$stmt->bindValue(':neighborhoodId',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':neighborhoodId',$this->neighborhoodId, PDO::PARAM_INT);
					}

					if(is_null($this->zoningTypeId)){
						$stmt->bindValue(':zoningTypeId',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':zoningTypeId',$this->zoningTypeId, PDO::PARAM_INT);
					}

					if(is_null($this->areaCode)){
						$stmt->bindValue(':areaCode',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':areaCode',$this->areaCode, PDO::PARAM_STR);
					}

					if(is_null($this->subdivision)){
						$stmt->bindValue(':subdivision',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':subdivision',$this->subdivision, PDO::PARAM_STR);
					}

					if(is_null($this->location)){
						$stmt->bindValue(':location',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':location',$this->location, PDO::PARAM_STR);
					}

					if(is_null($this->latitude)){
						$stmt->bindValue(':latitude',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':latitude',$this->latitude, PDO::PARAM_INT);
					}

					if(is_null($this->longitude)){
						$stmt->bindValue(':longitude',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':longitude',$this->longitude, PDO::PARAM_INT);
					}

					if(is_null($this->elevation)){
						$stmt->bindValue(':elevation',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':elevation',$this->elevation, PDO::PARAM_INT);
					}

					if(is_null($this->unit)){
						$stmt->bindValue(':unit',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':unit',$this->unit, PDO::PARAM_STR);
					}

					$stmt->bindParam(':address',$this->address, PDO::PARAM_STR);
					$stmt->bindParam(':city',$this->city, PDO::PARAM_STR);
					$stmt->bindParam(':stateId',$this->stateId, PDO::PARAM_INT);
					$stmt->bindParam(':zip',$this->zip, PDO::PARAM_STR);
					if(is_null($this->county)){
						$stmt->bindValue(':county',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':county',$this->county, PDO::PARAM_STR);
					}

					if(is_null($this->gated)){
						$stmt->bindValue(':gated',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':gated',$this->gated, PDO::PARAM_INT);
					}

					$stmt->bindParam(':floor',$this->floor, PDO::PARAM_INT);
					$stmt->bindParam(':bed',$this->bed, PDO::PARAM_INT);
					$stmt->bindParam(':bath',$this->bath, PDO::PARAM_INT);
					$stmt->bindParam(':stories',$this->stories, PDO::PARAM_INT);
					$stmt->bindParam(':garage',$this->garage, PDO::PARAM_INT);
					if(is_null($this->pool)){
						$stmt->bindValue(':pool',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':pool',$this->pool, PDO::PARAM_INT);
					}

					if(is_null($this->spa)){
						$stmt->bindValue(':spa',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':spa',$this->spa, PDO::PARAM_INT);
					}

					$stmt->bindParam(':yearBuilt',$this->yearBuilt, PDO::PARAM_INT);
					if(is_null($this->schoolElementary)){
						$stmt->bindValue(':schoolElementary',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':schoolElementary',$this->schoolElementary, PDO::PARAM_STR);
					}

					if(is_null($this->schoolMiddle)){
						$stmt->bindValue(':schoolMiddle',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':schoolMiddle',$this->schoolMiddle, PDO::PARAM_STR);
					}

					if(is_null($this->schoolHigh)){
						$stmt->bindValue(':schoolHigh',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':schoolHigh',$this->schoolHigh, PDO::PARAM_STR);
					}

					if(is_null($this->sqFtLiving)){
						$stmt->bindValue(':sqFtLiving',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':sqFtLiving',$this->sqFtLiving, PDO::PARAM_INT);
					}

					if(is_null($this->sqFtLot)){
						$stmt->bindValue(':sqFtLot',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':sqFtLot',$this->sqFtLot, PDO::PARAM_INT);
					}

					if(is_null($this->acres)){
						$stmt->bindValue(':acres',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':acres',$this->acres, PDO::PARAM_INT);
					}

					if(is_null($this->parcelNumber)){
						$stmt->bindValue(':parcelNumber',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':parcelNumber',$this->parcelNumber, PDO::PARAM_STR);
					}

					$stmt->bindParam(':lastUpdateDate',$this->lastUpdateDate, PDO::PARAM_STR);
					$stmt->bindParam(':lastUpdateId',$this->lastUpdateId, PDO::PARAM_STR);
				$stmt->execute();
				$this->propertyId = $pdo->lastInsertId();
			}
			if($stmt->rowCount() > 0){
				return $this->get($this->propertyId);
			}else{
				throw new Exception(($this->propertyId > 0 ? "Update" : "Insert") . "  failed.");
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function delete($propertyId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("delete from property where propertyId = :propertyId;");
			$stmt->bindParam(':propertyId',$propertyId, PDO::PARAM_INT);
			$stmt->execute();
			if($stmt->rowCount() == 0){
				throw new Exception("Could not remove Property.");
			}else{
				Return "Property removed successfully.";
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
}
?>
