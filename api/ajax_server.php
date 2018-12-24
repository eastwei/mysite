<?php 
$isbn = $_GET['isbn'];
if(!$isbn) {
	print "That request was not understood.";
}else if($isbn == "9780735624498") {
	print "JavaScript Step by Step";
}
?>
