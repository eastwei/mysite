<!--login_action.php-->
<html>
<head>
<title>user register</title>
</head>
<body>
<?php
$user_name=$_POST["user_name"];
$user_pw=$_POST["user_pw"];
if($user_name=="" or $user_pw=="" or $_FILES['pic_name']['name']=="") 
{
	echo"user name and passwd should not empty, please <a href=login.html>return</a> refill";
	exit;
}

$rand1=rand(0,9);
$rand2=rand(0,9);
$rand3=rand(0,9);

$filename=date("Ymdhms").$rand1.$rand2.$rand3;
echo"filename:".$filename."<br>";

$oldfilename=$_FILES['pic_name']['name'];
echo"oldfilename:".$oldfilename."<br>";

$start = strrpos($oldfilename,".");
echo"start:".$start."<br>";

$len = strlen($oldfilename) - $start;
echo"len:".$len."<br>";

$filetype=substr($oldfilename,$start,$len);
echo"filetype:".$filetype."<br>";

if(($filetype!='.git')&&($filetype!='.GIF')&&($filetype!='.jpg')&&($filetype!='.JPG'))
{
	echo "<script>alert('file type or address error!');</script>";
	echo "<script>location.href='login.html';</script>";
	exit;
}
echo "file type ok <br>";
if($_FILES['pic_name']['size']>1000000) 
{
	echo "<script>alert('file is too large,so can not be submit!');</script>";
	echo "<script>location.href='login.html';</script>";
	exit;
}
echo "size ok <br>";
$filename=$filename.$filetype;
echo"filename:".$filename."<br>";
$savedir=$filename;
$tempfile=$_FILES['pic_name']['tmp_name'];
echo"tempfile:".$tempfile."<br>";

if(move_uploaded_file($_FILES['pic_name']['tmp_name'],$savedir)) 
{
	$file_name = basename($savedir);
}
else
{
	echo"<script language=javascript>";
	echo"alert('error! can not write attachment! \n this advisement fail!');";
	echo"location.href='login.html';";
	echo"</script>";
	exit;
}

$file = fopen("user_info.txt","a");
flock($file,LOCK_EX);
$string=$user_name."\n";
fputs($file,$string);
$string=$user_pw."\n";
fputs($file,$string);
$string=$filename."\n";
fputs($file,$string);
fputs($file,"\n");
echo "congradulations, register successfully !<br>";
echo "user name:".$user_name."<br>";
echo "login passwd:".$user_pw."<br>";
echo "picture:<img src=".$filename." align=middle><br>";
echo "please<a href=land.html>login</a>";
?>
</body>
</html>
