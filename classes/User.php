<?php
require_once('JsonDataObject.php');
Class UserInfo extends JsonDataObject
{
	public $userId;
	public $firstName;
	public $lastName;
	public $email;
	public $password;
	public $lastUpdateDate;
	public $lastUpdateId;

  	function __construct($obj = NULL) {
        if(isset($obj)){
            $this->buildFromObject($obj);
        }
    }

    public function buildFromObject($obj){

        $instance = objectToObject($obj,'UserInfo');
        return $instance;
    }
	
	public function getAll(){
    	$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select userId,firstName,lastName,email,lastUpdateDate,lastUpdateId from userinfo;");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function get($userId){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select userId,firstName,lastName,email,lastUpdateDate,lastUpdateId from userinfo where userId = :userId;");
			$stmt->bindParam(':userId',$userId, PDO::PARAM_INT);
			$stmt->execute();
			$user = new UserInfo;
			if($userId > 0){
				$user = $stmt->fetchObject('UserInfo');
			}
			return $user;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	
	public function getByEmail($email){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select userId,firstName,lastName,email,lastUpdateDate,lastUpdateId from userinfo where email = :email;");
			$stmt->bindParam(':email',$email, PDO::PARAM_STR);
			$stmt->execute();
			$user = new UserInfo;
			if($userId > 0){
				$user = $stmt->fetchObject('UserInfo');
			}
			return $user;
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
			if($this->userId > 0){
				$pdo = getPDO();
				$stmt =  $pdo->prepare("update userinfo set
										firstName = :firstName,
										lastName = :lastName,
										email = :email,
										password = MD5(:password),
										lastUpdateDate = now(),
										lastUpdateId = :lastUpdateId,
											where userId = :userId;");

				$stmt->bindParam(':userId', $this->userId, PDO::PARAM_INT);
				$stmt->bindParam(':firstName',$this->firstName, PDO::PARAM_STR);
				$stmt->bindParam(':lastName',$this->lastName, PDO::PARAM_STR);
				$stmt->bindParam(':email',$this->email, PDO::PARAM_STR);
				$stmt->bindParam(':password',$this->password, PDO::PARAM_STR);
				$stmt->bindParam(':lastUpdateId',$this->lastUpdateId, PDO::PARAM_STR);
				$stmt->execute();
			}else{
				$pdo = getPDO();
				$stmt =  $pdo->prepare("insert into userinfo(firstName,lastName,email,password,lastUpdateDate,lastUpdateId)
									values(:firstName,:lastName,:email,MD5(:password),now(),:lastUpdateId);");

				$stmt->bindParam(':firstName',$this->firstName, PDO::PARAM_STR);
				$stmt->bindParam(':lastName',$this->lastName, PDO::PARAM_STR);
				$stmt->bindParam(':email',$this->email, PDO::PARAM_STR);
				$stmt->bindParam(':password',$this->password, PDO::PARAM_STR);
				$stmt->bindParam(':lastUpdateId',$this->lastUpdateId, PDO::PARAM_STR);

				$stmt->execute();
				$this->userId = $pdo->lastInsertId();
			}
			if($stmt->rowCount() > 0){
				return $this->get($this->userId);
			}else{
				throw new Exception(($this->userId > 0 ? "Update" : "Insert") . "  failed.");
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	
	public function AuthenticateUser($email, $password){
		$pdo;
		$stmt;

		try {
			$pdo = getPDO();

			$stmt =  $pdo->prepare('select userId,firstName,lastName,email,password,lastUpdateDate,lastUpdateId
				  					from userinfo u
				  					where email = :email
				  					and password = MD5(:password);');

			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->bindParam(':password', $password, PDO::PARAM_STR);

			$stmt->execute();

			if($stmt->rowCount() > 0){
				$user = $stmt->fetchObject('UserInfo');

				$_SESSION[con_userid] = $user->userId;
				$_SESSION[con_timeout] = time() + con_timeoutlength;

				return $user;
			}else{
				throw new Exception('Authentication failed.');
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
}
?>
