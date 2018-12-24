<?php
$filename = empty($_GET['filename'])?'':$_GET['filename'];
$dir = '../uploads';
$files = scandir($dir);
 foreach($files as $image) {
	 if(strcasecmp($image,$filename)==0) {
		 header("Content-type:image/jpg");
		 $img = imagecreatefromjpeg("../uploads/".$filename);
		 imagejpeg($img);
		 imagedestroy($img);
	 }
 }
 ?>
