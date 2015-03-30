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
			$login_query="select * from user where username='".$_POST['txtUName']."' and password='".$encPwd."' and is_active='1' ";
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
	//function to forgot the password
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
					$url = $_SERVER['HTTP_HOST'];
					$body  =  "
					Website Url : $url <br/>
					Your Email Id : $to <br/>
					Here is your password  : $pass <br/><br/><br/><br/>
					Sincerely,<br/>
					BARNA";
					$from = "roa57113@gmail.com";
					$subject = "Your password has been recovered";
					$headers1 = 'From: Password Recovered <$from>' . "\r\n";
					$headers1 .= "Content-type: text/html;charset=iso-8859-1\r\n";
					$headers1 .= "X-Priority: 1\r\n";
					$headers1 .= "X-MSMail-Priority: High\r\n";
					$headers1 .= "X-Mailer: Password Recovered\r\n";
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
   //function to chnage the password
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
	//function to add the user
	public function addUser() {
			//check if the user name aready exist
			$currentDateTime = date("Y-m-d H:i:s");
			$sql="select email ,username from user where email='".Base::cleanText($_POST['txtUserEmail'])."' || username='".Base::cleanText($_POST['txtUserName'])."'";
			$q_res = mysqli_query($this->conn, $sql);
			$dataAll = mysqli_fetch_assoc($q_res);
			if(count($dataAll)>0)
			{
				$message="User already exists.";
				$_SESSION['error_msg'] = $message;
				return 0;
			}else{
				//add the new user
				if ($result = mysqli_query($this->conn, "INSERT INTO user (role_id,username,password,email,date_add,date_update) VALUES ('".Base::cleanText($_POST['slctUserType'])."', '".Base::cleanText($_POST['txtUserName'])."', '".Base::cleanText(base64_encode($_POST['txtUserPwd']))."', '".$_POST['txtUserEmail']."', '".$currentDateTime."', '".$currentDateTime."');")) {
   					$message="New user has been added successfully";
					$_SESSION['succ_msg'] = $message;
					return 1;
				}else{
					$message="User can not be added";
					$_SESSION['error_msg'] = $message;
					return 0;
				}
			}
	}
	//function to getting the user type 
	public function getUserType()
	{
		$sql ="select id,name from  role where id!='1' order by id";
		$q_res = mysqli_query($this->conn, $sql);
		return $q_res;
	}
	//function to getting the user detail
	public function userDetail() {
		$sql="select * from user order by date_update DESC";
		$q_res = mysqli_query($this->conn, $sql);
		return $q_res;
	}
	//function to getting the data using user id
	public function getDataByUserID($id) {
		$sql="select * from user where id='".$id."' limit 1";
		$q_res = mysqli_query($this->conn, $sql);
		return $q_res;
	}
	//function to updating the detail of user by id
	public function updateUser()
	{
		//check if the username or email id already exist or not 
		$sql="select email ,username from user where (email='".Base::cleanText($_POST['txtUserEmail'])."' || username='".Base::cleanText($_POST['txtUserName'])."') && id!='".$_POST['userId']."'";
		$q_res = mysqli_query($this->conn, $sql);
		$dataAll = mysqli_fetch_assoc($q_res);
		if(count($dataAll)>0){
				$message="User already exists.";
				$_SESSION['error_msg'] = $message;
				header('Location: user_add.php?edit='.base64_encode($_POST['userId']));
				return 0;
		}elseif ($result = mysqli_query($this->conn, "Update user  Set role_id = '".Base::cleanText($_POST['slctUserType'])."', username = '".Base::cleanText($_POST['txtUserName'])."', password = '".Base::cleanText(base64_encode($_POST['txtUserPwd']))."' , email = '".$_POST['txtUserEmail']."', date_update = '".date("Y-m-d H:i:s")."' where id='".$_POST['userId']."'")) {
				$message="User has been updated successfully";
				$_SESSION['succ_msg'] = $message;
				return 1;
			}else{
				$message="User cannot be updated";
				$_SESSION['error_msg'] = $message;
				header('Location: user_add.php?edit='.base64_encode($_POST['userId']));
				return 0;
			}
	}
	//getting user level with permissions by id
	public function getUser($id,$path)
	{
		$user_detail = array();
		$sql="select u.role_id,rp.page_id,rp.add_role,rp.view,rp.edit,rp.delete_role,rp.clone from user u inner join role_pages rp on rp.role_id = u.role_id inner join page p on p.id = rp.page_id where u.id='".$id."' and p.url='".$path."'";
		$query = mysqli_query($this->conn, $sql);
		if(mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query);
			$user_detail['role_id'] = $row['role_id'];
			$user_detail['page_id'] = $row['page_id'];
			$user_detail['add_role'] = $row['add_role'];
			$user_detail['delete_role'] = $row['delete_role'];
			$user_detail['view'] = $row['view'];
			$user_detail['edit'] = $row['edit'];
			$user_detail['clone'] = $row['clone'];
		}
		return $user_detail;
	}
	//getting role type and page detail
	function getRoleData($roleId){
		$sql ="select * from page p left join role_pages rp on p.id=rp.page_id where role_id='".$roleId."' order by p.id";
		$q_res = mysqli_query($this->conn, $sql);
		return $q_res;
	}
	function getUserName($Id){
	    $sql="select username from user where id='".$_SESSION['user_id']."'";
		$q_res = mysqli_query($this->conn, $sql);
		$data = mysqli_fetch_assoc($q_res);
		return $data;
	}
}
