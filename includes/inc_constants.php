<?php
  $devBranch = 'C:\Users\dhope\Documents\Projects\lister';

	define("con_userid", "userid");
  define("con_userName", "userName");
	define("con_timeout", "timeout");
	define("con_timeoutlength", 1200);

  if (strrpos($_SERVER["SERVER_SOFTWARE"],"Microsoft") === false){
    /*Production */

    define("con_dbConn", "mysql:host=localhost;dbname=tlg");
    define("con_dbUser","tlg_webuser");
    define("con_dbPass","Lir5,bwiomic.");

	  define("conAppRoot",$_SERVER['DOCUMENT_ROOT']);
	  define("conClassesDir",$_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'classes');
	  define("conTemplatesDir",$_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'templates');
	  define("conIncludesDir",$_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'includes');
	  define("conSvcDir",$_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'svc');
    define("con_TestMode",false);

  }else{
    /*Development*/

    define("con_dbConn", "mysql:host=localhost;dbname=tlg");
    define("con_dbUser","root");
    define("con_dbPass","ftcnj25");

	  define("conAppRoot",$devBranch);
	  define("conIncludesDir",$devBranch . DIRECTORY_SEPARATOR . 'includes');
	  define("conClassesDir",$devBranch . DIRECTORY_SEPARATOR . 'classes');
	  define("conSvcDir",$devBranch . DIRECTORY_SEPARATOR . 'services');
    define("con_TestMode",true);
  }

?>
