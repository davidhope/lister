<?php

class testclass{
  public $name;

  function __construct($obj = NULL) {
		if(is_object($obj)){
	     $this->name = $obj->name; //$this->buildFromObject($obj);
       //LoadObj($obj);
		}else{
	     $this->name = 'Fred';
		}
	}

  function LoadObj($obj){
    return true;
    //$this = $obj;
  }
}

class testtwo{
  public $name;
}

$two = new testtwo;
$two->name = 'john';

$instance = new testclass();

var_dump($two);

echo '<br />';

var_dump($instance);

echo '<br />';

$instance = clone $two;

var_dump($instance);

?>
