<?php


class Send_Image {


	public function __construct(){

	}


	//format informat to json and send to client
	private function var_json($info = '', $code = 10000, 
		                              $data = '', $location = '') {

		$out['code'] = $code ?: 0;
		$out['info'] = $info ?: ($out['code'] ? 'error' : 'success');
		$out['data'] = $data ?: '';
		$out['location'] = $location;

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($out, JSON_HEX_TAG);

		exit(0);

	}

	private function base64EncodeImage ($image_file) {
		$base64_image = '';

		$image_info = getimagesize($image_file);

		$image_data = fread(fopen($image_file, 'r'), filesize($image_file));

		$base64_image = 'data:' . $image_info['mime'] 
			        . ';base64,' . chunk_split(base64_encode($image_data));

		return $base64_image;
	}

	public function send($filepath, $cmd) {

		isset($cmd) || $this->var_json('cmd is not set', 100001);
		switch ($cmd) {
		case 'show': 
			$base64_img = $this->base64EncodeImage($filepath);
			$this->var_json('success', 0, $base64_img);
			break;
		default:
			$this->var_json('not support this command');
		}
	}

}
?>
