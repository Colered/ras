<?php
class Teacher extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	/*function for add professor*/
	public function addProfessor() {
		$txtPname = Base::cleanText($_POST['txtPname']);
		$txtAreaAddress = Base::cleanText($_POST['txtAreaAddress']);
		$dob = date("Y-m-d h:i:s", strtotime($_POST['dob']));
		$doj = date("Y-m-d h:i:s", strtotime($_POST['doj']));
		$sex = $_POST['sex'];
		$txtDegination = Base::cleanText($_POST['txtDegination']);
		$txtQualification = Base::cleanText($_POST['txtQualification']);
		$years = $_POST['years'];
		$months = $_POST['months'];
		$totalmonthExp = $years*12+$months;
		$txtEmail = Base::cleanText($_POST['txtEmail']);
		$txtUname = Base::cleanText($_POST['txtUname']);
		$result =  $this->conn->query("select email from teacher where email='".$txtEmail."'");
        $row_cnt_email = $result->num_rows;
        $result =  $this->conn->query("select username from teacher where username='".$txtUname."'");
		$row_cnt = $result->num_rows;
        if($row_cnt_email > 0){
            $this->conn->close();
            $message="'".$txtEmail."' email already exist in database.";
			$_SESSION['error_msg'] = $message;
			return 0;
        }elseif($row_cnt > 0){
            $this->conn->close();
            $message="'".$txtUname."' username already exist in database.";
			$_SESSION['error_msg'] = $message;
			return 0;
        }else{
           $sql = "INSERT INTO teacher (teacher_name, address, dob, doj, gender, designation, qualification, experience, email, username, date_add, date_update) VALUES ('".$txtPname."', '".$txtAreaAddress."', '".$dob."', '".$doj."', '".$sex."', '".$txtDegination."', '".$txtQualification."', '".$totalmonthExp."', '".$txtEmail."', '".$txtUname."', now(), '')";
           $rel = $this->conn->query($sql);
           if(!$rel){
              printf("%s\n", $this->conn->error);
   			  exit();
           }else{
             $this->conn->close();
             $message="Record has been added successfully.";
			 $_SESSION['succ_msg'] = $message;
             return 1;
           }
        }
	}
	/*function for edit professor*/
	public function editProfessor() {
		$edit_id = base64_decode($_POST['form_edit_id']);
		$txtPname = Base::cleanText($_POST['txtPname']);
		$txtAreaAddress = Base::cleanText($_POST['txtAreaAddress']);
		$dob = date("Y-m-d h:i:s", strtotime($_POST['dob']));
		$doj = date("Y-m-d h:i:s", strtotime($_POST['doj']));
		$sex = $_POST['sex'];
		$txtDegination = Base::cleanText($_POST['txtDegination']);
		$txtQualification = Base::cleanText($_POST['txtQualification']);
		$years = $_POST['years'];
		$months = $_POST['months'];
		$totalmonthExp = $years*12+$months;
		$sql = "UPDATE teacher SET
						teacher_name='".$txtPname."',
						address='".$txtAreaAddress."',
						dob='".$dob."',
						doj='".$doj."',
						gender='".$sex."',
						designation='".$txtDegination."',
						qualification='".$txtQualification."',
						experience='".$totalmonthExp."',
						date_update=now() WHERE id=$edit_id";
		$rel = $this->conn->query($sql);
		if(!$rel){
		  printf("%s\n", $this->conn->error);
		  exit();
		}else{
		 $this->conn->close();
		 $message="Record has been updated successfully.";
		 $_SESSION['succ_msg'] = $message;
		 return 1;
		}
	}
    //funtion to formate teacher experiance
	public function printTeacherExp($experience){
	    $years= floor($experience/12);
		$months = $experience-$years*12;
	    $yearexp = ($years > 0) ? $years.' year':'';
	    return $yearexp.' '.$months.' month';
	}

	//funtion to get all the teachers
	public function getTeachers()
	{
		$result =  $this->conn->query("select * from teacher order by teacher_name");
		if(!$result->num_rows){
			return 0;
		}
		return $result;
	}
	//function to add activity
	public function addActivities()
	{
		$program_year_id = $_POST['slctProgram'];
		$subject_id = $_POST['slctSubject'];
		$sessionid = $_POST['slctSession'];
		$group_id = 0;

		if(isset($program_year_id) && isset($subject_id) && isset($sessionid) && !empty($_POST['slctTeacher'])){

		    $reserved_flag = $_POST['reserved_flag'];
		    if(isset($reserved_flag) && $reserved_flag > 0)
		    {
				$teacher_id = isset($_POST['reserved_teacher_id_'.$reserved_flag]) ? $_POST['reserved_teacher_id_'.$reserved_flag] : 0;
				$room_id = isset($_POST['room_id_'.$reserved_flag]) ? $_POST['room_id_'.$reserved_flag] : 0;
				$time_slot_id = isset($_POST['tslot_id_'.$reserved_flag]) ? $_POST['tslot_id_'.$reserved_flag] : 0;
				$act_date = isset($_POST['activityDateCal_'.$reserved_flag]) ? $_POST['activityDateCal_'.$reserved_flag] : '';

				$sqlA = "SELECT name FROM teacher_activity WHERE 1=1";
				if($program_year_id)
					$sqlA .= " and program_year_id='".$program_year_id."'";
				if($subject_id)
					$sqlA .= " and subject_id='".$subject_id."'";
				if($sessionid)
					$sqlA .= " and session_id='".$sessionid."'";
				if($teacher_id)
					$sqlA .= " and teacher_id='".$teacher_id."'";
				if($room_id)
					$sqlA .= " and room_id='".$room_id."'";
				if($time_slot_id)
					$sqlA .= " and timeslot_id='".$time_slot_id."'";
				if($act_date<>"")
					$sqlA .= " and DATE_FORMAT(act_date, '%d-%m-%Y') = '".$act_date."'";
				  //echo '<br>'.$sqlA;
				$result =  $this->conn->query($sqlA);
				if(!$result->num_rows){
				    $act_date = date("Y-m-d h:i:s", strtotime($act_date));
					$SQL = "UPDATE teacher_activity SET
								   room_id = '".$room_id."',
								   timeslot_id = '".$time_slot_id."',
								   act_date = '".$act_date."',
								   reserved_flag = '1' where id='".$reserved_flag."'";
					$rel = $this->conn->query($SQL);
				}
				foreach($_POST['activitiesArr'] AS $val){
				   $sql22 = "update teacher_activity set reserved_flag='2' WHERE id='".$val."' AND id != '".$reserved_flag."'";
				   $this->conn->query($sql22);
				}
		    }
			$message="Record has been added successfully.";
			$_SESSION['succ_msg'] = $message;
			return 1;

		}else{
			$message="Please select program , subject, session and teacher.";
			$_SESSION['error_msg'] = $message;
			return 0;
		}
	}
	//function to edit activity
	public function editActivities()
	{
		$program_year_id = $_POST['program_year_id'];
		$subject_id = $_POST['subject_id'];
		$sessionid = $_POST['sessionid'];
		$group_id = 0;

		if(isset($program_year_id) && isset($subject_id) && isset($sessionid)){

		    $reserved_flag = $_POST['reserved_flag'];
		    if(isset($reserved_flag) && $reserved_flag > 0)
		    {
				$teacher_id = isset($_POST['reserved_teacher_id_'.$reserved_flag]) ? $_POST['reserved_teacher_id_'.$reserved_flag] : 0;
				$room_id = isset($_POST['room_id_'.$reserved_flag]) ? $_POST['room_id_'.$reserved_flag] : 0;
				$time_slot_id = isset($_POST['tslot_id_'.$reserved_flag]) ? $_POST['tslot_id_'.$reserved_flag] : 0;
				$act_date = isset($_POST['activityDateCal_'.$reserved_flag]) ? $_POST['activityDateCal_'.$reserved_flag] : '';

				$sqlA = "SELECT name FROM teacher_activity WHERE 1=1";
				if($program_year_id)
					$sqlA .= " and program_year_id='".$program_year_id."'";
				if($subject_id)
					$sqlA .= " and subject_id='".$subject_id."'";
				if($sessionid)
					$sqlA .= " and session_id='".$sessionid."'";
				if($teacher_id)
					$sqlA .= " and teacher_id='".$teacher_id."'";
				if($room_id)
					$sqlA .= " and room_id='".$room_id."'";
				if($time_slot_id)
					$sqlA .= " and timeslot_id='".$time_slot_id."'";
				if($act_date<>"")
					$sqlA .= " and DATE_FORMAT(act_date, '%d-%m-%Y') = '".$act_date."'";
				  //echo '<br>'.$sqlA;
				$result =  $this->conn->query($sqlA);
				if(!$result->num_rows){
				    $act_date = date("Y-m-d h:i:s", strtotime($act_date));
					$SQL = "UPDATE teacher_activity SET
								   room_id = '".$room_id."',
								   timeslot_id = '".$time_slot_id."',
								   act_date = '".$act_date."',
								   reserved_flag = '1' where id='".$reserved_flag."'";
					$rel = $this->conn->query($SQL);
				}
				foreach($_POST['activitiesArr'] AS $val){
				   $sql22 = "update teacher_activity set reserved_flag='2' WHERE id='".$val."' AND id != '".$reserved_flag."'";
				   $this->conn->query($sql22);
				}
		    }
			$message="Record has been updated successfully.";
			$_SESSION['succ_msg'] = $message;
			return 1;

		}else{
			$message="Please select program , subject, session and teacher.";
			$_SESSION['error_msg'] = $message;
			return 0;
		}
	}
	//function to get all teacher activities
	public function getTeachersAct()
	{
	    $sql = "SELECT ta.id,ta.name,ta.program_year_id,ta.subject_id,ta.session_id,ta.teacher_id,ta.group_id,ta.room_id,ta.timeslot_id,ta.reserved_flag,ta.act_date,s.subject_name,ss.session_name,t.teacher_name,t.email,py.name program_name FROM teacher_activity ta
	            left join subject s on(s.id = ta.subject_id)
	            left join subject_session ss on(ss.id=ta.session_id)
	            left join teacher t on(t.id = ta.teacher_id)
	            left join program_years py on(py.id=ta.program_year_id) ORDER BY ta.name";
		$result =  $this->conn->query($sql);
		return $result;
	}
	//add teacher availability
	public function addTeacherAvailability()
	{
		print_r($_POST); die;
		$result =  $this->conn->query("select * from teacher order by teacher_name");
		if(!$result->num_rows){
			return 0;
		}
		return $result;
	}
	//get all teachers availability
	public function getTeacherAvailRule()
	{
		$teac_query="select id, rule_name, start_date, end_date from teacher_availability_rule ORDER BY id DESC";
		$q_res = mysqli_query($this->conn, $teac_query);
		if(mysqli_num_rows($q_res)<=0){
			$message="No teacher availability rule exist.";
			$_SESSION['error_msg'] = $message;
		}
		return $q_res;
	}
	//get the days for teacher availability
	public function getTeacherAvailDay($id)
	{
		$area_query="select id, timeslot_id, day_name from teacher_availability_rule_day_map where teacher_availability_rule_id ='".$id."'";
		$q_res = mysqli_query($this->conn, $area_query);
		return $q_res;
	}
	//get the timeslot for teacher availability
	public function getTeacherAvailTimeslot($ids)
	{
		$area_query="select id, timeslot_range from timeslot where id IN(".$ids.")";
		$q_res = mysqli_query($this->conn, $area_query);
		return $q_res;
	}
	//get all rule ids from teacher
	public function getRuleIdsForTeacher($ids)
	{
		$area_query="select teacher_availability_rule_id from teacher_availability_rule_teacher_map where teacher_id =".$ids;
		$q_res = mysqli_query($this->conn, $area_query);
		$allIds = array();
		while($data = $q_res->fetch_assoc()){
			$allIds[] =  $data['teacher_availability_rule_id'];
		}
		return $allIds;
	}
	//add and update teacher availability
	public function addUpdateTeacAvail(){
		$teacherId = base64_decode($_POST['slctTeacher']);
		//delete old mapping
		$del_teacRuleMap_query="delete from teacher_availability_rule_teacher_map where teacher_id='".$teacherId."'";
		$qry = mysqli_query($this->conn, $del_teacRuleMap_query);
		//add new mapping
		foreach($_POST['ruleval'] as $ruleId){
			$currentDateTime = date("Y-m-d H:i:s");
			$result = mysqli_query($this->conn, "INSERT INTO teacher_availability_rule_teacher_map VALUES ('', '".$ruleId."', '".$teacherId."', '".$currentDateTime."', '".$currentDateTime."');");
		}
		//delete old exceptions
		$del_teacRuleMap_query="delete from teacher_availability_exception where teacher_id='".$teacherId."'";
		$qry = mysqli_query($this->conn, $del_teacRuleMap_query);
		//add new exceptions
		foreach($_POST['exceptionDate'] as $exceptionDate){
			$currentDateTime = date("Y-m-d H:i:s");
			$result = mysqli_query($this->conn, "INSERT INTO teacher_availability_exception VALUES ('', '".$teacherId."', '".$exceptionDate."', '".$currentDateTime."', '".$currentDateTime."');");
		}
		return 1;
	}
	//view all teacher availability
	public function viewTeachAvail(){
		$teachAvail_query="select tartm.id, tr.teacher_name, tartm.teacher_availability_rule_id, tartm.teacher_id  from teacher_availability_rule_teacher_map as tartm LEFT JOIN teacher as tr ON tartm.teacher_id = tr.id GROUP BY tartm.teacher_id";
		$q_res = mysqli_query($this->conn, $teachAvail_query);
		return $q_res;
	}
	//get the all rule name associated by a teacher
	public function getRulesForTeacher($ids)
	{
		$rule_query="select tartm.teacher_availability_rule_id, tar.rule_name from teacher_availability_rule_teacher_map as tartm LEFT JOIN teacher_availability_rule as tar on tartm.teacher_availability_rule_id = tar.id  where tartm.teacher_id =".$ids;
		$q_res = mysqli_query($this->conn, $rule_query);
		return $q_res;
	}
	//get all exception for a teacher
	public function getExceptionForTeacher($ids)
	{
		$excep_query="select exception_date from teacher_availability_exception where teacher_id =".$ids;
		$q_excep = mysqli_query($this->conn, $excep_query);
		return $q_excep;
	}
	//add teacher activity row in table if not exist
	public function insertActivityRow($program_year_id,$subject_id,$sessionid,$teachersArr)
	{
		foreach($teachersArr AS $val)
		{
		   $teacher_id = $val;
		   $sqlA = "SELECT name FROM teacher_activity WHERE 1=1";
		   if($program_year_id)
				$sqlA .= " and program_year_id='".$program_year_id."'";
		   if($subject_id)
				$sqlA .= " and subject_id='".$subject_id."'";
		   if($sessionid)
				$sqlA .= " and session_id='".$sessionid."'";
		   if($teacher_id)
				$sqlA .= " and teacher_id='".$teacher_id."'";
			//echo '<br>'.$sqlA;
			$result =  $this->conn->query($sqlA);
			if(!$result->num_rows){
				$result = $this->conn->query("SELECT name FROM teacher_activity ORDER BY id DESC LIMIT 1");
				$dRow = $result->fetch_assoc();
				$actCnt = substr($dRow['name'],1);
				$actName = 'A'.($actCnt+1);
				$SQL = "INSERT INTO teacher_activity (name, program_year_id, subject_id, session_id, teacher_id, date_add) VALUES ('".$actName."', '".$program_year_id."', '".$subject_id."', '".$sessionid."', '".$teacher_id."', NOW())";
				$rel = $this->conn->query($SQL);
			}
		}
	}
	/*get teacher name by id*/
	public function getTeacherByID($id)
	{
		$sql="SELECT id,teacher_name,email FROM teacher WHERE id='".$id."'";
		$result = $this->conn->query($sql);
		if(!$result->num_rows){
			return '';
		}else{
		  $row = $result->fetch_assoc();
		  return $row['teacher_name'].'('.$row['email'].')';
		}
    }
}
