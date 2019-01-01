<?php

/*
create database android_api
 
use android_api
 
create table users(
   id int(11) primary key auto_increment,
   unique_id varchar(23) not null unique,
   name varchar(50) not null,
   email varchar(100) not null unique,
   encrypted_password varchar(80) not null,
   salt varchar(10) not null,
   created_at datetime,
   updated_at datetime null
); // Creating Users Table 
*/

class db_connect {

	private $conn;

	public function connect() {

		require_once 'config.php';

		$this->conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

		if(mysqli_connect_errno($this->conn)) {

			$msg = "connect mysql server fail \n";

		}else {

			$msg = "connect mysql ok \n";

		}

		$time_str=date("Y-m-d H:i:s");

		error_log($time_str."--->".$msg."\n",3,"/var/tmp/php.log");

		mysqli_set_charset($this->conn, "utf8");

		return $this->conn;
	}
}
?>
