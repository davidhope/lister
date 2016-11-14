<?php
	include('..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'inc_master.php');
	

	if(isset($_GET['isAuthenticated'])){
		if(isset($_SESSION['token']) && isset($_GET['token'])){
			ReturnJsonSuccess($_SESSION['token'] == $_GET['token']);
		}else{
			ReturnJsonSuccess(false);
		}
		exit;
	}

	if(isset($_GET['login'])){
		try{	

			$req = json_decode(file_get_contents('php://input'));

			$email = $req->email;
			$pass = $req->password;

			$user = new UserInfo;

			$user = $user->AuthenticateUser($email, $pass);
			
			ReturnJsonSuccess($user);

		}catch(Exception $e){
			ReturnJsonError($e->getMessage());

		}
		exit;
	}

	if(isset($_GET['logout'])){
		try{	
			logout();
			ReturnJsonSuccess('Logged Out');
		}catch(Exception $e){
			ReturnJsonError($e->getMessage());
		}
		exit;
	}

	if(isset($_SESSION['token'])){
		//$_SESSION[con_userid] = 'dhope';
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
	    default:
			ReturnUnauthorized();
			break;
		}
	}
?>