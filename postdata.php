<?php
require_once('config.php');
if (isset($_POST['btnName']) && $_POST['btnName']!=""){
	$formPost = $_POST['btnName'];
	switch ($formPost) {
		case 'Login':
			if($_POST['txtUName']!="" && $_POST['txtPwd']!="" ){
				$obj = new Users();
				$resp = $obj->userLogin();
				
				if($resp==1){
					header('Location: timetable_dashboard.php');
				}else{
					header('Location: index.php');
				}
			}else{
				$message="Please enter username and password";
				$_SESSION['error_msg'] = $message;
				header('Location: index.php');
			}
			break;
	}
}

?>