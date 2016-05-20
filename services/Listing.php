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
      }else{
        try{
    			$lc = new ListingController;
    			$res = $lc->ListListings();
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
