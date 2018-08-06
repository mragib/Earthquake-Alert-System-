<?php
include('password.php');
class User extends Password{

    private $_db;

    function __construct($db){
    	parent::__construct();

    	$this->_db = $db;
    }

	private function get_user_hash($username, $usertype){

		try {

			

			//$sql = "select password,username,id from user_response where mobileno = ".$mobileno;


			$stmt = $this->_db->prepare('SELECT password, username, id,mobileno FROM user_data WHERE username = :username AND active="Yes" AND usertype= :usertype');

			$stmt->execute(array('username' => $username,'usertype' =>$usertype));
			

			return $stmt->fetch();

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	public function login($username,$password,$usertype){

		$row = $this->get_user_hash($username, $usertype);

echo $row['password'];
		if($password == $row['password']){

		    $_SESSION['loggedin'] = true;
		    $_SESSION['username'] = $row['username'];
		    $_SESSION['id'] = $row['id'];
		    return true;
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
