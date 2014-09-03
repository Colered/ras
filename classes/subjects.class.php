<?php
class Subjects extends Base {
    public function __construct(){
   		 parent::__construct();
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
				//fectching area id
				$area_query="select id from area where area_code='".$_POST['slctArea']."'";
				$area_result= mysqli_query($this->conn, $area_query);
				$area_data = mysqli_fetch_assoc($area_result);
				if(count($area_data)>0){
				   $area_id=$area_data['id'];
				}else{
				   $message="Area does not exists.";
				   $_SESSION['error_msg'] = $message;
				}
				//fectching program id
				$program_query="select id from program where program_name='".$_POST['slctProgram']."'";
				$program_result= mysqli_query($this->conn, $program_query);
				$program_data = mysqli_fetch_assoc($program_result);
				if(count($program_data)>0){
				   $program_id=$program_data['id'];
				}else{
				   $message="Program does not exists.";
				   $_SESSION['error_msg'] = $message;
				}
				
				/*$result = mysqli_query($this->conn, "INSERT INTO subject VALUES ('', '".$area_id."', '".$program_id."','".$_POST['txtSubjName']."','".$_POST['txtSubjCode']."','".$_POST['txtCaseNum']."','".$_POST['txtTechNotes']."','".$currentDateTime."', '".$currentDateTime."')");
				$rel = $this->conn->query($sql);*/
				
				
				
				
				
				
				/*if ($result = mysqli_query($this->conn, "INSERT INTO subject VALUES ('', '".$area_id."', '".$program_id."','".$_POST['txtSubjName']."','".$_POST['txtSubjCode']."','".$_POST['txtCaseNum']."','".$_POST['txtTechNotes']."','".$currentDateTime."', '".$currentDateTime."')")) {	
					$message="New subject has been added successfully";
					$_SESSION['succ_msg'] = $message;
					if($j==count($_POST['slctRoom'])){
					 return 1;
					}
				}else{
				    $message="Cannot add the subject";
					$_SESSION['error_msg'] = $message;
					return 0;
				  }*/
			
			}
	}
	/*function for listing Area*/
	public function viewSubject(){
	    	
			$subject_query="select * from subject order by date_update DESC";
			$q_res = mysqli_query($this->conn, $subject_query);
			if(mysqli_num_rows($q_res)<=0){
				$message="There is not any subject exists.";
				$_SESSION['error_msg'] = $message;
			}
			return $q_res;
	
	}
	/*function for fetch data using area ID*/
	public function getDataBySubjectID($id) {
			$subject_query="select * from subject where id='".$id."' limit 1";
			$q_res = mysqli_query($this->conn, $subject_query);
			if(mysqli_num_rows($q_res)<=0)
				return 0;
			else
				return $q_res;
	}
	public function updateSubject() {}
}