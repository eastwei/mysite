<?php


if(file_exists("../../mysqli_connect.php"))
{
	require('../../mysqli_connect.php');

} else {

	$mylog->setError("mysqli_connect.php is not exit \n");
}

require('database.php');

echo "connect data base ok \n";

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$id = 2;

	$db = new DB($dbc);

	$db->run($id);
}
?>
