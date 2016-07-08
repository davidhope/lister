set @schema_name = 'tlg_v2';
set @classname = 'ListingPrice';
set @table_name = lower(@classname);
use `tlg_v2`;

select @keyname := parentTable.COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS as parentTable
WHERE parentTable.TABLE_SCHEMA = @schema_name 
    AND parentTable.TABLE_NAME = @table_name
    and parentTable.column_key = 'PRI';

select "<?php"

union all

select "	include('..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'inc_master.php');"

union all 

select concat_ws('\n',
"	if(!isset($_SESSION[con_userid])){",
"		ReturnJsonError(\"Session expired\");",
"		exit;",
"	}")

union all

select concat_ws('\n',
"	switch ($_SERVER['REQUEST_METHOD']){",
"		case 'GET';",
"			if(isset($_GET['id'])){",
"				try{",
concat("					$id = $_GET['id'];"),
concat("					$obj = new ",@classname,";"),
concat("					$res = $obj->get($id);"),
"					ReturnJsonSuccess($res);",
"				}catch(Exception $e){",
"					ReturnJsonError($e->getMessage());",
"				}",
"			}else{",
"				try{",
concat("					$obj = new ",@classname,";"),
"					$res = $obj->getAll();",
"					ReturnJsonSuccess($res);",
"				}catch(Exception $e){",
"					ReturnJsonError($e->getMessage());",
"				}",
"			}",
"			break;",
"		case 'POST';",
"			try{",
concat("				$obj = new ",@classname,";"),
"				$post = file_get_contents('php://input');",
"				$obj = json_decode($post);",
"				$res = $obj->save();",
"				ReturnJsonSuccess($res);",
"			}catch(Exception $e){",
"				ReturnJsonError($e->getMessage());",
"			}",
"			break;",
"  	case 'DELETE';",
"			try{",
concat("				$id = $_POST['id'];"),
concat("				$obj = new ",@classname,";"),
concat("				$res = $obj->delete($id);"),
"				ReturnJsonSuccess($res);",
"			}catch(Exception $e){",
"				ReturnJsonError($e->getMessage());",
"			}",
"			break;",
"    default:",
"			echo 'No Function Found.';",
"			break;",
"	}")

union all 

select "?>"

/* Output to file work*/
INTO OUTFILE "C:\\Users\\dhope\\Documents\\Projects\\lister\\services\\ListingPrice.php";
/* Output to file home
INTO OUTFILE "H:\\Projects\\lister\\services\\Sale.php";*/