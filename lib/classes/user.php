<?php
include('password.php');
class User extends Password{

    private $_db;

    function __construct($db){
    	parent::__construct();

    	$this->_db = $db;
    }

	private function get_user_hash($username){

		try {
			$stmt = $this->_db->prepare('SELECT password, username, memberID, salt, canLogin FROM members WHERE username = :username AND active="Yes" ');
			$stmt->execute(array('username' => $username));

			return $stmt->fetch();

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}	
	
	public function login($username,$password){

		$row = $this->get_user_hash($username);

		if ($row['canLogin']){
			if($this->password_verify($password,$row['password'], $row['salt']) == 1){
				$_SESSION['loggedin'] = true;
				$_SESSION['username'] = $row['username'];
				$_SESSION['memberID'] = $row['memberID'];
				return "ok";
			} else {
				return "nok";
			}
		} else {
			return "accountOff";
		}
	}

	public function logout(){
		session_destroy();
	}

	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}

}


?>
