<?php
require_once('config.php');
if (isset($_POST['form_action']) && $_POST['form_action']!=""){
	$formPost = $_POST['form_action'];
	switch ($formPost) {
		case 'Login':
			//conditions for user login
			if($_POST['txtUName']!="" && $_POST['txtPwd']!="" ){
				$obj = new Users();
				$resp = $obj->userLogin();
				$location = ($resp == 1) ? "timetable_dashboard.php" : "index.php";
				header('Location: '.$location);
			}else{
				$message="Please enter username and password";
				$_SESSION['error_msg'] = $message;
				header('Location: index.php');
			}
		break;
		case 'Area':
			//adding new areas
			if($_POST['txtAreaName']!="" && $_POST['txtAreaCode']!="" ){
				$obj = new Areas();
				$resp = $obj->addArea();
				$location = ($resp == 1) ? "areas_view.php" : "areas.php";
				header('Location: '.$location);
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: areas.php');
			}
		break;
		case 'EditArea':
			//adding new areas
			$obj = new Areas();
			$resp = $obj->updateArea();
			$location = ($resp == 1) ? "areas_view.php" : "areas.php";
			header('Location: '.$location);
		break;
		case 'Buld':
			//adding new building
			if($_POST['txtBname']!="" ){
				$obj = new Buildings();
				$resp = $obj->addBuilding();
				$location = ($resp == 1) ? "buildings_view.php" : "buildings.php";
				header('Location: '.$location);
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: areas.php');
			}
		break;
		case 'EditBuld':
			//adding new building
			$obj = new Buildings();
			$resp = $obj->updateBuld();
			$location = ($resp == 1) ? "buildings_view.php" : "buildings.php";
			header('Location: '.$location);
		break;
		case "add_edit_professor":
			//add and edit professor
			$obj = new Teacher();
			if(isset($_POST['form_edit_id']) && $_POST['form_edit_id']!=''){
			    $resp = $obj->editProfessor();
				header('Location: professor.php?edit='.$_POST['form_edit_id']);
				exit();
			}else{
				$resp = $obj->addProfessor();
				if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					echo "<form name='form55' method='post' action='professor.php'>";
					reset($_POST);
					while(list($iname,$ival) = each($_REQUEST)) {
						echo "<input type='hidden' name='$iname' value='$ival'>";
					}
					echo "</form>";
					echo "</body></html>";
					echo"<script language='JavaScript'>function submit_back(){ window.document.form55.submit();}submit_back();</script>";
					exit();
				//end return back
				}else{
					header('Location: professor.php');
					exit();
				}
			}
		break;
	}
}
?>