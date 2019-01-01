<?php
require('../include/db_connect.php');

$db_obj = new db_connect();

$dbc = $db_obj->connect();

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$content_array = explode(';' , $_SERVER['CONTENT_TYPE']);

	if(in_array("application/json" , $content_array)) {

		$json_data = array();

		$client_request = array();

		$json_data = file_get_contents('php://input');

		$client_request = json_decode($json_data,true);

	} 

	$cmd = $client_request['cmd'];


	switch ($cmd) {

	case 'get_recoder':

		func_get_recoders_from_db($client_request, $dbc);

		break;

	case 'login':

		func_user_login($client_request, $dbc);

		break;

	case 'register':

		func_user_register($client_request, $dbc);

		break;

	case 'get_picture':

		func_download_picture($client_request, $dbc);

		break;

	case 'upload_picture':

		func_upload_picture($client_request, $dbc);

		break;

	case 'json_test':

		func_json_test($client_request, $dbc);

		break;

	default:
		break;
	}

}

function func_get_recoders_from_db($request,$dbc) {

	require_once('database.php');

	$id =  $request['id'];

	$num = $request['num'];

	$db = new DB($dbc);

	$db->get_recoder_from_db(intval($id),intval($num));
}

function func_user_login($request,$dbc) {

	$email = $request['email'];

	$password = $request['password'];

	if(empty($email) || empty($password)) {

		$response = array("error" => FALSE);

		$response["error"] = true;

		$response["error_msg"] = "Required parameters email or password or name is empty";

		echo json_encode($response);

	}else {
		require_once 'login.php';

		login($email, $password);
	}
}

function func_user_register($request,$dbc) {

	$name = $request['user_name'];	

	$email = $request['email'];

	$password = $request['password'];

	if(empty($name) || empty($email) || empty($password)) {

		$response = array("error" => FALSE);

		$response["error"] = true;

		$response["error_msg"] = "Required parameters email or password or name is empty";

		echo json_encode($response);

	} else {
		require_once 'register.php';

		register($name, $email, $password);
	}
}

function func_download_picture($request,$dbc) {

	require_once('slideshow.php');

	require_once('sendimage.php');

	$curr = $request['curr'];

	$ss = new slideshow($dbc);

	$si = new send_image();

	$path = $ss->run($curr);

	$si->send($path,$cmd);

}

function func_upload_picture($dbc) {
	
	require_once('uploadapi.php');

	$up = new upload_image_api($dbc);

	$up->upload();
}

function func_json_test() {

	$book = array('a'=>'xiyouji','b'=>'sanguo','c'=>'shuihu','d'=>'hongloumeng');

	$json = json_encode($book);

	echo $json;
}

?>
