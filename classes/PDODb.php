<?php
	
	set_exception_handler('logPDOError');

	function getPDO(){
		try{
            $pdo = new PDO(con_dbConn, con_dbUser, con_dbPass, array(PDO::ATTR_PERSISTENT => true));
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
			return $pdo;
		} catch (PDOException $e) {
			print "getPDO Error!: " . $e->getMessage() . "<br/>";
			die();
		}
	}
	
	function ClosePDOConnection($stmt,$conn){
        $stmt = null;
		$conn = null;
    }
	
	function logPDOError($msg){

		$conn;
		$stmt;

		try {
			
			/**/
			$pdo = getPDO();
            $errNum = 1;
            
			$stmt =  $pdo->prepare('Insert into ErrorLogs(Number,Message,Timestamp) VALUES(:Num,:ErrorMessage,now()');
			$stmt->bindParam(':Num',$errNum, PDO::PARAM_INT);
			$stmt->bindParam(':ErrorMessage',$msg, PDO::PARAM_STR);
			
			$stmt->execute();

			$arr = array("SvcError"=>array("ErrMessage"=>$msg));
            print json_encode($arr);
			
		}catch(PDOException $e){
			print "logPDOError PDO Error!: " . $e->getMessage() . "<br/>";
			die();
		}catch(Exception $e){
			print "logPDOError Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		
		if(isset($stmt) && isset($conn)){
			CloseConnection($stmt,$conn);
		}
	}
	
?>