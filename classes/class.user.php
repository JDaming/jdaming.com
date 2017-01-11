<?php
    class User{
	private $db;
	
	public function __construct($db){
		$this->db = $db;
	}
	
	public function is_logged_in(){
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}
	
	private function get_user_hash($username){
		
		try{
			$stmt = $this->db->prepare('select password from blog_members where username = :username');
			$stmt->execute(array('username'=>$username));

			$row = $stmt->fetch();
			return $row['password'];
		} catch(PDOException $e) {
			echo '<p class = "error">'.$e->getMessage().'</p>';
		}
		
	}

	public function login($username,$password){
		
		$hashed = $this->get_user_hash($username);
		
		if (password_verify($password,$hashed) == 1){
			
			$_SESSION['loggedin'] = true;
			return true;
		}
	}
	
	public function logout(){
		session_destory();
	}
	
    }//class 
?>
