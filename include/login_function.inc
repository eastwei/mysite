<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function redirect_user($page = 'index.php') {
    //start defining the URL...
    //URL is http:// plus the host name plus the current directory:
    $url = 'http://' . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
    //Remove any trailing slashes:
    $url = rtrim($url,'/\\');
    //Add the page:
    $url .= '/'.$page;
    //Redirect the user:
    header("Location: $url");
    exit(); //Quit the script. 
} //end of redirect_user() function.

function check_login($dbc, $email='',$pass='') {
    $errors = array(); //Initialize error array.
    //Validate the email address:
    if (empty($email)) {
        $error[] = 'You forgot to enter your email address.';
    }else {
        $e = mysqli_real_escape_string($dbc,trim($email));
    }
    
    if(empty($pass)) {
        $errors[] = 'You forgot to enter your password.';
    }else {
        $p = mysqli_real_escape_string($dbc,trim($pass));
    }
    
    if(empty($errors)) {
        $q = "SELECT user_id, first_name FROM users "
           . "WHERE email='$e' AND pass=SHA1('$p')";
        $r = mysqli_query($dbc, $q);
        //Run the query.
        //check the result:
        if (mysqli_num_rows($r) == 1) {
            //Fetch the record:
            $row = mysqli_fetch_array($r,MYSQLI_ASSOC);
            //Return true and the record:
            return array(true,$row);
        }else { //Not a match!
            $errors[]='The email address and passwd not match';
        }
    }//End fof empty($errors) IF.
    return array(false,$errors);
} //End of check_login() function.
