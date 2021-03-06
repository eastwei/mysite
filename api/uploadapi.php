
<?php 

//$_FILES['userhead']['size'] 
//$_FILES['userhead']['name']
//$_FILES['userhead']['type']

///////////////////////////////////////////////////////////////////////////////
//
// uploadapi.php - used to upload picture to server
//
///////////////////////////////////////////////////////////////////////////////
//
//
// Author: Nick Wei Last modified: 12/25/2018
//
// Copyright (c) 2018 by Nick Wei
//
///////////////////////////////////////////////////////////////////////////////


define("PIC_FILE_PATH","../../uploads");

class upload_image_api {

	public $pic_caption;
	public $pic_type;
	public $file_path;
	public $allowed;
	public $dbc;


	public function __construct ($dbc) {

		$this->dbc = $dbc;
		$this->pic_caption = "weiwenbo";
		$this->allowed = array('image/pjpeg','image/jpeg','image/jpg',
			'image/JPEG','image/JPG','image/X-PNG',
			'image/PNG','image/png','image/x-png');

	}

	//format informat to json and send to client
	private function var_json($info = '', $code = 10000, 
		                              $data = '', $location = '') {

		$out['code'] = $code ?: 0;
		$out['info'] = $info ?: ($out['code'] ? 'error' : 'success');
		$out['data'] = $data ?: '';
		$out['location'] = $location;

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($out, JSON_HEX_TAG);

		exit(0);

	}

	public function upload() {

		//check if the "caption" is empty
		if(empty($_POST['caption'])) {

			$this->var_json("caption is null! \n");

		}else{
			$this->pic_caption = mysqli_real_escape_string(
				           $this->dbc,trim($_POST['caption']));
		}
		if(empty($_POST['type'])) {
			$this->var_json("type is null! \n");
		}else{
			$this->pic_type = mysqli_real_escape_string(
				          $this->dbc,trim($_POST['type']));
		}

		if (empty($_FILES['file']['error'])) {

			if (in_array($this->pic_type, $this->allowed)) {

				if(empty($_FILES['file']['tmp_name'])) {

					$this->var_json('tmp_name is empty!');

				}

				$name = mysqli_real_escape_string(
					   $this->dbc,trim($_FILES['file']['name']));

				$this->file_path = PIC_FILE_PATH . $name;

				if (move_uploaded_file(
					$_FILES['file']['tmp_name'],$this->file_path)) {

					$this->save_image();

					$this->var_json('file upload ok!', 0 , $this->file_path);

				}

			}else {

				$this->var_json('please upload a jpeg or png image.');
			}

		}else 
			print_error();



		if (file_exists($_FILES['file']['tmp_name'])&&is_file($_FILES['file']['tmp_name'])){

			unlink($_FILE['file']['tmp_name']);	

		}

	}

	public function print_error() {

			switch ($_FILES['file']['error']) {

			case 1:
				$this->var_json('the file exceeds 
					the upload_max_filesize setting in php.ini.',1);
				break;
			case 2:
				$this->var_json('The file exceeds 
					the MAX_FILE_SIZE setting in the HTML form.',2);
				break;
			case 3:
				$this->var_json ('The file was only partially uploads.',3);
				break;
			case 4:
				$this->var_json ( 'No file was uploaded.',4);
				break;
			case 6:
				$this->var_json ('No temporary folder was available.',6);
				break;
			case 7:
				$this->var_json ('Unable to write to the disk.',7);
				break;
			case 8:
				$this->var_json ('File upload stopped.',8);
				break;
			default:
				$this->var_json ('A system error occurred.');
				break;
			}
	}

	/*insert picture to database*/
	public function save_image() {

		if(empty($this->pic_caption) || empty($this->pic_type) || empty($this->file_path)) {

			$this->var_json("data element is null.");
			
			return 0;

		}

		$query = "INSERT INTO picture(caption,type,filepath) " 
			."VALUES('".$this->pic_caption."','"
			.$this->pic_type."','".$this->file_path."')";

		$r = mysqli_query( $this->dbc , $query ); 


		mysqli_close($this->dbc);

		return 1;
	} 

} //end of class

?>
