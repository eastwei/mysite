<?php
$page_title = 'upload picture';
include ('../include/header.html');
//connect to the db.
require('../../mysqli_connect.php'); 
require('uploadimage.php');
//check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$up = new UploadImage($dbc);
	$up->upload();
	$up->saveImage();
	$up->printError();
}
include ('../include/footer.html');
?>
<h1>上传图片</h1>
<form action="upload_picture.php" method="post" enctype="multipart/form-data">
    <p>caption:<input type="text" name="caption" size="20" maxlength="60"/></p>
    <p>picture:<input type="file" name="photo"/></p>
    <p><input type="submit" name="submit" value="upload"/></p>
</form>
<?php include('../include/footer.html')?>
 
