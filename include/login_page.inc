<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Inxclude the header:
$page_title = 'Login';
include ('include/header.html');
?>
<div id="LoginForm">
<form action="login.php" method="post">
<table align=center>
	<tr>
    <td>Email Address:</td>
	<td><input type="text" name="email" id="useremail" size="20" maxlength="60"/></td>
    </tr>
    <tr>
	<td>Password:</td>
    <td><input type="password" name="pass" id="userpwd" size="20" maxlength="20"/></td>
    </tr>
    <tr>
	<td colspan=2 align=center><input type="submit" name="submit" value="Login" /></td>
    </tr>
</table>
</form> 
</div>
<?php include ('include/footer.html'); ?>

