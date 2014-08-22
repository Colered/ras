<?php
class Users {
   	// database connection and table name
   	private $conn;
   	public function __construct(){
   	    global $db;
   		$this->conn = $db;
   	}
	/*function for user login*/
	public function userLogin() {
		if(isset($_POST['txtUName']))
		{
			//check if user account exists
			$encPwd = md5($_POST['txtPwd']);
			$login_query="select * from user where username='".$_POST['txtUName']."' and password='".$encPwd."'";
			$q_res = mysqli_query($this->conn, $login_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			if(count($dataAll)>0)
			{
				foreach($dataAll as $data)
	  			{
					$_SESSION['user_id']=$data['id'];
					$_SESSION['username']=$data['username'];
					$_SESSION['user_email']=$data['email'];
					$_SESSION['role_id']=$data['role_id'];
				}
				return 1;
			}else{
				$message="Incorrect Username or Password";
				$_SESSION['error_msg'] = $message;
				return 0;
			}
		}
	}

}
