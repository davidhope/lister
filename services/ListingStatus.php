<?php
	include('..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'inc_master.php');
	if(!isset($_SESSION[con_userid])){
		ReturnJsonError("Session expired");
		exit;
	}
	switch ($_SERVER['REQUEST_METHOD']){
		case 'GET';
			if(isset($_GET['id'])){
				try{
					$id = $_GET['id'];
					$obj = new ListingStatus;
					$res = $obj->get($id);
					ReturnJsonSuccess($res);
				}catch(Exception $e){
					ReturnJsonError($e->getMessage());
				}
			}else{
				try{
					$obj = new ListingStatus;
					$res = $obj->getAll();
					ReturnJsonSuccess($res);
				}catch(Exception $e){
					ReturnJsonError($e->getMessage());
				}
			}
			break;
		case 'POST';
			try{
				$obj = new ListingStatus;
				$post = file_get_contents('php://input');
				$obj = json_decode($post);
				$res = $obj->save();
				ReturnJsonSuccess($res);
			}catch(Exception $e){
				ReturnJsonError($e->getMessage());
			}
			break;
  	case 'DELETE';
			try{
				$id = $_POST['id'];
				$obj = new ListingStatus;
				$res = $obj->delete($id);
				ReturnJsonSuccess($res);
			}catch(Exception $e){
				ReturnJsonError($e->getMessage());
			}
			break;
    default:
			echo 'No Function Found.';
			break;
	}
?>
