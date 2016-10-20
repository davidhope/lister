<?php
Class RetsProcessor
{

  public function ProcessFiles(){
    $file = "uploads/listing.txt";// Your Temp Uploaded file
    $cols = array();
    ini_set('auto_detect_line_endings', true);

    $fh = fopen($file, 'r');
    $row = 0;

    if($fh !== false){
      while (($data = fgetcsv($fh, 1000, "\t")) !== false) {

        //skip header row
        if($row > 0){
          $num = count($data);
          echo "<p> $num fields in line $row: <br /></p>\n";

          for ($c=0; $c < $num; $c++) {
              echo $data[$c] . "<br />\n";
          }
        }

        $row++;
      }
    }else{
      echo 'could not open file';
    }
  }
}
