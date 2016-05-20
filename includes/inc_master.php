<?php

    require_once('inc_constants.php');
    //require_once(conClassesDir . DIRECTORY_SEPARATOR . 'PDODb.php');
    //require_once(conClassesDir . DIRECTORY_SEPARATOR . 'functions.php');

  	foreach (glob(conClassesDir . "/*.php") as $filename)
  	{
      /*
      if($filename != conClassesDir . DIRECTORY_SEPARATOR . 'PDODb.php' && $filename != conClassesDir . DIRECTORY_SEPARATOR . 'functions.php'){
        require_once $filename;
      }
      */
      require_once $filename;
  	}
?>
