<?php
	require_once('JsonDataObject.php');
Class Agent extends JsonDataObject
{
	public $agentId;
	public $userId;
	/*single and nullable objects*/
	public $userinfo;
	/*arrays of objects*/
	public $listing;
	/*rest of unkeyed columns*/
	public $bio;
	public $twitter;
	public $facebook;
	public $linkedIn;
	public $lastUpdateDate;
	public $lastUpdateId;
  function __construct() {}
	public function getAll(){
    $pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select agentId,userId,bio,twitter,facebook,linkedIn,lastUpdateDate,lastUpdateId from agent;");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function get($agentId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select agentId,userId,bio,twitter,facebook,linkedIn,lastUpdateDate,lastUpdateId from agent where agentId = :agentId;");
			$stmt->bindParam(':agentId',$agentId, PDO::PARAM_INT);
			$stmt->execute();
			$Agent = new Agent;
			if($agentId > 0){
				$Agent = $stmt->fetchObject('Agent');
				/*	single and nullable objects*/
				$userinfo = new Userinfo();
				$Agent->userinfo =  $userinfo->get($Agent->userinfoId);
				/*arrays of objects*/
				$listing = new Listing();
				$Agent->listing =  $listing->getByAgent($Agent->$agentId);
			}
			return $Agent;
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
			if($this->agentId > 0){
					$pdo = getPDO();
					$stmt =  $pdo->prepare("update agent set
											userId = :userId,
											bio = :bio,
											twitter = :twitter,
											facebook = :facebook,
											linkedIn = :linkedIn,
											lastUpdateDate = :lastUpdateDate,
											lastUpdateId = :lastUpdateId,
 											where agentId = :agentId;");
					$stmt->bindParam(':agentId', $this->agentId, PDO::PARAM_INT);
					$stmt->bindParam(':userId',$this->userId, PDO::PARAM_INT);
					if(is_null($this->bio)){
						$stmt->bindValue(':bio',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':bio',$this->bio, PDO::PARAM_STR);
					}

					if(is_null($this->twitter)){
						$stmt->bindValue(':twitter',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':twitter',$this->twitter, PDO::PARAM_STR);
					}

					if(is_null($this->facebook)){
						$stmt->bindValue(':facebook',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':facebook',$this->facebook, PDO::PARAM_STR);
					}

					if(is_null($this->linkedIn)){
						$stmt->bindValue(':linkedIn',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':linkedIn',$this->linkedIn, PDO::PARAM_STR);
					}

					$stmt->bindParam(':lastUpdateDate',$this->lastUpdateDate, PDO::PARAM_STR);
					$stmt->bindParam(':lastUpdateId',$this->lastUpdateId, PDO::PARAM_STR);
					$stmt->execute();
			}else{
					$pdo = getPDO();
				$stmt =  $pdo->prepare("insert into agent(userId,bio,twitter,facebook,linkedIn,lastUpdateDate,lastUpdateId)values(:userId,:bio,:twitter,:facebook,:linkedIn,:lastUpdateDate,:lastUpdateId);");
					$stmt->bindParam(':userId',$this->userId, PDO::PARAM_INT);
					if(is_null($this->bio)){
						$stmt->bindValue(':bio',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':bio',$this->bio, PDO::PARAM_STR);
					}

					if(is_null($this->twitter)){
						$stmt->bindValue(':twitter',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':twitter',$this->twitter, PDO::PARAM_STR);
					}

					if(is_null($this->facebook)){
						$stmt->bindValue(':facebook',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':facebook',$this->facebook, PDO::PARAM_STR);
					}

					if(is_null($this->linkedIn)){
						$stmt->bindValue(':linkedIn',NULL, PDO::PARAM_INT);
					} else {
						$stmt->bindParam(':linkedIn',$this->linkedIn, PDO::PARAM_STR);
					}

					$stmt->bindParam(':lastUpdateDate',$this->lastUpdateDate, PDO::PARAM_STR);
					$stmt->bindParam(':lastUpdateId',$this->lastUpdateId, PDO::PARAM_STR);
				$stmt->execute();
				$this->agentId = $pdo->lastInsertId();
			}
			if($stmt->rowCount() > 0){
				return $this->get($this->agentId);
			}else{
				throw new Exception(($this->agentId > 0 ? "Update" : "Insert") . "  failed.");
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function delete($agentId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("delete from agent where agentId = :agentId;");
			$stmt->bindParam(':agentId',$agentId, PDO::PARAM_INT);
			$stmt->execute();
			if($stmt->rowCount() == 0){
				throw new Exception("Could not remove Agent.");
			}else{
				Return "Agent removed successfully.";
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
}
?>
