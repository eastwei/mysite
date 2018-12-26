<?php

require('log.php');

class send_image {

	$log = new mylog();

	public function __construct(){

	}



	private function base64EncodeImage ($image_file) {
		$base64_image = '';

		$image_info = getimagesize($image_file);

		$image_data = fread(fopen($image_file, 'r'), filesize($image_file));

		$base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));

		return $base64_image;
	}

	public function send($filepath, $cmd) {

		isset($cmd) || $log->var_json('cmd is not set', 100001);
		switch ($cmd) {
		case 'show': 
			$base64_img = $this->base64EncodeImage($filepath);
			$log->var_json('success', 0, $base64_img);
			break;
		default:
			$log->var_json('not support this command');
		}
	}

}
?>
