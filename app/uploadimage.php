<?php
/*图片上传类
 *pic_caption: the caption of picture
 *pic_type:the picture type . for example jpeg, png,gif. 
 *file_path:the path of the picture.
 *dbc: the databases connect object.
 * */

class UploadImage{
	public $pic_caption;
	public $pic_type;
	public $file_path;
	public $dbc;

	public function __construct($dbc) {

		$this->dbc = $dbc;
	}
	/*send picture file to upload fold*/
	public function upload() {

		if (empty($_POST['caption'])) {
			$this->setError("You forgot to enter picture caption.\n");
		}else {
			$this->pic_caption=mysqli_real_escape_string($this->dbc,trim($_POST['caption']));
		}

		if(empty($_FILES['photo']['error'])){
			$this->pic_type = $_FILES['photo']['type']; 
			$this->file_path = "uploads/".date("YmdHis").$_FILES['photo']['name'];
			move_uploaded_file($_FILES['photo']['tmp_name'],"../../".$this->file_path); /*move to destination fold*/
		} else {
			switch($_FILES['photo']['error']) {  

			case 1:   
				// 文件大小超出了服务器的空间大小   
				$this->setError("The file is too large (server).");   
				break;   

			case 2:   
				// 要上传的文件大小超出浏览器限制   
				$this->setError("The file is too large (form).");   
				break;   

			case 3:   
				// 文件仅部分被上传   
				$this->setError("The file was only partially uploaded.");   
				break;   

			case 4:   
				// 没有找到要上传的文件   
				$this->setError("No file was uploaded.");   
				break;   

			case 5:   
				// 服务器临时文件夹丢失   
				$this->setError("The servers temporary folder is missing.");   
				break;   

			case 6:   
				// 文件写入到临时文件夹出错   
				$this->setError("Failed to write to the temporary folder.");   
				break;   
			}
		}
	}
	/*insert picture to database*/
	public function saveimage() {
		if(empty($this->pic_caption) || empty($this->pic_type) || empty($this->file_path)) {
			$this->setError("data element is null \n");
		}else{
			$q="INSERT INTO picture(caption,type,filepath) " 
				."VALUES('".$this->pic_caption."','".$this->pic_type."','".$this->file_path."')";
			$r=mysqli_query($this->dbc,$q); 
		}
		mysqli_close($this->dbc);
		header('location:loggedin.php'); /*jump to loggedin.php*/
		exit();
	} 

	/*输出log*/
	public function setError($msg) {

		error_log("uploadimage.php ".$msg."\n",3,'/home/weidong/php.log');
	}
}
?>
