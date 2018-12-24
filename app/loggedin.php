<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(!isset($_COOKIE['user_id'])) {
    require('../include/login_functions.inc');
    redirect_user();
}
$page_title = '已登陆!';
include('../include/header.html');
?>
<div id="option">
<ol>
<li><a href="upload_picture.php" target="_blank">上传图片到数据库</a></li>
<li><a href="show_multi_pic.php" target="_blank">显示图片</a></li>
<li><a href="image.php" target="_blank">列出文件</a></li>
</ol>
</div>
<?php include('include/footer.html');?>
