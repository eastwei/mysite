<?php
/**
* 比较标准的接口输出函数
* @param string  $info 消息
* @param integer $code 接口错误码，很关键的参数
* @param array   $data 附加数据
* $param string  $location 重定向
* @return array
*/
class send_image {

	public function __construct(){
	}

	private function var_json($info = '', $code = 10000, $data = '', $location = '') {
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
		$base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
		return $base64_image;
	}

	public function send($filepath, $cmd) {

		isset($cmd) || $this->var_json('命令不存在', 100001);
		switch ($cmd) {
		case 'show': 
			$base64_img = $this->base64EncodeImage($filepath);
			$this->var_json('success', 0, $base64_img);
			break;
		case 'message':
			$this->var_json('您正在调用动态消息接口', 0);
			break;
		case 'friends':
			$this->var_json('你正在调用好友列表接口', 0);
			break;
		default:
			$this->var_json('非法调用');
		}
	}

}
?>
