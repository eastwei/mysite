<?php
        class mylog{
                /*send out log to file*/
		static public function setError($msg) {

			$time_str=date("Y-m-d H:i:s");
			error_log($time_str."--->".$msg."\n",3,"/var/tmp/php.log");
		}
		/*send log to client*/
		static public function var_json($info = '', $code = 10000, $data = '', $location = '') {

			$out['code'] = $code ?: 0;
			$out['info'] = $info ?: ($out['code'] ? 'error' : 'success');
			$out['data'] = $data ?: '';
			$out['location'] = $location;
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($out, JSON_HEX_TAG);
			exit(0);
		}
        }
?>
