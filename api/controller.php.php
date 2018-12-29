<?php


if(file_exists("../../mysqli_connect.php"))
{
	require('../../mysqli_connect.php');

} else {

	$mylog->setError("mysqli_connect.php is not exit \n");
}

require_once('database.php');

require_once('uploadapi.php');

require_once('slideshow.php');

require_once('sendimage.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$content_array = array();

	$content_array = $_SERVER['CONTENT_TYPE'];

	if(in_array("application/json", $content_array)) {

		$json_string = file_get_contents('php://input');

		$client_request = json_decode($json_string,true);
	} 


	$cmd = $client_request->cmd;

	switch ($cmd) {
	case 'get_recoder':
		$id =  $client_request->id;

		$num = $client_request->num;

		$db = new DB($dbc);

		$db->get_recoder_from_db($id,$num);

		break;
	case 'login':
		break;
	case 'register':
		break;
	case 'get_picture':

		$curr = $client_request->curr;

		$ss = new slideshow($dbc);

		$si = new send_image();

		$path = $ss->run($curr);

		$si->send($path,$cmd);

		break;
	case 'upload_picture':

		$up = new upload_image_api($dbc);

		$up->upload();

		break;
	default:
		break;
	}

}

?>
