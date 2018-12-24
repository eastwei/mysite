<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require '../include/login_function.inc';
    require '../../mysqli_connect.php';
    //Check the login
    list($check,$data) = check_login($dbc,$_POST['email'],$_POST['pass']);
    if($check) { //OK!
        //Set the cookies,expire after 1 hour:
        setcookie('user_id', $data['user_id'],time()+3600,'/','',0,0);
        setcookie('first_name', $data['first_name'],time()+3600,'/','',0,0);
    
    //Redirect:jump to new web page
    redirect_user('loggedin.php');
}else {//failed!
    $errors = $data;
	foreach($errors as $msg) {
		echo $msg;
	}
}
mysqli_close($dbc);
}
include ('../include/login_page.inc');
?>
