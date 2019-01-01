<? php

class db_functions {
	private $conn;

	function __construct() {
		require_once 'db_connect.php';
		$db = new db_connect();
		$this->conn = $db->connect();
	}

	function __destruct() {
	}

	public function store_user($name,$email,$password) {
		$uuid = uniqid('',true);
		$hash = $this->hashSSHA($password);
		$encrypted_password = $hash["encrypted"];
		$salt = $hash["salt"];

		$query = "INSERT INTO users(unique_id,name,email, encrypted_password,salt, created_at) VALUES(?, ?, ?, ?, ?, NOW())";

		$stmt = $this->conn->prepare($query);
		$stmt->bind_param("sssss",$uuid, $name, $email, $encrypted_password, $salt);
		$result = $stmt->execute();
		$stmt->close();

		if ($result) {
			$stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
		        $stmt->bind_param("s",$email);
			$stmt->execute();
			$user = $stmt->get_result()->fetch_assoc();
			$stmt->close();

			return $user;
		}else {
			return false;
		}
	}

	public function getUserByEmailAndPassword($email, $password) {

		$stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");

		$stmt->bind_param("s", $email);

		if($stmt->execute()) {
			$user = $stmt->get_result()->fetch_assoc();
			$stmt->close();

			$salt = $user['salt'];
			$encrypted_password = $user['encrypted_password'];
			$hash = $this->checkhashSSHA($salt , $password);

			if($encrypted_password == $hash) {
				return $user;
			}
		} else {
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
}

?>
