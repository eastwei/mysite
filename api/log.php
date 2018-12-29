<?php

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
