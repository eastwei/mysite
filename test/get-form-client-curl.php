<?php 
$url = 'http://localhost/mysite/test/get-form-page.php';
$data = array("category" => "technology", "rows" => 20);

$get_addr = $url . '?' . http_build_query($data);
$ch = curl_init($get_addr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$page = curl_exec($ch);
echo $page;
echo "\n";
?>
