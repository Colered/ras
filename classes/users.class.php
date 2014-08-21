<?php
class Users {
    public function __construct() {
    
	}
	/*function for user login*/
	public function userLogin() {
		session_start();
		if(isset($_POST['txtUName']))
		{
			//check if user account exists
			$database = new Database();
			$db = $database->getConnection();
			$encPwd = md5($_POST['txtPwd']);
			$login_query="select * from user where username='".$_POST['txtUName']."' and password='".$encPwd."'";
			$q_res = mysqli_query($db, $login_query);
			if(count($q_res)>0)
			{
				while($data=mysqli_fetch_assoc($q_res))
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
