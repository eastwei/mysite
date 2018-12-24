<?php
if(file_exists("../../mysqli_connect.php"))
{
	require('../../mysqli_connect.php');
}
require('log.php');
require('database.php');
$log = new mylog();
$db = new DB($dbc);
$db->run();
?>
