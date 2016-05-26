use tlg;

set @class_name = "Listing";
set @table_name = concat(lower(@classname),"s");
set @schema_name = "tlg";
set @keyname = "mls"; /*concat(lcase(left(@class_name,1)), substring(@class_name,2,length(@class_name) - 1),"Id");*/
set @objectname = concat(@class_name, "Info");
set @controllername = concat(@class_name, "Controller");
set @classVar = concat("$",LEFT(lcase(@class_name), 1),"i");
set @controllerVar = concat("$",LEFT(lcase(@class_name), 1),"c");
set @keyVar = "mls";/*concat(LEFT(lcase(@class_name), 1),"id");*/

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
					"	if(!isset($_POST['fn']) && !isset($_GET['fn'])){",
					"		try{",
					concat("			",@controllerVar, " = new ",@controllername,";"),
					concat("			$res = ",@controllerVar,"->List", @class_name,"s();"),
					"			ReturnJsonTable($res);",
					"		}catch(Exception $e){",
					"			ReturnJsonError($e->getMessage());",
					"		}",
					"		exit;",
					"	}")

union all
    
select concat_ws('\n',
					"	if(isset($_GET['fn'])){",
					"		switch ($_GET['fn']){",
					"			case 'Get';",
					"				try{",
					concat("					$",@keyVar," = $_GET['",@keyVar,"'];"),
					concat("					",@controllerVar," = new ",@controllername,";"),
					concat("					$res = ",@controllerVar,"->Get($",@keyVar,");"),			        
					"					ReturnJsonSuccess($res);",
					"				}catch(Exception $e){",
					"					ReturnJsonError($e->getMessage());",
					"				}",				
					"				break;",
					"			default:",
					"				echo \"No Function Found.\";",
					"				break;",
					"		}",
					"	}"
				)

union all

select concat_ws('\n',
					"	if(isset($_POST['fn'])){",
					"		switch ($_POST['fn']){",
					"			case 'Save';",
					"				try{",
					concat("					",@classVar," = new ",@objectname,";"),
					concat("					",@controllerVar," = new ",@controllername,";")
				)

union all

SELECT concat_ws('\n',concat("					",@classVar,"->",COLUMN_NAME," = $_POST['", COLUMN_NAME,"'];"))
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = @schema_name 
    AND TABLE_NAME = @table_name

union all

select concat_ws('\n',
					concat("					$res = ",@controllerVar,"->Save(",@classVar,");"),			        
					"					ReturnJsonSuccess($res);",
					"				}catch(Exception $e){",
					"					ReturnJsonError($e->getMessage());",
					"				}",
				
					"				break;"
				)
union all 

select concat_ws('\n',
					"			case 'Delete';",
					"				try{",
					concat("					$",@keyVar," = $_POST['",@keyVar,"'];"),
					concat("					",@controllerVar," = new ",@controllername,";"),
					concat("					$res = ",@controllerVar,"->Delete($",@keyVar,");"),			        
					"					ReturnJsonSuccess($res);",
					"				}catch(Exception $e){",
					"					ReturnJsonError($e->getMessage());",
					"				}",
					"				break;",
					"			default:",
					"				echo \"No Function Found.\";",
					"				break;",
					"		}",
					"	}"
				)

union all

select "?>"

/* Output to file*/
INTO OUTFILE "C:\\Users\\dhope\\Documents\\Projects\\lister\\services\\Listing.php";