<?php
	include('..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'inc_master.php');
	

	if(isset($_GET['isAuthenticated'])){
		ReturnJsonSuccess($_SESSION['token'] == $_GET['isAuthenticated']);
		//ReturnJsonSuccess('isauthenticated');
		exit;
	}

	if(!isset($_SESSION['token'])){
		//$_SESSION[con_userid] = 'dhope';
		if(isset($_POST['login'])){
			try{	

				$email = $_POST['email'];
				$pass = $_POST['password'];

				$user = new UserInfo;

				$user = $user->AuthenticateUser($email, $pass);
				
				ReturnJsonSuccess($user);

			}catch(Exception $e){
				ReturnJsonError($e->getMessage());
			}
			break;
		}else{
			ReturnUnauthorized();
		}
		exit;
	}else{ //user is logged in
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
				if(isset($_POST['logout'])){
					try{	
						logout();
						ReturnJsonSuccess('Logged Out');
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
			ReturnUnauthorized();
			break;
		}
	}
?>