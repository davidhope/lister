<?php
	include('..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'inc_master.php');

	if(!isset($_SESSION[con_userid])){
    $_SESSION[con_userid] = 'dhope';
		//ReturnJsonError("Session expired");
		//exit;
	}
  switch ($_SERVER['REQUEST_METHOD']){
    case 'GET';
      if(isset($_GET['mls'])){
        try{
          $mls = $_GET['mls'];
          $lc = new ListingController;
          $res = $lc->Get($mls);
          ReturnJsonSuccess($res);
        }catch(Exception $e){
          ReturnJsonError($e->getMessage());
        }
      }elseif(isset($_GET['status']){
        try{
          $statusId = $_GET['status'];
          $lc = new ListingController;
          $res = $lc->GetByStatus($statusId);
          ReturnJsonSuccess($res);
        }catch(Exception $e){
          ReturnJsonError($e->getMessage());
        }
      }else{
        try{
    			$lc = new ListingController;
    			$res = $lc->GetAll();
    			//ReturnJsonTable($res);
          ReturnJsonSuccess($res);
    		}catch(Exception $e){
    			ReturnJsonError($e->getMessage());
    		}
      }
      break;
    case 'POST';
      try{
        $li = new Listing;
        $lc = new ListingController;
        $post = file_get_contents('php://input');

        $li = json_decode($post);

        //var_dump($li);
        $res = $lc->Save($li);

        ReturnJsonSuccess($res);

      }catch(Exception $e){
        ReturnJsonError($e->getMessage());
      }
      break;
    case 'DELETE';
      try{
        $mls = $_POST['mls'];
        $lc = new ListingController;
        $res = $lc->Delete($mls);
        ReturnJsonSuccess($res);
      }catch(Exception $e){
        ReturnJsonError($e->getMessage());
      }
      break;
    default:
      echo "No Function Found.";
      break;
  }
?>
