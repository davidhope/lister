<?php
	include('..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'inc_master.php');

	if(!isset($_SESSION[con_userid])){
    $_SESSION[con_userid] = 'dhope';
		//ReturnJsonError("Session expired");
		//exit;
	}
	switch ($_SERVER['REQUEST_METHOD']){
		case 'GET';
			if(isset($_GET['id'])){
				try{
					$id = $_GET['id'];
					$obj = new Listing;
					$res = $obj->get($id);
					ReturnJsonSuccess($res);
				}catch(Exception $e){
					ReturnJsonError($e->getMessage());
				}
			}elseif(isset($_GET['statusTypeId'])){
						try{
							$statusTypeId = $_GET['statusTypeId'];
							$obj = new Listing;
							$res = $obj->getByListingStatus($statusTypeId);
							ReturnJsonSuccess($res);
						}catch(Exception $e){
							ReturnJsonError($e->getMessage());
						}
			}else{
				try{
					$obj = new Listing;
					$res = $obj->getAll();
					ReturnJsonSuccess($res);
				}catch(Exception $e){
					ReturnJsonError($e->getMessage());
				}
			}
			break;
		case 'POST';
			try{
				//$listing = new Listing;
				$post = file_get_contents('php://input');
				$obj = json_decode($post);

				$listing = new Listing;
				$listing = $listing->buildFromObject($obj);
				
				/*
				$listing = objectToObject($obj,'Listing');
				$listing->property = objectToObject($listing->property,'Property');
				$listing->listingstatus = objectToObject($listing->listingstatus,'ListingStatus');
				*/
				/*
				$listing->listingId = $obj->listingId;
				$listing->propertyId = $obj->propertyId;
				$listing->agentId = $obj->agentId;
				$listing->saleId = $obj->saleId;
				$listing->mls = $obj->mls;
				$listing->title = $obj->title;
				$listing->descriptionShort = $obj->descriptionShort;
				$listing->descriptionLong = $obj->descriptionLong;
				$listing->publicRemarks = $obj->publicRemarks;
				$listing->marketingId = $obj->marketingId;
				$listing->youTubeId = $obj->youTubeId;
				$listing->shortSale = $obj->shortSale;
				$listing->featured = $obj->featured;
				$listing->frontPage = $obj->frontPage;
				*/

				//var_dump($listing);
				$res = $listing->save();
				ReturnJsonSuccess($res);
			}catch(Exception $e){
				ReturnJsonError($e->getMessage());
			}
			break;
  	case 'DELETE';
			try{
				$id = $_POST['id'];
				$obj = new Listing;
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
