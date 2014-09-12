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
	public function editProfessor()
	{
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
		$sessionid = isset($_POST['slctSession']) ? $_POST['slctSession'] : 0;
		$group_id = 0;

		if(isset($program_year_id) && isset($subject_id) && !empty($_POST['slctTeacher'])){
		    $insertIdsArr = array();
		    $atleast_one_res = false;
			foreach($_POST['slctTeacher'] AS $val){
			   $teacher_id = $val;
			   $room_id = isset($_POST['room_id_'.$teacher_id]) ? $_POST['room_id_'.$teacher_id] : 0;
			   $time_slot_id = isset($_POST['tslot_id_'.$teacher_id]) ? $_POST['tslot_id_'.$teacher_id] : 0;
			   $reserved_flag = ($_POST['reserved_flag']==$teacher_id) ? 1 : 0;
			   if($reserved_flag){
			     	$atleast_one_res = true;
			   }
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
                //echo '<br>'.$sqlA;
				$result =  $this->conn->query($sqlA);
				if(!$result->num_rows){
				    $result = $this->conn->query("SELECT name FROM teacher_activity ORDER BY id DESC LIMIT 1");
				    $dRow = $result->fetch_assoc();
				    $actCnt = substr($dRow['name'],1);
				    $actName = 'A'.($actCnt+1);
					$SQL = "INSERT INTO teacher_activity (name, program_year_id, subject_id, session_id, teacher_id, group_id, room_id, timeslot_id, reserved_flag, date_add) VALUES ('".$actName."', '".$program_year_id."', '".$subject_id."', '".$sessionid."', '".$teacher_id."', '".$group_id."', '".$room_id."', '".$time_slot_id."', '".$reserved_flag."', NOW())";
					$rel = $this->conn->query($SQL);
					if(!$reserved_flag){
					   $insertIdsArr[] = $this->conn->insert_id;
					}
				}
			}
			if(!empty($insertIdsArr) && $atleast_one_res==true){
               foreach($insertIdsArr as $vv){
                  $sql22 = "update teacher_activity set reserved_flag='2' where id='".$vv."'";
                  $this->conn->query($sql22);
               }
			}
			$message="Record has been added successfully.";
			$_SESSION['succ_msg'] = $message;
			return 1;

		}else{
			$message="Please select program , subject and teacher.";
			$_SESSION['succ_msg'] = $message;
			return 0;
		}
	}
	//function to edit activity
	public function editActivities()
	{
		$program_year_id = $_POST['program_year_id'];
		$subject_id = $_POST['subject_id'];
		$sessionid = isset($_POST['sessionid']) ? $_POST['sessionid'] : 0;
		$teacher_id = $_POST['teacher_id'];
		$group_id = 0;

		if(isset($program_year_id) && isset($subject_id) && isset($teacher_id) && !empty($_POST['activitiesArr'])){
			foreach($_POST['activitiesArr'] AS $val){
			   $activity_id = $val;
			   $room_id = isset($_POST['room_id_'.$activity_id]) ? $_POST['room_id_'.$activity_id] : 0;
			   $time_slot_id = isset($_POST['tslot_id_'.$activity_id]) ? $_POST['tslot_id_'.$activity_id] : 0;
			   $reserved_flag = ($_POST['reserved_flag']==$activity_id) ? 1 : 0;

			   //$this->conn->query("update teacher_activity set reserved_flag='".$reserved_flag."' where id='".$activity_id."'");

			   $sqlA = "SELECT id FROM teacher_activity WHERE 1=1";
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
				//echo '<br>'.$sqlA;
				$result =  $this->conn->query($sqlA);
				if(!$result->num_rows){
					$SQL = "UPDATE teacher_activity SET
									room_id='".$room_id."',
									timeslot_id='".$time_slot_id."',
									reserved_flag='".$reserved_flag."',
									date_update = NOW() WHERE id='".$activity_id."'";
					$rel = $this->conn->query($SQL);

				    $message = 'Record has been updated.';
				    $_SESSION['act_'.$activity_id] = $message;
				}else{
				   $message = 'This activity is already exist.';
				   $_SESSION['act_'.$activity_id] = $message;
				}
			}

			return 1;

		}else{
			$message="There is no activity selected to edit.";
			$_SESSION['succ_msg'] = $message;
			return 0;
		}
	}
	//function to get all teacher activities
	public function getTeachersAct()
	{
	    $sql = "SELECT ta.id,ta.name,ta.program_year_id,ta.subject_id,ta.session_id,ta.teacher_id,ta.group_id,ta.room_id,ta.timeslot_id,ta.reserved_flag,s.subject_name,ss.session_name,t.teacher_name,t.email,py.name program_name FROM teacher_activity ta
	            left join subject s on(s.id = ta.subject_id)
	            left join subject_session ss on(ss.id=ta.session_id)
	            left join teacher t on(t.id = ta.teacher_id)
	            left join program_years py on(py.id=ta.program_year_id) ORDER BY ta.name";
		$result =  $this->conn->query($sql);
		return $result;
	}

}
