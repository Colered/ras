<?php
class Subjects {
   	//Creating Db connection object
   	private $conn;
   	public function __construct(){
   	    global $db;
   		$this->conn = $db;
   	}
	/*function for adding Subject*/
	public function addSubject() {
			//check if the subject code already exists
			$subject_query="select subject_name, subject_code from  subject where subject_code='".$_POST['txtSubjCode']."'";
			$q_res = mysqli_query($this->conn, $subject_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			if(count($dataAll)>0)
			{
				$message="Subject code already exists.";
				$_SESSION['error_msg'] = $message;
				return 0;
			}else{
				//add the new subject
				$currentDateTime = date("Y-m-d H:i:s");
				//$areaCode=$_POST['slctArea'];
				//$programCode=$_POST['slctProgram'];
				$area_query="select id from area where area_code='".$_POST['slctArea']."'";
				$area_result= mysqli_query($this->conn, $subject_query);
				$area_data = mysqli_fetch_assoc($area_result);
				if(count($dataAll)>0){
				   $area_id=$area_data['id'];
				}else{
				 $message="Area code already exists.";
				 $_SESSION['error_msg'] = $message;
				}
				$mysql_query="select id from program where program_name='".$_POST['slctProgram']."'";
				if ($result = mysqli_query($this->conn, "INSERT INTO subject VALUES ('', '".$area_id."', '".program_id."', '".$room_id."','".$_POST['subject_name']."','".$_POST['subject_code']."','".$_POST['session_no.']."','".$_POST['case_no.']."','".$_POST['technical_notes']."','".$currentDateTime."', '".$currentDateTime."');")) {
   					$message="New subject has been added successfully";
					$_SESSION['succ_msg'] = $message;
					return 1;
				}else{
					$message="Cannot add the subject";
					$_SESSION['error_msg'] = $message;
					return 0;
				}
			}
	}
	/*function for listing Area*/
	public function viewArea() {
			$area_query="select * from area order by date_update DESC";
			$q_res = mysqli_query($this->conn, $area_query);
			if(mysqli_num_rows($q_res)<=0){
				$message="There is not any area exists.";
				$_SESSION['error_msg'] = $message;
			}
			return $q_res;
	}
	
	/*function for fetch data using area ID*/
	public function getDataByAreaID($id) {
			$area_query="select * from area where id='".$id."' limit 1";
			$q_res = mysqli_query($this->conn, $area_query);
			if(mysqli_num_rows($q_res)<=0)
				return 0;
			else
				return $q_res;
	}
	/*function for Update Area*/
	public function updateArea() {
			if ($result = mysqli_query($this->conn, "Update area  Set area_name = '".$_POST['txtAreaName']."', area_code = '".$_POST['txtAreaCode']."', area_color = '".$_POST['txtAColor']."' , date_update = '".date("Y-m-d H:i:s")."' where id='".$_POST['areaId']."'")) {
   					$message="Area has been updated successfully";
					$_SESSION['succ_msg'] = $message;
					return 1;
				}else{
					$message="Cannot update the area";
					$_SESSION['error_msg'] = $message;
					return 0;
				}
			}
}
