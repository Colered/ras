<?php
class Subjects extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	/*function for adding Subject*/
	public function addSubject() {
			$sessionName = (isset($_POST['sessionName'])) ? ($_POST['sessionName']) : '';
			$sessionNameArr=$this->formingArray($sessionName);
			$orderNumber = (isset($_POST['sessionOrder'])) ? ($_POST['sessionOrder']) : '';
			$orderNumberArr=$this->formingArray($orderNumber);
			$sessionDesp = (isset($_POST['sessionDesc'])) ? ($_POST['sessionDesc']) : '';
			$sessionDespArr=$this->formingArray($sessionDesp);
			//check if the subject code already exists
			$subject_query="select subject_name, subject_code from  subject where subject_code='".Base::cleanText($_POST['txtSubjCode'])."'";
			$q_res = mysqli_query($this->conn, $subject_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			if(count($dataAll)>0){
				$message="Subject code already exists.";
				$_SESSION['error_msg'] = $message;
				return 0;
			}else{
				//add the new subject
				$currentDateTime = date("Y-m-d H:i:s");
				//fectching area id
				$area_id=$this->getAreaId();
				//fectching program id
				//$program_id=$this->getProgramId();
				$program_name=$_POST['slctProgram'];
				$program_Val=explode('#',$program_name);
				$program_year_id=$program_Val[0];
				$program_id=$program_Val[1];
				//inserting values
				$SQL = "INSERT INTO subject VALUES ('', '".$area_id."', '".$program_year_id."','".$_POST['txtSubjName']."','".$_POST['txtSubjCode']."','".$_POST['txtCaseNum']."','".$_POST['txtTechNotes']."','".$currentDateTime."', '".$currentDateTime."')";
				$result = $this->conn->query($SQL);
				$last_ins_id = $this->conn->insert_id;
				if($last_ins_id) {
					if($last_ins_id!=""){
					$j=0;
					if($sessionName!=""){
					foreach ($sessionNameArr as $key => $value) {
						$sessionNameval=$value;
						//inserting subject session values
						if($seesion_result = mysqli_query($this->conn, "INSERT INTO  subject_session VALUES ('', '".$last_ins_id."', '".$sessionNameval."','".$orderNumberArr[$j]."','".$sessionDespArr[$j]."','".$currentDateTime."', '".$currentDateTime."')")){
						$j++;
						if($j==count($sessionNameArr)){
						 $message="New subject has been added successfully with session";
						 $_SESSION['succ_msg'] = $message;
						 return 1;
						 }
						}else{
						 $message="Cannot add the subject's sesssion";
						 $_SESSION['succ_msg'] = $message;
						 return 0;
						}
					  }
					}else{
						$message="New subject has been added successfully";
						$_SESSION['succ_msg'] = $message;
						return 1;
					}
				  }
				}else{
				    $message="Cannot add the subject";
					$_SESSION['error_msg'] = $message;
					return 0;
				  }
		}
	}
	/*function for listing Subject*/
	public function viewSubject()
	{
		$subject_query="select * from subject order by date_update DESC";
		$q_res = mysqli_query($this->conn, $subject_query);
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
	public function updateSubject() {
	        //check if the subject code already exists
			$subject_query="select subject_name, subject_code from  subject where subject_code='".$_POST['txtSubjCode']."'";
			$q_res = mysqli_query($this->conn, $subject_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			if(count($dataAll)>0){
				$message="Subject code already exists.";
				$_SESSION['error_msg'] = $message;
				return 0;
			}else{
			//get area id
			$area_id=$this->getAreaId();
			//get program id
			//$program_id=$this->getProgramId();
			$program_name=$_POST['slctProgram'];
			$program_Val=explode('#',$program_name);
			$program_year_id=$program_Val[0];
			$program_id=$program_Val[1];
			$sessionName = (isset($_POST['sessionName'])) ? ($_POST['sessionName']) : '';
			$sessionNameArr=$this->formingArray($sessionName);
			$orderNumber = (isset($_POST['sessionOrder'])) ? ($_POST['sessionOrder']) : '';
			$orderNumberArr=$this->formingArray($orderNumber);
			$sessionDesp = (isset($_POST['sessionDesc'])) ? ($_POST['sessionDesc']) : '';
			$sessionDespArr=$this->formingArray($sessionDesp);
			$sessionRowId = (isset($_POST['sessionRowId'])) ? ($_POST['sessionRowId']) : '';
			$sessionRowIdArr=$this->formingArray($sessionRowId);
			//updating subject values
			if ($result = mysqli_query($this->conn, "Update subject  Set area_id = '".$area_id."', program_year_id = '".$program_year_id."', subject_name= '".$_POST['txtSubjName']."' , subject_code= '".$_POST['txtSubjCode']."',case_number = '".$_POST['txtCaseNum']."',technical_notes = '".$_POST['txtTechNotes']."',date_update = '".date("Y-m-d H:i:s")."' where id='".$_POST['subjectId']."'")) {
			        if($_POST['subjectId']!=""){
					$j=0;
					$k=0;
					//updating session values
				if($sessionName!=""){
					foreach ($sessionNameArr as $key => $value) {
						$sessionNameval=$value;
						if($j!=count($sessionRowIdArr)){
							if($seesion_result = mysqli_query($this->conn, "Update  subject_session  Set session_name = '".$sessionNameval."', order_number = '".$orderNumberArr[$j]."', description= '".$sessionDespArr[$j]."',date_update = '".date("Y-m-d H:i:s")."' where id='".$sessionRowIdArr[$j]."'")){
								$j++;
								$k=$j;
								}
					 	}else{
						   if($seesion_result = mysqli_query($this->conn, "INSERT INTO  subject_session VALUES ('', '".$_POST['subjectId']."', '".$sessionNameval."','".$orderNumberArr[$k]."','".$sessionDespArr[$k]."','".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')")){
						     $k++;
							 if($k == (count($sessionNameArr))){
						   			$message="Subject has been updated successfully with session";
						   			$_SESSION['succ_msg'] = $message;
									return 1;
							 }

						  }else{
								echo $message="Subject's session cannot be added";
						   		$_SESSION['error_msg'] = $message;
								return 0;
							}
						}
				    }
				  }else{
				  		$message="Subject has been updated successfully ";
						$_SESSION['succ_msg'] = $message;
						return 1;
				  }
				}else{
					echo $message="Cannot update the subject";
					$_SESSION['error_msg'] = $message;die;
					return 0;
				}
		}else{
			$message="Cannot update the subject";
			$_SESSION['error_msg'] = $message;
			return 0;
		}
	}
  }
	public function getProgramId(){
		$program_query="select id from program where program_name='".$_POST['slctProgram']."'";
		$program_result= mysqli_query($this->conn, $program_query);
		$program_data = mysqli_fetch_assoc($program_result);
		if(count($program_data)>0){
			$program_id=$program_data['id'];
			return $program_id;
		}else{
		   echo  $message="Program does not exists.";
		   $_SESSION['error_msg'] = $message;
		}
	}
	public function getAreaId(){
		$area_query="select id from area where area_code='".$_POST['slctArea']."'";
		$area_result= mysqli_query($this->conn, $area_query);
		$area_data = mysqli_fetch_assoc($area_result);
		if(count($area_data)>0){
			$area_id=$area_data['id'];
			return $area_id;
		}else{
			$message="Area does not exists.";
			$_SESSION['error_msg'] = $message;
		}
	}
	public function formingArray($dataArr){
		 $newArr = array();
			foreach ($dataArr as $key => $val) {
					if (trim($val) <> "") {
					 $newArr[] = trim($val);
					}
			}
  		return $newArr;
	}

 /*function for all subjects for add form*/
 	public function getSubjects(){
		$sql="SELECT id,subject_name FROM subject ORDER BY subject_name";
		$result = $this->conn->query($sql);
		return $result;
   }
 /*function for all sessions for add form*/
 	public function getSessions(){
		$sql="SELECT id,session_name FROM subject_session ORDER BY session_name";
		$result = $this->conn->query($sql);
		return $result;
   }

    /*get subject name by id*/
	public function getSubjectByID($id){
		$sql="SELECT id,subject_name FROM subject WHERE id='".$id."'";
		$result = $this->conn->query($sql);
		if(!$result->num_rows){
			return '';
		}else{
		  $row = $result->fetch_assoc();
		  return $row['subject_name'];
		}
   }
   /*get session name by id*/
   public function getSessionByID($id){
   		$sql="SELECT id,session_name FROM subject_session WHERE id='".$id."'";
   		$result = $this->conn->query($sql);
   		if(!$result->num_rows){
   			return 'N/A';
   		}else{
   		  $row = $result->fetch_assoc();
   		  return (trim($row['session_name'])<>"") ? $row['session_name'] : "N/A";
   		}
   }


}