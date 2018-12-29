<?php

$contentType = explode(';', $_SERVER['CONTENT_TYPE']); // Check all available Content-Type
$rawBody = file_get_contents("php://input"); // Read body
$data = array(); // Initialize default data array

if(in_array('application/json', $contentType)) { // Check if Content-Type is JSON
	$data = json_decode($rawBody); // Then decode it
} else {
	parse_str($data, $data); // If not JSON, just do same as PHP default method
}


header('Content-Type: application/json; charset=UTF-8');
echo json_encode(array( // Return data
	'data' => $data
));

/*send out log to file*/
static public function setError($msg) {

	$time_str=date("Y-m-d H:i:s");
	error_log($time_str."--->".$msg."\n",3,"/var/tmp/php.log");
}

?>
