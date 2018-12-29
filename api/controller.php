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

	$json_data = array();

	$content_array = explode(':' , $_SERVER['CONTENT_TYPE']);

	if(in_array("application/json" , $content_array)) {

		$json_data = file_get_contents('php://input');

		$client_request = json_decode($json_data,true);
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

		$email = $client_request->email;

		$password = $client_request->password;

		if(empty($email) || empty($password)) {

			$response = array("error" => FALSE);

			$response["error"] = true;

			$response["error_msg"] = "Required parameters email or password or name is empty";

			echo json_encode($response);

		}else {
			require_once 'login.php';

			login($email, $password);
		}
		break;

	case 'register':

		$name = $client_request->user_name;	

		$email = $client_request->email;

		$password = $client_request->password;

		if(empty($name) || empty($email) || empty($password)) {

			$response = array("error" => FALSE);

			$response["error"] = true;

			$response["error_msg"] = "Required parameters email or password or name is empty";

			echo json_encode($response);

		} else {
			require_once 'register.php';

			register($name, $email, $password);
		}
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
