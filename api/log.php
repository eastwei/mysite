<?php
class mylog{
	/*输出log*/
static public function setError($msg) {
		error_log("slideshow.php ".$msg."\n",3,'/home/weidong/php.log');
	}
}
?>
