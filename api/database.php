<?php 


class DB {
	private $dbc;
	private $r = array(array());
	private $index = 0;

	public function __construct($dbc) {
		$this->dbc = $dbc;
	}

	public function get_recoder_from_db($id,$num) {

		$sql = "select * from picture where id>=$id limit $num";

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

		$this->var_json("picture recode",10001,$this->r);

		mysqli_free_result($result);

		mysqli_close($this->dbc);
	}

	/*send log to client*/
	public function var_json($info = '', $code = 10000, 
		                               $data = '', $location = '') {

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
