<?php
/*
    PHP image slideshow - auto version - PHP5
*/
require('../../mysqli_connect.php'); 

$ss = new slideshow($dbc);
// set variables, done.
list($image, $caption, $first, $prev, $next, $last) = $ss->run();
/*
    slideshow class, used with mysql
*/
class slideshow
{
    private $dbc = NULL;

    public function __construct($dbc)
    {
        $this->dbc = $dbc;
    }

    public function run()
    {
		$filepath = null;
		$caption = null;
        $curr = 1;
		$fh = mysqli_query($this->dbc,"select MAX(id) from picture");
		$array= mysqli_fetch_array($fh);
        $last = $array[0];
		$this->setError($last);
        if (isset($_GET['img']))
        {
            if (preg_match('/^[0-9]+$/', $_GET['img'])) 
				$curr = (int) $_GET['img'];

            if ($curr <= 0 || $curr > $last) 
				$curr = 1;

        }
        if ($curr <= 1)
        {
            $prev = $curr;
            $next = $curr + 1;
        }
        else if ($curr >= $last)
        {
            $prev = $last - 1;
            $next = $last;
        }
        else
        {
            $prev = $curr - 1;
            $next = $curr + 1;
        }
		// line below sets the caption name...
		$sql = "select * from picture where id=$curr";
		$result = mysqli_query($this->dbc,$sql);
		$row = mysqli_fetch_array($result);
		mysqli_close($this->dbc);
		$filepath = "../../".$row['filepath'];
		$caption  = $row['caption'];
        return array($filepath,$caption, 1, $prev, $next, $last);
    }
	/*输出log*/
	public function setError($msg) {
		error_log("show_multi_pic.php ".$msg."\n",3,'/home/weidong/php.log');
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Slideshow</title>
    <style type="text/css">
    body{margin: 0;padding: 0;font: 100% Verdana, Arial, Helvetica, sans-serif;font-size: 14px;}
    div#gallery{border: 1px #ccc solid;width: 600px;margin: 40px auto;text-align: center;}
    div#gallery img{margin: 20px;border: 2px #004694 solid;}
    div#gallery p{color: #004694;}
    div#gallery div.pn{padding: 10px;margin: 0 5px;border-top: 1px #ccc solid;}
    a{color:#333;}
    a:hover{color:#cc0000;}
    a.sp{padding-right: 40px;}
    </style>
</head>
<body>
    <div id="gallery">
        <img width=500 height=500 src="<?=$image;?>" alt="" />
        <p><?=$caption;?></p>
        <div class="pn">
            <a href="?img=<?=$first;?>">First</a> | <a href="?img=<?=$prev;?>" class="sp">Previous</a><a href="?img=<?=$next;?>">Next</a> | <a href="?img=<?=$last;?>">Last</a>
        </div>
    </div>
</body>
</html>
