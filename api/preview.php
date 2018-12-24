<?php
require('../../mysqli_connect.php'); 
require('slideshow.php');
require('sendimage.php');
require('log.php');

$log = new mylog();
$cmd = empty($_GET['cmd']) ? '' : ($_GET['cmd']);
$log->setError("cmd=".$cmd);
if (isset($_GET['img']))
{
	if (preg_match('/^[0-9]+$/', $_GET['img'])) 
		$curr = (int) $_GET['img'];
}
$ss = new slideshow($dbc);
$si = new send_image();
$log->setError("curr=".$curr);
$path = $ss->run($curr);
$log->setError("path=".$path);
$si->send($path,$cmd);
?>
