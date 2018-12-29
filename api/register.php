<?php

require_once 'db_functions.php';
$db = new db_functions();
$response = array("error" => FALSE);

public function register($name, $email, $password) {

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
