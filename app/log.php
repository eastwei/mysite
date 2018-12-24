<?php
function save_log($path, $msg)  
{  
    if (! is_dir($path)) {  
        mkdir($path);  
    }  
    $filename = $path . '/' . date('YmdHi') . '.txt';  
    $content = date("Y-m-d H:i:s")."\r\n".$msg."\r\n \r\n \r\n ";  
    file_put_contents($filename, $content, FILE_APPEND);  
} 
?> 
