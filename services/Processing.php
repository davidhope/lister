<?php
	include('..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'inc_master.php');
	
	$_SESSION['token'] = 'asdf';

	if(!isset($_SESSION['token'])){
		ReturnUnauthorized();
		exit;
	}else{ //user is logged in

		if(isset($_POST['step'])){

			$step = $_POST['step'];
			
			try{	
				$result = shell_exec('..' . DIRECTORY_SEPARATOR . 'test' . $step .  '.pl'); # in linux $result = shell_exec(perl perl.pl)
				echo 'result is: ' . $result;
				exit;
			}catch(Exception $e){
				ReturnJsonError($e->getMessage());
			}
			break;
		}else{
			ReturnJsonError('Invalid Request.');
		}
	}
?>