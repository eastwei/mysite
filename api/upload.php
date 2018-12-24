<?php 
require('../../mysqli_connect.php'); 
require('uploadapi.php');
//check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$up = new upload_image_api($dbc);
	$up->upload();
}
?>
