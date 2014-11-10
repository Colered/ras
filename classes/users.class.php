<?php
class Users extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	/*function for user login*/
	public function userLogin() {
		if(isset($_POST['txtUName']))
		{
			//check if user account exists
			$encPwd = base64_encode($_POST['txtPwd']);
			$login_query="select * from user where username='".$_POST['txtUName']."' and password='".$encPwd."'";
			$q_res = mysqli_query($this->conn, $login_query);
			if(mysqli_num_rows($q_res)>0)
			{
				while($data = mysqli_fetch_assoc($q_res))
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

	public function forgotPwd() {
		if (isset($_POST['email'])){
				$email = $_POST['email'];
				$query="select * from user where email='$email'";
				$result   = mysqli_query($this->conn,$query);
				$count=mysqli_num_rows($result);
				// If the count is equal to one, we will send message other wise display an error message.
				if($count==1){
					$rows=mysqli_fetch_array($result);
					$pass  =  base64_decode($rows['password']);
					$to = $rows['email'];
					$url = "localhost/ras";
					$body  =  "
					Url : $url;
					email Details is : $to;
					Here is your password  : $pass;
					Sincerely,
					Cidot Team";
					$from = "dwarikesh.sharma811@gmail.com";
					$subject = "Your password has been recovered";
					$headers1 = "From: $from\n";
					$headers1 .= "Content-type: text/html;charset=iso-8859-1\r\n";
					$headers1 .= "X-Priority: 1\r\n";
					$headers1 .= "X-MSMail-Priority: High\r\n";
					$headers1 .= "X-Mailer: Just My Server\r\n";
					$headers1;
					$sentmail = mail ( $to, $subject, $body, $headers1 );
					//If the message is sent successfully, display sucess message otherwise display an error message.
					if($sentmail==1){
						$message= "Your password has been sent to your email address.";
						$_SESSION['succ_msg'] = $message;
						return 1;
					}else{
						if($_POST['email']!=""){
							$message= "Cannot send password to your e-mail address.Problem with sending mail...";
							$_SESSION['error_msg'] = $message;
							return 0;
						}
					 }
				} else {
					if ($_POST ['email'] != "") {
					$message= "Email does not exist.";
					$_SESSION['error_msg'] = $message;
					return 0;
					}
				}
		 }
   }
   public function changePwd(){
        $uesr_id=$_SESSION['user_id'];
		$sql="select * from user where id='$uesr_id'";
		$query = mysqli_query($this->conn, $sql);
		while ($row = mysqli_fetch_array($query)) {
			$username = $row['username'];
			$password = $row['password'];
		}
		$cur_password=base64_encode($_POST['currentPassword']);
		$new_pwd=base64_encode($_POST['newPassword']);
		$confirm_pwd=base64_encode($_POST['confirmPassword']);
		if ($cur_password != $password) {
			$message= "Current password does not matched.";
			$_SESSION['error_msg'] = $message;
			return 0;
		}else if ($new_pwd != $confirm_pwd) {
			$message= "Confirm password does not matched";
			$_SESSION['error_msg'] = $message;
			return 0;
		}else {
			$query_updt = "UPDATE user SET password = '$new_pwd' WHERE id='$uesr_id'";
			$query_updt = mysqli_query($this->conn, $query_updt);
			$message= "New password has been updated successfully";
			$_SESSION['succ_msg'] = $message;
			return 1;
		}
	}
}
