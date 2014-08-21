<?php
require_once('config.php');
if (isset($_POST['btnName']) && $_POST['btnName']!=""){
	$formPost = $_POST['btnName'];
	switch ($formPost) {
		case 'Login':
			$obj = new Users();
			$resp = $obj->userLogin();
			if($resp==1){
				header('Location: timetable.php');
			}else{
				header('Location: index.php');
			}
			break;
		case 1:
			echo "i equals 1";
			break;
		case 2:
			echo "i equals 2";
			break;
	}
}

?>