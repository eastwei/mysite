<?php 
#图片上传到指定的目录
if(!isset($_COOKIE['user_id'])) {
    require('include/login_functions.inc');
    redirect_user();
}
$page_title = 'upload';
include ('include/header.html');
//Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Check for an uploaded file:
    if (isset($_FILES['upload'])) {
        //Validate the type.Should be JPEG or PNG.
        $allowed = array('image/pjpeg','image/jpeg','image/JPG','image/X-PNG',
            'image/PNG','image/png','image/x-png');
        if (in_array($_FILES['upload']['type'],$allowed)) {
            //Move the file over.
            if (move_uploaded_file($_FILES['upload']['tmp_name'],
                    "../uploads/{$_FILES['upload']['name']}")) {
                echo '<p><em>The file has been uploaded!</em></p>';
            }//End of move... IF.
        }else {//Invalid type.
            echo '<p class="error"> Please upload a JPGE or PNG image.</p>';
        }
    }//End of isset($_FILES['upload']) IF.
    //Delete the file if it still exits:
    if(file_exists($_FILES['upload']['tmp_name'])&&
            is_file($_FILES['upload']['tmp_name'])){
        unlink ($_FILES['upload']['tmp_name']);
    }
}//End of the submitted conditional.
?>
<form enctype="multipart/form-data" action="upload_image.php" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="524288" />
    <fieldset><legend>Select a JPEG or PNG image of 512KB or smaller:</legend>
        <p><b>File:</b><input type ="file" name="upload" /></p>
    </fieldset>
    <div align="center"><input type="submit" name="submit" value="Submit"/></div>       
</form>
</body>
</html>
<?php include ('include/footer.html'); ?>
