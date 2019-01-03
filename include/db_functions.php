<?php

class db_functions {

	private $conn;

	function __construct($dbc) {

		$this->conn = $dbc;
	}

	function __destruct() {
	}
	public function storeUser($name,$email,$password) {

		$uuid = uniqid('',true);
		$hash = $this->hashSSHA($password);
		$encrypted_password = $hash["encrypted"];
		$salt = $hash["salt"];

		$query = "INSERT INTO users(unique_id,name,email,encrypted_password,salt,created_at) 
			      VALUES(?, ?, ?, ?, ?, NOW())";

		$stmt = $this->conn->prepare($query);
		$stmt->bind_param("sssss",$uuid, $name, $email, $encrypted_password, $salt);
		$result = $stmt->execute();
		$stmt->close();

		if ($result) {
			$stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
		        $stmt->bind_param("s",$email);
			$stmt->execute();
			$stmt->bind_result($id, $uid, $name, $email, $encrypted_password,
			                   $salt,$create_at, $update_at);
			$stmt->store_result();
			$user = array();
			$i = 0;
			while ($stmt->fetch()) {
				$user[$i]['id'] = $id;
				$user[$i]['unique_id'] = $title;
				$user[$i]['name'] = $name;
				$user[$i]['email'] = $email;
				$user[$i]['encrypted_password'] = $encrypted_password;
				$user[$i]['salt'] = $salt;
				$user[$i]['create_at'] = $create_at;
				$user[$i]['update_at'] = $update_at;
				$i++;
			}
			$stmt->free_result();
			$stmt->close();

			return $user[0];
		}else {
			return false;
		}
	}

	public function getUserByEmailAndPassword($email, $password) {
		$param = "".$email.$password;
		$this->set_error($param);

		$stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
		$stmt->bind_param("s", $email);
		if($stmt->execute()) {
			$stmt->bind_result($id, $uid, $name, $email, $encrypted_password,
			                   $salt,$create_at, $update_at);
			$stmt->store_result();
			$user = array();
			$i = 0;
			while ($stmt->fetch()) {
				$user[$i]['id'] = $id;
				$user[$i]['unique_id'] = $title;
				$user[$i]['name'] = $name;
				$user[$i]['email'] = $email;
				$user[$i]['encrypted_password'] = $encrypted_password;
				$user[$i]['salt'] = $salt;
				$user[$i]['create_at'] = $create_at;
				$user[$i]['update_at'] = $update_at;
				$i++;
			}
			$stmt->free_result();
			$stmt->close();

			$salt = $user[0]['salt'];
			$this->set_error($salt);
			$encrypted_password = $user[0]['encrypted_password'];

			$hash = $this->checkhashSSHA($salt , $password);

			if($encrypted_password == $hash) {
				$this->set_error("login ok");
				return $user[0];
			}
		} else {
				$this->set_error("user is not exist ");
			return NULL;
		}
	}

	public function isUserExisted($email) {
		$stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->store_result();

		if($stmt->num_rows > 0) {

			$stmt->close();

			return true;

		} else {

			$stmt->close();

			return false;
		}
	}

	public function hashSSHA($password) {
		$salt = sha1(rand());
		$salt = substr($salt, 0, 10);
		$encrypted = base64_encode(sha1($password . $salt, true) . $salt);
		$hash = array("salt" => $salt, "encrypted" => $encrypted);
		return $hash;
	}

	public function checkhashSSHA($salt, $password) {
		$hash = base64_encode(sha1($password . $salt, true) . $salt);
		return $hash;
	}
	private function set_error($msg) {

		$time_str=date("Y-m-d H:i:s");
		error_log($time_str."--->".$msg."\n",3,"/var/tmp/php.log");
	}
}

?>
