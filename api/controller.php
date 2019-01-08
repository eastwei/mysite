<?php
require_once '../include/db_connect.php';

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

  function set_error($msg) {

	$time_str=date("Y-m-d H:i:s");
	error_log($time_str."--->".$msg."\n",3,"/var/tmp/php.log");
}

function func_get_recoders_from_db($request,$dbc) {

	require_once('database.php');

	$id =  $request['id'];

	$num = $request['num'];

	$db = new DB($dbc);

	$db->get_recoder_from_db(intval($id),intval($num));
}

function login($email, $password, $dbc) {

	//$response = array("error" => FALSE);
	$response = array("status" => 0);

	require_once('../include/db_functions.php');

	set_error("enter login");

	$db = new db_functions($dbc);

	set_error("create db");
	$user = $db->getUserByEmailAndPassword($email, $password);

	set_error("get user");
	if ($user != false) {

		//$response["error"] = FALSE;

		//$response["uid"] = $user["unique_id"];

		//$response["user"]["name"] = $user["name"];

		//$response["user"]["email"] = $user["email"];

		//$response["user"]["created_at"] = $user["created_at"];

		//$response["user"]["updated_at"] = $user["updated_at"];

		$response["full_name"] = "weidong";
		echo json_encode($response);

	} else {

		//$response["error"] = TRUE;

		//$response["error_msg"] = "Login credentials are wrong. Please try again!";

		$response["status"] = 1;
		$response["message"] = "Login credentials are wrong. Please try again!";
		echo json_encode($response);

	}
}

function func_user_login($request,$dbc) {

	//$response = array("error" => FALSE);

	$response = array("status" => 0);

	$email = $request['email'];

		set_error($email);
	$password = $request['password'];

		set_error($password);
	if(empty($email) || empty($password)) {

		//$response["error"] = true;

		//$response["error_msg"] = "Required parameters email or password or name is empty";

		$response["status"] = 1;

		$response["message"] = "Required parameters email or password or name is empty";
		echo json_encode($response);

	}else {

		login($email, $password, $dbc);
	}
}

function register($name, $email, $password,$dbc) {

	$response = array("status" => 0);

	require_once ('../include/db_functions.php');

	$db = new db_functions($dbc);

	set_error("create object register");

	if($db->isUserExisted($email)) {
		set_error(" isUserExisted");
		$response["status"] = 1;
		//$response["error"] = TRUE;
		//$response["error_msg"] = "User already existed with" . $email;
		echo json_encode($response);
	}else {
		set_error("not isUserExisted");
		$user = $db->storeUser($name, $email, $password);
		if ($user) {
			//user stored sucessfully
			//$response["error"] = FALSE;
			//$response["uid"] = $user["unique_id"];
			//$response["user"]["name"] = $user["name"];
			//$response["user"]["email"] = $user["emial"];
			//$response["user"]["created_at"] = $user["created_at"];
			//$response["user"]["updated_at"] = $user["updated_at"];
			echo json_encode($reponse);
		}else {
			$response["status"] = 2;
			$response["message"] = "Unknown error occurred in registration!";
			//$response["error"] = TRUE;
			//$response["error_msg"] = "Unknown error occurred in registration!";
			echo json_encode($response);
		}
	}
}

function func_user_register($request,$dbc) {


	$name = $request['user_name'];	

	$email = $request['email'];

	$password = $request['password'];

	set_error($name);
	set_error($email);
	set_error($password);

	if(empty($name) || empty($email) || empty($password)) {

		$response = array("error" => FALSE);

		$response["error"] = true;

		$response["error_msg"] = "Required parameters email or password or name is empty";

		echo json_encode($response);

	} else {
		register($name, $email, $password, $dbc);
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
