<?php
class SpecialActivity extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	public function getSpecialAvailDay($id)
	{
		$area_query="select id, actual_timeslot_id , duration , day_name from special_activity_rule_day_map where special_activity_rule_id ='".$id."'";
		$q_res = mysqli_query($this->conn, $area_query);
		return $q_res;
	}
	public function getSpecialAvailRule()
	{
		$specia_act_query="select id, rule_name, start_date, end_date from special_activity_rule WHERE rule_name<>'Always Available' ORDER BY id DESC";
		$q_res = mysqli_query($this->conn, $specia_act_query);
		return $q_res;
	}
	public function ruleStartEndDate($rule_id){
		$query = mysqli_query ($this->conn, "SELECT start_date , end_date FROM  special_activity_rule WHERE  id='".$rule_id."' ");
		$data = $query->fetch_assoc();
		return $data;
	}
	public function activityLastReocrd(){
		$query = mysqli_query($this->conn, "SELECT id,name FROM teacher_activity ORDER BY id DESC LIMIT 1");
		$data=$query->fetch_assoc();
		return $data;
	}
	public function ruleTimeslotandDay($ruleId){
		$query = mysqli_query($this->conn, "SELECT id,actual_timeslot_id,duration,day FROM  special_activity_rule_day_map  WHERE  special_activity_rule_id='".$ruleId."' ");
		while($data = $query->fetch_assoc()){
				$timeslot[$data['day']] =  $data['actual_timeslot_id'].'-'.$data['duration'];
		}
		return $timeslot;
	}
	public function getExceptionDate($ruleId){
		$exceptionDate=array();
		$query = mysqli_query($this->conn, "SELECT exception_date FROM special_activity_exception  WHERE  special_activity_rule_id='".$ruleId."' ");
		while($data = $query->fetch_assoc()){
				$exceptionDate[] =  $data['exception_date'];
		}
		return $exceptionDate;
	}
	public function specialActivityDetail($special_act_id){
		$sql = "SELECT ta.id,ta.name,ta.program_year_id,ta.cycle_id,ta.subject_id,ta.session_id,ta.teacher_id,ta.group_id,ta.room_id,ta.timeslot_id,ta.start_time,ta.reserved_flag,ta.act_date,sa.teacher_activity_id,sa.id as special_id,sa.special_activity_rule_id,sa.area_id,sa.special_activity_type,sa.duration FROM teacher_activity ta
						inner join  special_activity_mapping sa on(sa.teacher_activity_id = ta.id)
						WHERE ta.id='".$special_act_id."' ";
		$query = mysqli_query($this->conn,$sql);
		$data=$query->fetch_assoc();
		return $data;
	}
	public function getStartTime($start_time_id){
		$ts_sql = "SELECT start_time FROM timeslot WHERE id='".$start_time_id."'";
		$query = mysqli_query($this->conn,$ts_sql);
		$data=$query->fetch_assoc();
		return $data;
	}
	public function addSpecialActivity(){
			$subject_id="";
			$session_id="";
			$start_time="";
			$currentDateTime = date("Y-m-d H:i:s");
			$obj_SA = new SpecialActivity();
			$last_activity_record=$obj_SA->activityLastReocrd();
			$act_name_num= ltrim ($last_activity_record['name'],'A');
			$objTeach = new Teacher();
			if($_POST['special_activity']!="" && $_POST['special_activity_type']!="2"){
			  $timeslotIdsArray = array();
			  if ($_POST['duration'] > 15) {
				   $noOfslots = $_POST['duration'] / 15;
				   $startTS = $_POST['ot_tslot_id'];
				   $endTS = $startTS + $noOfslots;
				   for ($i = $startTS; $i < $endTS; $i++) {
					$timeslotIdsArray[] = $i;
				   }
			  }else {
			   $timeslotIdsArray[] = $_POST['ot_tslot_id'];
			  }
			   	$act_name_num = $act_name_num+1;
				$act_name='A'.$act_name_num;
				$ot_timeslot_str = implode(',',$timeslotIdsArray);
				$ts_id_Arr = explode(',',$ot_timeslot_str);
				$start_time = $ts_id_Arr['0'];
				$result = mysqli_query($this->conn, "INSERT INTO teacher_activity VALUES ('','".$act_name."', '".$_POST['slctProgram']."','".$_POST['slctCycle']."', '".$subject_id."','".$session_id."','".$_POST['slctTeacher']."','','".$_POST['slctRoom']."','".$ot_timeslot_str."','".$start_time."','".$_POST['oneTimeDate']."', '".$_POST['special_activity']."' ,'".$currentDateTime."','".$currentDateTime."','') ");
					$last_id = mysqli_insert_id($this->conn);
					if($last_id!=''){
						$result_mapping = mysqli_query($this->conn, "INSERT INTO special_activity_mapping VALUES ('','".$last_id."','".$ruleId."','".$_POST['slctArea']."','".$_POST['special_activity_type']."','".$_POST['duration']."','".$currentDateTime."','".$currentDateTime."') ");
					}
				if($result){
					$message="Activity has been inserted successfully";
					$_SESSION['succ_msg'] = $message;
					header('Location: special_activity_view.php');
				}else{
					$message="Not inserted ";
					$_SESSION['error_msg'] = $message;
					header('Location: special_activity.php');
				}	
				return 1;
		   	}else{
				//deleting old mapping
				foreach($_POST['ruleval'] as $ruleId){
					$sql = "select teacher_activity_id from  special_activity_mapping where special_activity_rule_id ='".$ruleId."' ";
					$query = mysqli_query($this->conn,$sql);
					$teacher_activity_id_arr=array();
					while($data_teahcer_act=$query->fetch_assoc()){
						$teacher_activity_id_arr[] = $data_teahcer_act['teacher_activity_id'];
					}
					if(count($teacher_activity_id_arr)>0){
						foreach($teacher_activity_id_arr as $teacher_act_id){
							$sql_delete_teache_act = "delete from teacher_activity where id='".$teacher_act_id."'";
							$query_delete = mysqli_query($this->conn,$sql_delete_teache_act);
							$sql_delete_mapping_act = "delete from special_activity_mapping where teacher_activity_id='".$teacher_act_id."'";
							$query_delete1 = mysqli_query($this->conn,$sql_delete_mapping_act);
						}
					}
				}
				//inserting new mapping
				foreach($_POST['ruleval'] as $ruleId){
				$ruleStartEnddate = $obj_SA->ruleStartEndDate($ruleId);
				$ruleTimeslot = $obj_SA->ruleTimeslotandDay($ruleId);
				$startPADate=$ruleStartEnddate['start_date'];
				$endPADate=$ruleStartEnddate['end_date'];
				$endPADate = date('Y-m-d',strtotime($endPADate . "+1 days"));
				$begin = new DateTime($startPADate);
				$end = new DateTime($endPADate);
				$interval = DateInterval::createFromDateString('1 day');
				$period = new DatePeriod($begin, $interval, $end);
					foreach ( $period as $dt ){
							$act_name_num = $act_name_num+1;
							$act_name='A'.$act_name_num ;
							$date_str=$dt->format( "Y-m-d \n" );
							//check if the date is not added as exception for the selected rule
							$exception_query="select id from special_activity_exception where special_activity_rule_id='".$ruleId."' AND exception_date='".$date_str."'";
							$q_res = mysqli_query($this->conn, $exception_query);
							$dataAll = mysqli_fetch_assoc($q_res);
							if(count($dataAll)==0){
							$date_wk_day=date('l', strtotime($date_str));
							$day_of_week = date('N', strtotime($date_wk_day));
							$day_num=$day_of_week-1;
							foreach($ruleTimeslot as  $key=>$val){
							 if($key==$day_num){
							 	$ts_durationArr=explode('-',$val);
								$ts_id_Arr = explode(',',$ts_durationArr[0]);
								$start_time = $ts_id_Arr['0'];	
								$duration = $ts_durationArr[1];
								$result = mysqli_query($this->conn, "INSERT INTO teacher_activity VALUES ('','".$act_name."', '".$_POST['slctProgram']."','".$_POST['slctCycle']."', '".$subject_id."','".$session_id."','".$_POST['slctTeacher']."','','".$_POST['slctRoom']."','".$ts_durationArr[0]."','".$start_time."','".$date_str."', '".$_POST['special_activity']."' ,'".$currentDateTime."','".$currentDateTime."','') ");
								$last_id = mysqli_insert_id($this->conn);
								if($last_id!=''){
									$result_mapping = mysqli_query($this->conn, "INSERT INTO special_activity_mapping VALUES ('','".$last_id."','".$ruleId."','".$_POST['slctArea']."','".$_POST['special_activity_type']."','".$duration."','".$currentDateTime."','".$currentDateTime."') ");
								}
							  }
					   	    }
						  }  
					  }
				  }
				$message="Activities have been inserted successfully";
				$_SESSION['succ_msg'] = $message;
				header('Location: special_activity_view.php');
				return 1;
			}
		   
	}
	public function updateSpecialActivity(){
		if($_POST['special_activity_type']!="2" && $_POST['duration']!=""){
			  $timeslotIdsArray = array();
			  if ($_POST['duration'] > 15) {
				   $noOfslots = $_POST['duration'] / 15;
				   $startTS = $_POST['ot_tslot_id'];
				   $endTS = $startTS + $noOfslots;
				   for ($i = $startTS; $i < $endTS; $i++) {
					$timeslotIdsArray[] = $i;
				   }
			  }else {
			   $timeslotIdsArray[] = $_POST['ot_tslot_id'];
			  }
			   	$ot_timeslot_str = implode(',',$timeslotIdsArray);
				$ts_id_Arr = explode(',',$ot_timeslot_str);
				$start_time = $ts_id_Arr['0'];
				$result_update = mysqli_query($this->conn, "Update teacher_activity set timeslot_id = '".$ot_timeslot_str."',start_time = '".$start_time."', act_date = '".$_POST['oneTimeDate']."', date_update = '".date("Y-m-d H:i:s")."' where id='".$_POST['special_act_id']."' ");
				if($result_update){
					$result_mapping_update = mysqli_query($this->conn, "Update  special_activity_mapping set duration = '".$_POST['duration']."',date_update = '".date("Y-m-d H:i:s")."' where teacher_activity_id='".$_POST['special_act_id']."' ");
				}
				if($result_update==1 && $result_mapping_update==1){
					$message="Activity has been updated successfully";
					$_SESSION['succ_msg'] = $message;
					header('Location: special_activity_view.php');
				}else{
					$message="Not updated ";
					$_SESSION['error_msg'] = $message;
					header('Location: special_activity.php');
				}	
			}else{
				$message="Not updated ";
				$_SESSION['error_msg'] = $message;
				header('Location: special_activity.php');
			}
	}
	
	public function getSpecialActivityDetail($rule_ids,$special_act){
		$sql = "SELECT ta.id,ta.name,ta.program_year_id,ta.cycle_id,ta.subject_id,ta.session_id,ta.teacher_id,ta.group_id,ta.room_id,ta.timeslot_id,ta.reserved_flag,ta.act_date,s.subject_name,ss.session_name,t.teacher_name,t.email,py.name program_name,rm.room_name  FROM teacher_activity ta
						left join subject s on(s.id = ta.subject_id)
						left join subject_session ss on(ss.id=ta.session_id)
						left join teacher t on(t.id = ta.teacher_id)
						left join program_years py on(py.id=ta.program_year_id)
						left join room rm on(rm.id=ta.room_id)
						left join special_activity_mapping sam on(ta.id = sam.teacher_activity_id)
						WHERE ta.reserved_flag ='".$special_act."'
						and sam.special_activity_rule_id IN ($rule_ids)";
		$result =  $this->conn->query($sql);
		return $result;				
	}
}
