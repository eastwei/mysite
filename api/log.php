<?php
        class mylog{
                /*输出log*/
                static public function setError($msg) {
                        $str=date("Y-m-d H:i:s");
                        error_log($str."--->".$msg."\n",3,"/var/tmp/php.log");
                }
        }
?>
