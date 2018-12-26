<?php 

require("log.php");

class DB {
	private $dbc;
	private $r=array(array());
	private $index = 0;
	private $log = new mylog();

	public function __construct($dbc) {
		$this->dbc = $dbc;
	}

	public function run() {

		$sql = "select * from picture limit 5";

		$result=mysqli_query($this->dbc,$sql);

		if(mysqli_errno($this->dbc)) {
			$this->var_json("query database error! \n");
			exit(0);
		}
		//$num = mysqli_num_rows($result);
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) 
		{
			$tmp = array();	
			$tmp["id"]=$row["id"];
			$tmp["caption"]=$row["caption"];
			$tmp["type"]=$row["type"];
			$tmp["path"]=$row["filepath"];

			/*format the string to json array*/
			$this->r["".$this->index] = $tmp;
			$this->index++;
		}

		$log->var_json("picture recode",10001,$this->r);

		mysqli_free_result($result);

		mysqli_close($this->dbc);
	}
}
?>
