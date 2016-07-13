<?php
    require_once('inc_constants.php');
    require_once('inc_creds.php');

  	foreach (glob(conClassesDir . "/*.php") as $filename)
  	{
      require_once $filename;
  	}
?>
