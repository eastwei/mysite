<?php


function set_error($msg) {

	$time_str=date("Y-m-d H:i:s");
	error_log($time_str."--->".$msg."\n",3,"/var/tmp/php.log");
}

public function register($name, $email, $password,$dbc) {

	$response = array("error" => FALSE);

	set_error("enter register");

	$db = new db_functions($dbc);

	if($db->isUserExisted($email)) {
		$response["error"] = TRUE;
		$response["error_msg"] = "User already existed with" . $email;
		echo json_encode($response);
	}else {
		$user = $db->storeUser($name, $email, $password);
		if ($user) {
			//user stored sucessfully
			$response["error"] = FALSE;
			$response["uid"] = $user["unique_id"];
			$response["user"]["name"] = $user["name"];
			$response["user"]["email"] = $user["emial"];
			$response["user"]["created_at"] = $user["created_at"];
			$response["user"]["updated_at"] = $user["updated_at"];
			echo json_encode($reponse);
		}else {
			$response["error"] = TRUE;
			$response["error_msg"] = "Unknown error occurred in registration!";
			echo json_encode($response);
		}
	}

}
?>
