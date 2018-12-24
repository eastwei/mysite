<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!isset($_COOKIE['user_id'])) {
    require '../include/login_functions.inc';
    redirect_user();
}else{
    setcookie('user_id','',time()-3600,'/','',0, 0);
    setcookie('first_name','',time()-3600,'/','',0, 0);
}
$page_title = 'Logged Out!';
include('../include/header.html');

echo "<h1>Logged Out!</h1>"
. "<p>You are now logged out, {$_COOKIE['first_name']}!</p>";

include ('../include/footer.html');
?>
