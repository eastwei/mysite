<?php

public function login($email, $password, $dbc) {

	$response = array("error" => FALSE);

	require_once '../include/db_functions.php';

	$db = new db_functions($dbc);

	$user = $db->getUserByEmailAndPassword($email, $password);

	if ($user != false) {

		$response["error"] = FALSE;

		$response["uid"] = $user["unique_id"];

		$response["user"]["name"] = $user["name"];

		$response["user"]["email"] = $user["email"];

		$response["user"]["created_at"] = $user["created_at"];

		$response["user"]["updated_at"] = $user["updated_at"];

		echo json_encode($response);

	} else {

		$response["error"] = TRUE;

		$response["error_msg"] = "Login credentials are wrong. Please try again!";

		echo json_encode($response);

	}
}

?>
