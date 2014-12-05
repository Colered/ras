<?php
class Teacher extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	/*function for add professor*/
	public function addProfessor() {
		$txtPname = Base::cleanText($_POST['txtPname']);
		$proftype = $_POST['proftype'];
		$txtAreaAddress = Base::cleanText($_POST['txtAreaAddress']);
		$dob = ($_POST['dob']<>'')? date("Y-m-d h:i:s", strtotime($_POST['dob'])) : '0000:00:00 00:00:00';
		$doj = ($_POST['doj']<>'')? date("Y-m-d h:i:s", strtotime($_POST['doj'])) : '0000:00:00 00:00:00';
		$sex = $_POST['sex'];
		$txtDegination = Base::cleanText($_POST['txtDegination']);
		$txtQualification = Base::cleanText($_POST['txtQualification']);
		$txtPayrate = Base::cleanText($_POST['txtPayrate']);
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
           $sql = "INSERT INTO teacher (teacher_name,teacher_type, address, dob, doj, gender, designation, qualification, payrate, experience, email, username, date_add, date_update) VALUES ('".$txtPname."','".$proftype."', '".$txtAreaAddress."', '".$dob."', '".$doj."', '".$sex."', '".$txtDegination."', '".$txtQualification."', '".$txtPayrate."', '".$totalmonthExp."', '".$txtEmail."', '".$txtUname."', now(), '')";
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
		$proftype = $_POST['proftype'];
		$txtPname = Base::cleanText($_POST['txtPname']);
		$txtAreaAddress = Base::cleanText($_POST['txtAreaAddress']);
		$dob = ($_POST['dob']<>'')? date("Y-m-d h:i:s", strtotime($_POST['dob'])) : '0000:00:00 00:00:00';
		$doj = ($_POST['doj']<>'')? date("Y-m-d h:i:s", strtotime($_POST['doj'])) : '0000:00:00 00:00:00';
		$sex = $_POST['sex'];
		$txtDegination = Base::cleanText($_POST['txtDegination']);
		$txtQualification = Base::cleanText($_POST['txtQualification']);
		$txtPayrate = Base::cleanText($_POST['txtPayrate']);
		$years = $_POST['years'];
		$months = $_POST['months'];
		$totalmonthExp = $years*12+$months;
		$sql = "UPDATE teacher SET
						teacher_name='".$txtPname."',
						teacher_type='".$proftype."',
						address='".$txtAreaAddress."',
						dob='".$dob."',
						doj='".$doj."',
						gender='".$sex."',
						designation='".$txtDegination."',
						qualification='".$txtQualification."',
						payrate='".$txtPayrate."',
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
                //check if a reserved activity already exist
				$preReserved_Id = $this->getReservedByProgSubjSess($program_year_id,$subject_id,$sessionid);
                //check activity availability
				$resp = $this->checkActTeaRoomTimeDate($teacher_id,$room_id,$time_slot_id,$act_date,$preReserved_Id);
				if(!$resp){
				    $act_date = date("Y-m-d h:i:s", strtotime($act_date));
					$SQL = "UPDATE teacher_activity SET
								   room_id = '".$room_id."',
								   timeslot_id = '".$time_slot_id."',
								   act_date = '".$act_date."',
								   reserved_flag = '1' where id='".$reserved_flag."'";
					$rel = $this->conn->query($SQL);
				}
				foreach($_POST['activitiesArr'] AS $val){
				  if($reserved_flag != $val){
					   $sql22 = "update teacher_activity set
										reserved_flag='2',
										room_id = '0',
										timeslot_id='0',
										act_date = '0000:00:00 00:00:00' WHERE id='".$val."'";
					   $this->conn->query($sql22);
				   }
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
                //check if a reserved activity already exist
				$preReserved_Id = $this->getReservedByProgSubjSess($program_year_id,$subject_id,$sessionid);
                //check activity availability
				$resp = $this->checkActTeaRoomTimeDate($teacher_id,$room_id,$time_slot_id,$act_date,$preReserved_Id);
				if(!$resp){
					$act_date = date("Y-m-d h:i:s", strtotime($act_date));
					$SQL = "UPDATE teacher_activity SET
								   room_id = '".$room_id."',
								   timeslot_id = '".$time_slot_id."',
								   act_date = '".$act_date."',
								   reserved_flag = '1' where id='".$reserved_flag."'";
					$rel = $this->conn->query($SQL);
				}
				foreach($_POST['activitiesArr'] AS $val){
				  if($reserved_flag != $val){
					   $sql22 = "update teacher_activity set
										reserved_flag='2',
										room_id = '0',
										timeslot_id='0',
										act_date = '0000:00:00 00:00:00' WHERE id='".$val."'";
					   $this->conn->query($sql22);
				   }
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
	//function to check activity availability
	public function checkActTeaRoomTimeDate($teacher_id,$room_id,$tslot_id,$act_date_val,$act_id)
	{
		$sqlA = "SELECT name FROM teacher_activity WHERE id !='".$act_id."'";
		$sqlA .= " and (teacher_id='".$teacher_id."' or room_id='".$room_id."')";
		$sqlA .= " and (timeslot_id='".$tslot_id."' and DATE_FORMAT(act_date, '%d-%m-%Y') = '".$act_date_val."')";
		//echo '<br>'.$sqlA;die;
		$result = $this->conn->query($sqlA);
		if($result->num_rows){
		   return '1';
		}else{
		   return '0';
		}
	}
	//function to check if a reserved activity already exist
	public function getReservedByProgSubjSess($program_year_id,$subject_id,$sessionid)
	{
		$slqT="SELECT id,reserved_flag FROM teacher_activity WHERE program_year_id='".$program_year_id."' AND subject_id='".$subject_id."' AND session_id='".$sessionid."' ORDER BY id";
		$relT = $this->conn->query($slqT);
		while($data= $relT->fetch_assoc()){
		   if($data['reserved_flag']==1){
		      return $data['id'];
		   }
		}
		return 0;
	}
	//function to get all teacher activities
	public function getTeachersAct()
	{
	    $sql = "SELECT ta.id,td.activity_id reserved_act_id,ta.name,ta.program_year_id,ta.cycle_id,ta.subject_id,ta.session_id,ta.teacher_id,ta.group_id,ta.room_id,ta.timeslot_id,ta.reserved_flag,ta.act_date,s.subject_name,ss.session_name,t.teacher_name,t.email,py.name program_name FROM teacher_activity ta
						left join subject s on(s.id = ta.subject_id)
						left join subject_session ss on(ss.id=ta.session_id)
						left join teacher t on(t.id = ta.teacher_id)
						left join timetable_detail td on(td.activity_id=ta.id)
						left join program_years py on(py.id=ta.program_year_id) ORDER BY ta.name";
		$result =  $this->conn->query($sql);
		return $result;
	}
	public function getSessionFromTT()
	{
		$sql = "SELECT session_id FROM timetable_detail";
		$result =  $this->conn->query($sql);
		$sess_array = array();
		while($row = mysqli_fetch_array($result))
		{
			$sess_array[] = $row['session_id'];
		}
		return $sess_array;
	}
	//get all teachers availability
	public function getTeacherAvailRule()
	{
		$teac_query="select id, rule_name, start_date, end_date from teacher_availability_rule ORDER BY id DESC";
		$q_res = mysqli_query($this->conn, $teac_query);
		/*if(mysqli_num_rows($q_res)<=0){
			$message="No teacher availability rule exist.";
			$_SESSION['error_msg'] = $message;
		}*/
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
		$teachAvail_query="select tartm.id, tr.teacher_name, tr.email, tartm.teacher_availability_rule_id, tartm.teacher_id  from teacher_availability_rule_teacher_map as tartm LEFT JOIN teacher as tr ON tartm.teacher_id = tr.id GROUP BY tartm.teacher_id";
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
	public function insertActivityRow($program_year_id,$cycle_id,$subject_id,$sessionid,$teachersArr)
	{
		foreach($teachersArr AS $val)
		{
		   $teacher_id = $val;
		   $sqlA = "SELECT id,name FROM teacher_activity WHERE 1=1";
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
				$SQL = "INSERT INTO teacher_activity (name, program_year_id,cycle_id, subject_id, session_id, teacher_id, date_add) VALUES ('".$actName."', '".$program_year_id."', '".$cycle_id."', '".$subject_id."', '".$sessionid."', '".$teacher_id."', NOW())";
				$rel = $this->conn->query($SQL);
			}else{
			   while($row = $result->fetch_assoc()){
			      $sql = "UPDATE teacher_activity SET cycle_id='".$cycle_id."' WHERE id='".$row['id']."'";
				  $rel = $this->conn->query($sql);
			   }
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
	public function getWebTeachersDetail($program_id='',$teacher_id='',$subject_id='',$room_id='',$area_id='',$teacher_type_id='',$cycle_id='')
	{ 
	    $row=$rowmainArr=$newArr=array();
		if($cycle_id!=""){
		$cycleArr=explode("#",$cycle_id);
		$cycle_ids=explode(",",$cycleArr['0']);
		for($i=0;$i<count($cycle_ids);$i++){
		    $sql_query="SELECT we.cal_name, we.cal_description, we.cal_date, we.cal_time, we.cal_id, we.cal_ext_for_id, we.cal_priority, we.cal_access, we.cal_duration, weu.cal_status, we.cal_create_by, weu.cal_login, we.cal_type, we.cal_location, we.cal_url, we.cal_due_date, we.cal_due_time, weu.cal_percent, we.cal_mod_date, we.cal_mod_time FROM webcal_entry we,webcal_entry_user weu WHERE we.cal_id = weu.cal_id ";
		$sql_query .= "and we.cycle_id='".$cycle_ids[$i]."' ";
			
		if($teacher_id!=""){
		
		  $sql_query .= "and we.teacher_id='".$teacher_id."' ";
		}
		if($program_id!=""){
		  $sql_query .= "and we.program_year_id='".$program_id."' ";
		}
		if($subject_id!=""){
		   $sql_query .= "and we.subject_id='".$subject_id."' ";
		}
		if($room_id!=""){
		   $sql_query .= "and we.room_id='".$room_id."' ";
		}
		if($area_id!=""){
		   $sql_query .= "and we.area_id='".$area_id."' ";
		}
		if($teacher_type_id!=""){
		   $sql_query .= "and we.teacher_type_id='".$teacher_type_id."' ";
		}
		$sql_query.="ORDER BY we.cal_time, we.cal_name";
		$result =  $this->conn->query($sql_query);
			if($result->num_rows){
				while ($rows =$result->fetch_assoc()){
					$row[]=$rows;
				}
		   }
	   }
	 }else{
		$sql_query="SELECT we.cal_name, we.cal_description, we.cal_date, we.cal_time, we.cal_id, we.cal_ext_for_id, we.cal_priority, we.cal_access, we.cal_duration, weu.cal_status, we.cal_create_by, weu.cal_login, we.cal_type, we.cal_location, we.cal_url, we.cal_due_date, we.cal_due_time, weu.cal_percent, we.cal_mod_date, we.cal_mod_time FROM webcal_entry we,webcal_entry_user weu WHERE we.cal_id = weu.cal_id ";
		if($teacher_id!=""){
		  $sql_query .= "and we.teacher_id='".$teacher_id."' ";
		}
		if($program_id!=""){
		  $sql_query .= "and we.program_year_id='".$program_id."' ";
		}
		if($subject_id!=""){
		   $sql_query .= "and we.subject_id='".$subject_id."' ";
		}
		if($room_id!=""){
		   $sql_query .= "and we.room_id='".$room_id."' ";
		}
		if($area_id!=""){
		   $sql_query .= "and we.area_id='".$area_id."' ";
		}
		if($teacher_type_id!=""){
		   $sql_query .= "and we.teacher_type_id='".$teacher_type_id."' ";
		}
		$sql_query.="ORDER BY we.cal_time, we.cal_name";
		$result =  $this->conn->query($sql_query);
		if($result->num_rows){
			while ($rows =$result->fetch_assoc()){
					$row[]=$rows;
			}
		}
	  }
	  if(count($row)>0){
		 $rowNewArr=array(array());
		  for($i=0;$i<count($row);$i++){
		   $j=0;
		    foreach($row[$i] as $key=>$val){
			  $rowNewArr[$i][$j]=$val;
			  $j++;
		   	}
	   	  }
		 return $rowNewArr;
		}
	}
	//function to check allocated room for a subject
	public function getAllocatedRoomBySubject($subject_id)
	{
	    $SQL = "SELECT room_id FROM teacher_activity WHERE subject_id='".$subject_id."' AND reserved_flag='1'";
	    $result =  $this->conn->query($SQL);
	   	if($result->num_rows){
			$rows = $result->fetch_assoc();
			return $rows['room_id'];
		}
		return '';
	}
	public function getTimeslotId($timeSoltArr)
	{
		$ts_array = explode(",",$timeSoltArr);
		$timeslots = array();
		foreach($ts_array as $val)
		{			
			$time = explode("-",$val);
			$start_time  = trim($time['0']);
			$end_time = trim($time['1']);
			$sql_time_slct = "select id from timeslot where start_time = '".$start_time."' OR end_time = '".$end_time."'";
			//get all the ids between two nos
			$q_res= mysqli_query($this->conn, $sql_time_slct);
			$tempIdRange= array();
			while($data = $q_res->fetch_assoc()){
				$tempIdRange[] =  $data['id'];
			}
			for($i=min($tempIdRange); $i<=max($tempIdRange); $i++){
				$timeslots[] = $i;
			}				
		}
		$timeslotIds = implode(',',$timeslots);		
		return $timeslotIds;
	}
	public function getTeachersType()
	{
		$result =  $this->conn->query("select * from teacher_type order by teacher_type_name");
		return $result;
	}
	public function getTeacherTypeById($id)
	{
		$result =  $this->conn->query("select * from teacher_type where id = '".$id."'");
		return $result;
	}
}
