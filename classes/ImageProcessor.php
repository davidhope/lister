<?php
Class ImageProcessor
{
  private $src = 'imgsrc';
  private $dest = 'imgdest';

  private function delete_files($target){
    if(is_dir($target)){

  		$files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

      foreach( $files as $file ){
          delete_files( $file );
      }

  		if(is_dir($target))	rmdir( $target );

    } elseif(is_file($target)) {
        unlink( $target );
    }
  }


  private function dirToArray($src,$dest) {

  	$result = array();
  	$cdir = scandir($src); //returns array of directory contents

  	foreach ($cdir as $key => $value) {
  		if (!in_array($value,array(".",".."))) {
  			//addFolders($value);

  			if (is_dir($src . DIRECTORY_SEPARATOR . $value)) {
  				dirToArray($src . DIRECTORY_SEPARATOR . $value . DIRECTORY_SEPARATOR, $dest);
  			}  else {
  				buildDestPath($src . $value, $value, explode(DIRECTORY_SEPARATOR,$src)[1], $dest);
  			}
  		}
  	}
  }

  private function buildDestPath($imgsrc, $filename, $basedir, $destroot){
  	//delete optimizer file from $destroot

  	$dirlist =  array('1920'=>array(),'848'=>array('100','200'),'440'=>array());

  	$destroot .= DIRECTORY_SEPARATOR . $basedir;

  	foreach ($dirlist as $key => $value) {
  		$imgsizedir = $destroot . DIRECTORY_SEPARATOR . $key;

  		//create folder for parent
  		addFolders($imgsizedir);

  		resizeImage($imgsrc, $filename, $imgsizedir, $key);

  		if(!empty($value)){
  			foreach($value as $dt=>$dn){
  				addFolders($imgsizedir . DIRECTORY_SEPARATOR . $dn);
  				resizeImage($imgsrc, $filename, $imgsizedir . DIRECTORY_SEPARATOR . $dn, $dn);
  			}
  		}
  	}
  }

  private function addFolders($path){
  	//create directory
  	if(!is_dir($path))
  		mkdir($path, 0777, true);
  }

  private function resizeImage($img, $filename, $dest, $maxwidth){

  	// Get new sizes
  	list($width, $height) = getimagesize($img);
  	$ratio = $width / $height;

  	$newwidth = $maxwidth;
  	$newheight = $height;

  	if($maxwidth < $width){
  		$newheight = round($maxwidth / $ratio);
  	}

  	// Load
  	$thumb = imagecreatetruecolor($newwidth, $newheight);
  	$source = imagecreatefromjpeg($img);

  	// Resize
  	imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

  	// Output
  	imagejpeg($thumb, $dest . DIRECTORY_SEPARATOR . $filename);
  	imagedestroy($thumb);

  }
}

?>
