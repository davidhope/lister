<?php
	include('..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'inc_master.php');
	if(!isset($_SESSION[con_userid])){
		$_SESSION[con_userid] = 'dhope';
		//ReturnUnauthorized();
		exit;
	}

	switch ($_SERVER['REQUEST_METHOD']){
		case 'GET';
			if(isset($_GET['id'])){
				try{
					$id = $_GET['id'];
					$obj = new UserInfo;
					$res = $obj->get($id);
					ReturnJsonSuccess($res);
				}catch(Exception $e){
					ReturnJsonError($e->getMessage());
				}
			}else{
				try{
					$obj = new UserInfo;
					$res = $obj->getAll();
					ReturnJsonSuccess($res);
				}catch(Exception $e){
					ReturnJsonError($e->getMessage());
				}
			}
			break;
		case 'POST';
			if(isset($_POST['login'])){
				try{	

					$email = $_POST['email'];
					$pass = $_POST['password'];

					$user = new UserInfo;

					//if(1 == 0){
					$user = $user->AuthenticateUser($email, $pass);
					
					if($user->userId > 0){
						ReturnJsonSuccess($user);
					}else{
						ReturnUnauthorized();
					}
					
				}catch(Exception $e){
					ReturnJsonError($e->getMessage());
				}
				break;
			}elseif(isset($_POST['logout'])){
				try{	

					logout();

					ReturnUnauthorized();
					
				}catch(Exception $e){
					ReturnJsonError($e->getMessage());
				}
				break;
			}else{
				try{
					$obj = new UserInfo;
					$post = file_get_contents('php://input');
					$obj = json_decode($post);
					$res = $obj->save();
					ReturnJsonSuccess($res);
				}catch(Exception $e){
					ReturnJsonError($e->getMessage());
				}
				break;
			}
    default:
		echo 'No Function Found.';
		break;
	}
?>