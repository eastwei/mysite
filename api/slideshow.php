<?php
define("PIC_PATH" , "../../");
class slideshow
{
    private $dbc = NULL;

    public function __construct($dbc)
    {
        $this->dbc = $dbc;
    }

    public function run($curr)
    {
		$filepath = null;
		$caption = null;

		$fh = mysqli_query($this->dbc,"select MAX(id) from picture");
		$array= mysqli_fetch_array($fh);
		$last = $array[0];

		if ($curr <= 0 || $curr > $last) 
			$curr = 1;

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
	$query = "select * from picture where id=$curr";
	$result = mysqli_query($this->dbc,$query);
	$row = mysqli_fetch_array($result);

	mysqli_close($this->dbc);
	$filepath = PIC_PATH . $row['filepath'];
	$caption  = $row['caption'];

        return $filepath ;
    }
}
?>
