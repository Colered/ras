<?php
class SpecialActivity extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	//get time details from rule id
	public function getSpecialAvailDay($id)
	{
		$area_query="select id, actual_timeslot_id , duration , day_name from special_activity_rule_day_map where special_activity_rule_id ='".$id."'";
		$q_res = mysqli_query($this->conn, $area_query);
		return $q_res;
	}
	//get availability details of special activity by name
	public function getSpecialAvailRule()
	{
		$specia_act_query="select id, rule_name,occurrence,week1,week2, start_date, end_date from special_activity_rule WHERE rule_name<>'Always Available' ORDER BY id DESC";
		$q_res = mysqli_query($this->conn, $specia_act_query);
		return $q_res;
	}
	//get rule details of a rule id
	public function ruleStartEndDate($rule_id){
		$query = mysqli_query ($this->conn, "SELECT start_date , end_date,occurrence,week1,week2 FROM  special_activity_rule WHERE  id='".$rule_id."' ");
		$data = $query->fetch_assoc();
		return $data;
	}
	//get last inserted teacher activity
	public function activityLastReocrd(){
		$query = mysqli_query($this->conn, "SELECT id,name FROM teacher_activity ORDER BY id DESC LIMIT 1");
		$data=$query->fetch_assoc();
		return $data;
	}
	//get time details from rule id
	public function ruleTimeslotandDay($ruleId){
		$query = mysqli_query($this->conn, "SELECT id,actual_timeslot_id,duration,day FROM  special_activity_rule_day_map  WHERE  special_activity_rule_id='".$ruleId."' ");
		while($data = $query->fetch_assoc()){
				$timeslot[$data['day']] =  $data['actual_timeslot_id'].'-'.$data['duration'];
		}
		return $timeslot;
	}
	//get exception dates associated with a rule id
	public function getExceptionDate($ruleId){
		$exceptionDate=array();
		$query = mysqli_query($this->conn, "SELECT exception_date FROM special_activity_exception  WHERE  special_activity_rule_id='".$ruleId."' ");
		while($data = $query->fetch_assoc()){
				$exceptionDate[] =  $data['exception_date'];
		}
		return $exceptionDate;
	}
	//get special activity details by id
	public function specialActivityDetail($special_act_id){
		$sql = "SELECT ta.id,ta.name,ta.program_year_id,ta.cycle_id,ta.subject_id,ta.session_id,ta.teacher_id,ta.group_id,ta.room_id,ta.timeslot_id,ta.start_time,ta.reserved_flag,ta.act_date,sa.teacher_activity_id,sa.id as special_id,sa.special_activity_rule_id,sa.area_id,sa.special_activity_type,sa.duration,sa.special_activity_name,sa.adhoc_start_date,sa.adhoc_end_date, sa.adhoc_participants, sa.adhoc_coordinator, sa.special_activity_category FROM teacher_activity ta
						inner join  special_activity_mapping sa on(sa.teacher_activity_id = ta.id)
						WHERE ta.id='".$special_act_id."' ";
		$query = mysqli_query($this->conn,$sql);
		$data=$query->fetch_assoc();
		return $data;
	}
	//get start time by timeslot id
	public function getStartTime($start_time_id){
		$ts_sql = "SELECT start_time FROM timeslot WHERE id='".$start_time_id."'";
		$query = mysqli_query($this->conn,$ts_sql);
		$data=$query->fetch_assoc();
		return $data;
	}
	//add special activity in database
	public function addSpecialActivity(){
		if($_POST['txtActName']!=""){
			//check if the activity name exists
			$check_query="select special_activity_name from special_activity_mapping where special_activity_name='".trim($_POST['txtActName'])."'";
			$check_query_res = mysqli_query($this->conn, $check_query);
			$dataAll = mysqli_fetch_assoc($check_query_res);
			if(count($dataAll)>0){
					$message="Activity Name already exists.";
					$_SESSION['error_msg'] = $message;
					header('Location: special_activity.php');
					return 0;
			}else{
				$start_time=$activity_date="";
				$currentDateTime = date("Y-m-d H:i:s");
				$obj_SA = new SpecialActivity();
				$last_activity_record=$obj_SA->activityLastReocrd();
				$act_name_num= ltrim ($last_activity_record['name'],'A');
			$objTeach = new Teacher();
			if($_POST['txtActName']!="" && $_POST['special_activity']!="" && $_POST['special_activity_type']=="1"){
			  $timeslotIdsArray = array();
			 	if(isset($_POST['ot_tslot_id'])&& $_POST['ot_tslot_id']!=""){
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
				}else{
					$ot_timeslot_str="";
				}
				if(isset($_POST['ad_hoc_date_slct'])&&  $_POST['ad_hoc_date_slct']==1 && $_POST['ad_hoc_fix_date']!=""){
						$activity_date=$_POST['ad_hoc_fix_date'];
				}else{
						$activity_date=$_POST['oneTimeDate'];
				}
			   	$act_name_num = $act_name_num+1;
				$act_name='A'.$act_name_num;
				$ts_id_Arr = explode(',',$ot_timeslot_str);
				$start_time = $ts_id_Arr['0'];
				$result = mysqli_query($this->conn, "INSERT INTO teacher_activity(name, program_year_id, cycle_id, subject_id,teacher_id, group_id, room_id, timeslot_id, start_time, act_date, reserved_flag, date_add, date_update, forced_flag) VALUES ('".$act_name."', '".$_POST['slctProgram']."','".$_POST['slctCycle']."', '".$_POST['slctSubjectName']."','".$_POST['slctTeacher']."','','".$_POST['slctRoom']."','".$ot_timeslot_str."','".$start_time."','".$activity_date."', '".$_POST['special_activity']."' , '".$currentDateTime."','".$currentDateTime."','') ");
					$last_id = mysqli_insert_id($this->conn);
					if($last_id!=''){
						$result_mapping = mysqli_query($this->conn, "INSERT INTO special_activity_mapping(teacher_activity_id, special_activity_rule_id, area_id, special_activity_type, special_activity_category, duration,special_activity_name, adhoc_participants, adhoc_coordinator, adhoc_start_date,adhoc_end_date, date_add, date_update) VALUES ('".$last_id."','".$ruleId."','".$_POST['slctArea']."','".$_POST['special_activity_type']."', '".$_POST['special_activity_category']."', '".$_POST['duration']."','".$_POST['txtActName']."', '".$_POST['participantsNo']."', '".$_POST['coordinator']."', '".$_POST['fromADHocDate']."','".$_POST['toADHocDate']."','".$currentDateTime."','".$currentDateTime."') ");
					}
				if($result){
					$message="Activity has been inserted successfully";
					$_SESSION['succ_msg'] = $message;
					header('Location: special_activity_view.php');
				}else{
					$message="Not inserted ";
					$_SESSION['error_msg'] = $message;
					header('Location: special_activity_view.php');
				}	
				return 1;
		   	}else{
				$objtime = new Timetable();
				$last_day = '5';
				$rulesIds= (isset($_POST['ruleval']) && $_POST['ruleval']!="") ?  $_POST['ruleval']:"";
				$rulesIds_str = implode(',',$rulesIds);
				//inserting new mapping
				foreach($_POST['ruleval'] as $ruleId)
				{
					$ruleStartEnddate = $obj_SA->ruleStartEndDate($ruleId);
					$startPADate=$ruleStartEnddate['start_date'];
					$endPADate=$ruleStartEnddate['end_date'];
					$occurrence=$ruleStartEnddate['occurrence'];
					$start_date = $startPADate;
					$end_date = $endPADate;
								
					if($occurrence == '1w')
					{
						$week1 = unserialize($ruleStartEnddate['week1']);
						foreach($week1 as $day=>$time)
						{
							$duration = count($time)*15;
							$day = $day + 1;
							$dateArr = $objtime->getDateForSpecificDayBetweenDates($startPADate, $endPADate,$day);
							foreach($dateArr as $val)
							{
								$sql_pgm_exp = $this->conn->query("select id from special_activity_exception where special_activity_rule_id='".$ruleId."' AND exception_date = '".$val."'");
								if(mysqli_num_rows($sql_pgm_exp) == 0)
								{
									$act_name_num = $act_name_num+1;
									$act_name='A'.$act_name_num ;
									$result = mysqli_query($this->conn, "INSERT INTO teacher_activity (name, program_year_id, cycle_id, subject_id, teacher_id, group_id, room_id, timeslot_id, start_time, act_date, reserved_flag, date_add, date_update, forced_flag) VALUES ('".$act_name."', '".$_POST['slctProgram']."','".$_POST['slctCycle']."', '".$_POST['slctSubjectName']."','".$_POST['slctTeacher']."','','".$_POST['slctRoom']."','".implode(',',$time)."','".$time[0]."','".$val."', '".$_POST['special_activity']."' ,'".$currentDateTime."','".$currentDateTime."','') ");
									$last_id = mysqli_insert_id($this->conn);
									if($last_id!=''){
										$result_mapping = mysqli_query($this->conn, "INSERT INTO special_activity_mapping(teacher_activity_id, special_activity_rule_id, area_id, special_activity_type, special_activity_category, duration,special_activity_name, adhoc_participants, adhoc_coordinator, date_add, date_update) VALUES ('".$last_id."','".$ruleId."','".$_POST['slctArea']."','".$_POST['special_activity_type']."', '".$_POST['special_activity_category']."', '".$duration."','".$_POST['txtActName']."', '".$_POST['participantsNo']."', '".$_POST['coordinator']."', '".$currentDateTime."','".$currentDateTime."') ");
									}								
								}
							}
						}
					}else if($occurrence == '2w')
					{
						$weeks = $objtime->countWeeksBetweenDates($startPADate, $endPADate);
						for($j=0; $j < $weeks; $j++)
						{						
							if($j%2 == 0)
							{
								$day = date("w", strtotime($startPADate));
								$day = $day-1;
								$rem_days = $last_day-$day;
								$date = new DateTime($startPADate);
								$date->modify('+'.$rem_days.' day');
								$endPADate = $date->format('Y-m-d');
								$week1 = unserialize($ruleStartEnddate['week1']);
								foreach($week1 as $day=> $time)
								{
									$day = $day + 1;
									if($endPADate > $end_date)
									{
										$endPADate = $end_date;
									}
									$dateArr = $objtime->getDateForSpecificDayBetweenDates($startPADate,$endPADate,$day);
									foreach($dateArr as $val)
									{
										$sql_pgm_exp = $this->conn->query("select id from special_activity_exception where special_activity_rule_id='".$ruleId."' AND exception_date = '".$val."'");
										if(mysqli_num_rows($sql_pgm_exp) == 0)
										{
											$act_name_num = $act_name_num+1;
											$act_name='A'.$act_name_num ;
											$result = mysqli_query($this->conn, "INSERT INTO teacher_activity (name, program_year_id, cycle_id, subject_id, teacher_id, group_id, room_id, timeslot_id, start_time, act_date, reserved_flag, date_add, date_update, forced_flag) VALUES ('".$act_name."', '".$_POST['slctProgram']."','".$_POST['slctCycle']."', '".$_POST['slctSubjectName']."','".$_POST['slctTeacher']."','','".$_POST['slctRoom']."','".implode(',',$time)."','".$time[0]."','".$val."', '".$_POST['special_activity']."' ,'".$currentDateTime."','".$currentDateTime."','') ");
											$last_id = mysqli_insert_id($this->conn);
											if($last_id!=''){
												$result_mapping = mysqli_query($this->conn, "INSERT INTO special_activity_mapping(teacher_activity_id, special_activity_rule_id, area_id, special_activity_type, special_activity_category, duration,special_activity_name, adhoc_participants, adhoc_coordinator, date_add, date_update) VALUES ('".$last_id."','".$ruleId."','".$_POST['slctArea']."','".$_POST['special_activity_type']."', '".$_POST['special_activity_category']."', '".$duration."','".$_POST['txtActName']."', '".$_POST['participantsNo']."', '".$_POST['coordinator']."', '".$currentDateTime."','".$currentDateTime."') ");
											}
										}
									}														
								}
								$date = new DateTime($endPADate);
								$date->modify('+2 day');
								$startPADate = $date->format('Y-m-d');						
							}else{
								$day = date("w", strtotime($startPADate));
								$day = $day-1;
								$rem_days = $last_day-$day;
								$date = new DateTime($startPADate);
								$date->modify('+'.$rem_days.' day');
								$endPADate = $date->format('Y-m-d');	
								if(count(unserialize($ruleStartEnddate['week2'])) > 0)
								{
									$week2 = unserialize($ruleStartEnddate['week2']);
									foreach($week2 as $day=> $time)
									{
										$day = $day + 1;
										echo $startPADate."--".$endPADate."--".$day;
										if($endPADate > $end_date)
										{
											$endPADate = $end_date;
										}
										$dateArr = $objtime->getDateForSpecificDayBetweenDates($startPADate,$endPADate,$day);
										foreach($dateArr as $val)
										{
											$sql_pgm_exp = $this->conn->query("select id from special_activity_exception where special_activity_rule_id='".$ruleId."' AND exception_date = '".$val."'");
											if(mysqli_num_rows($sql_pgm_exp) == 0)
											{
												$act_name_num = $act_name_num+1;
												$act_name='A'.$act_name_num ;
												$result = mysqli_query($this->conn, "INSERT INTO teacher_activity (name, program_year_id, cycle_id, subject_id, teacher_id, group_id, room_id, timeslot_id, start_time, act_date, reserved_flag, date_add, date_update, forced_flag) VALUES ('".$act_name."', '".$_POST['slctProgram']."','".$_POST['slctCycle']."', '".$_POST['slctSubjectName']."','".$_POST['slctTeacher']."','','".$_POST['slctRoom']."','".implode(',',$time)."','".$time[0]."','".$val."', '".$_POST['special_activity']."' ,'".$currentDateTime."','".$currentDateTime."','') ");
												$last_id = mysqli_insert_id($this->conn);
												if($last_id!=''){
													$result_mapping = mysqli_query($this->conn, "INSERT INTO special_activity_mapping(teacher_activity_id, special_activity_rule_id, area_id, special_activity_type, special_activity_category, duration,special_activity_name, adhoc_participants, adhoc_coordinator, date_add, date_update) VALUES ('".$last_id."','".$ruleId."','".$_POST['slctArea']."','".$_POST['special_activity_type']."' ,'".$_POST['special_activity_category']."', '".$duration."','".$_POST['txtActName']."', '".$_POST['participantsNo']."', '".$_POST['coordinator']."', '".$currentDateTime."','".$currentDateTime."') ");
												}
											}
										}														
									}
								}
								$date = new DateTime($endPADate);
								$date->modify('+2 day');
								$startPADate = $date->format('Y-m-d');							
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
	}else{
		$message="Activity Name can not be empty.";
		$_SESSION['error_msg'] = $message;
		header('Location: special_activity.php');
		return 0;
	}
  }
  //edit special activity
	public function updateSpecialActivity(){
		if(isset($_POST['special_activity_type']) && ($_POST['special_activity_type']!="2" || $_POST['one_time_edit']=="1") && $_POST['duration']!=""){
			  $timeslotIdsArray = array();
			  if(isset($_POST['ot_tslot_id'])&& $_POST['ot_tslot_id']!=""){
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
				}else{
						$ot_timeslot_str="";
				}
				if(isset($_POST['ad_hoc_date_slct'])&&  $_POST['ad_hoc_date_slct']==1 && $_POST['ad_hoc_fix_date']!=""){
						$activity_date=$_POST['ad_hoc_fix_date'];
				}else{
						$activity_date=$_POST['oneTimeDate'];
				}
			    $ts_id_Arr = explode(',',$ot_timeslot_str);
				$start_time = $ts_id_Arr['0'];
				if((isset($_POST['special_act_id'])) && $_POST['special_act_id']!=""){
					
					$result_update = mysqli_query($this->conn, "Update teacher_activity set teacher_id = '".$_POST['slctTeacher']."', subject_id = '".$_POST['slctSubjectName']."', room_id = '".$_POST['slctRoom']."', timeslot_id = '".$ot_timeslot_str."',start_time = '".$start_time."', act_date = '".$activity_date."', date_update = '".date("Y-m-d H:i:s")."' where id='".$_POST['special_act_id']."' ");
					if($result_update){
						$result_mapping_update = mysqli_query($this->conn, "Update  special_activity_mapping set area_id = '".$_POST['slctArea']."', duration = '".$_POST['duration']."', special_activity_category = '".$_POST['special_activity_category']."', special_activity_name = '".$_POST['txtActName']."', adhoc_start_date = '".$_POST['fromADHocDate']."',adhoc_end_date = '".$_POST['toADHocDate']."', adhoc_participants = '".$_POST['participantsNo']."' , adhoc_coordinator = '".$_POST['coordinator']."',date_update = '".date("Y-m-d H:i:s")."' where teacher_activity_id='".$_POST['special_act_id']."' ");
					}
				}else{
					$sql = "select teacher_activity_id from special_activity_mapping where special_activity_name='".trim($_POST['special_sp_act_name'])."' ";
					$query = mysqli_query($this->conn,$sql);
					$teacher_act_id_result = $query->fetch_assoc();
					$result_update = mysqli_query($this->conn, "Update teacher_activity set teacher_id = '".$_POST['slctTeacher']."', subject_id = '".$_POST['slctSubjectName']."', room_id = '".$_POST['slctRoom']."', timeslot_id = '".$ot_timeslot_str."',start_time = '".$start_time."', act_date = '".$activity_date."', date_update = '".date("Y-m-d H:i:s")."' where id='".$teacher_act_id_result['teacher_activity_id']."' ");
					if($result_update){
						$result_mapping_update = mysqli_query($this->conn, "Update  special_activity_mapping set area_id = '".$_POST['slctArea']."', duration = '".$_POST['duration']."', special_activity_category = '".$_POST['special_activity_category']."', special_activity_name = '".$_POST['txtActName']."', adhoc_start_date = '".$_POST['fromADHocDate']."',adhoc_end_date = '".$_POST['toADHocDate']."', adhoc_participants = '".$_POST['participantsNo']."' , adhoc_coordinator = '".$_POST['coordinator']."' ,date_update = '".date("Y-m-d H:i:s")."' where teacher_activity_id='".$teacher_act_id_result['teacher_activity_id']."' ");
					}
				}
				if($result_update==1 && $result_mapping_update==1){
					$message="Activity has been updated successfully";
					$_SESSION['succ_msg'] = $message;
					header('Location: special_activity_view.php');
				}else{
				    $message="Not updated";
					$_SESSION['error_msg'] = $message;
					header('Location: special_activity_view.php');
				}	
		}else{
			$obj_SA=new SpecialActivity();
			$objtime = new Timetable();
			$last_day = '5';
			$currentDateTime = date("Y-m-d H:i:s");
			$rule_id_Arr=array();
			$sql = "select special_activity_rule_id from special_activity_mapping where special_activity_name='".trim($_POST['special_sp_act_name'])."' "; 
			$query = mysqli_query($this->conn,$sql);
			while($ruleIdData = $query->fetch_assoc()){
				$rule_id_Arr[] = $ruleIdData['special_activity_rule_id'];
			}
			$ruleIds = array_unique($rule_id_Arr);
			$ruleIdSelected = $_POST['ruleval'];
			$actual_rule_ids=array_diff($ruleIdSelected,$ruleIds);
				$rulesIds_str = implode(',',$actual_rule_ids);
				//inserting new mapping
				$last_activity_record=$obj_SA->activityLastReocrd();
				$act_name_num= ltrim ($last_activity_record['name'],'A');
				foreach($actual_rule_ids as $ruleId)
				{
					$ruleStartEnddate = $obj_SA->ruleStartEndDate($ruleId);
					$startPADate=$ruleStartEnddate['start_date'];
					$endPADate=$ruleStartEnddate['end_date'];
					$occurrence=$ruleStartEnddate['occurrence'];
					$start_date = $startPADate;
					$end_date = $endPADate;
					if($occurrence == '1w')
					{
						$week1 = unserialize($ruleStartEnddate['week1']);
						foreach($week1 as $day=>$time)
						{
							$duration = count($time)*15;
							$day = $day + 1;
							$dateArr = $objtime->getDateForSpecificDayBetweenDates($startPADate, $endPADate,$day);
							foreach($dateArr as $val)
							{
								$sql_pgm_exp = $this->conn->query("select id from special_activity_exception where special_activity_rule_id='".$ruleId."' AND exception_date = '".$val."'");
								if(mysqli_num_rows($sql_pgm_exp) == 0)
								{
									$act_name_num = $act_name_num+1;
									$act_name='A'.$act_name_num ;
									$result = mysqli_query($this->conn, "INSERT INTO teacher_activity (name, program_year_id, cycle_id, subject_id, teacher_id, group_id, room_id, timeslot_id, start_time, act_date, reserved_flag, date_add, date_update, forced_flag) VALUES ('".$act_name."', '".$_POST['slctProgram']."','".$_POST['slctCycle']."', '".$_POST['slctSubjectName']."','".$_POST['slctTeacher']."','','".$_POST['slctRoom']."','".implode(',',$time)."','".$time[0]."','".$val."', '".$_POST['special_activity']."' ,'".$currentDateTime."','".$currentDateTime."','') ");
									$last_id = mysqli_insert_id($this->conn);
									if($last_id!=''){
										$result_mapping = mysqli_query($this->conn, "INSERT INTO special_activity_mapping(teacher_activity_id, special_activity_rule_id, area_id, special_activity_type, special_activity_category, duration,special_activity_name, adhoc_participants, adhoc_coordinator, date_add, date_update) VALUES ('".$last_id."','".$ruleId."','".$_POST['slctArea']."','".$_POST['special_activity_type']."', '".$_POST['special_activity_category']."', '".$duration."','".$_POST['txtActName']."', '".$_POST['participantsNo']."', '".$_POST['coordinator']."','".$currentDateTime."','".$currentDateTime."') ");
									}								
								}
							}
						}
					}else if($occurrence == '2w')
					{
						$weeks = $objtime->countWeeksBetweenDates($startPADate, $endPADate);
						for($j=0; $j < $weeks; $j++)
						{						
							if($j%2 == 0)
							{
								$day = date("w", strtotime($startPADate));
								$day = $day-1;
								$rem_days = $last_day-$day;
								$date = new DateTime($startPADate);
								$date->modify('+'.$rem_days.' day');
								$endPADate = $date->format('Y-m-d');
								$week1 = unserialize($ruleStartEnddate['week1']);
								foreach($week1 as $day=> $time)
								{
									$day = $day + 1;
									if($endPADate > $end_date)
									{
										$endPADate = $end_date;
									}
									$dateArr = $objtime->getDateForSpecificDayBetweenDates($startPADate,$endPADate,$day);
									foreach($dateArr as $val)
									{
										$sql_pgm_exp = $this->conn->query("select id from special_activity_exception where special_activity_rule_id='".$ruleId."' AND exception_date = '".$val."'");
										if(mysqli_num_rows($sql_pgm_exp) == 0)
										{
											$act_name_num = $act_name_num+1;
											$act_name='A'.$act_name_num ;
											$result = mysqli_query($this->conn, "INSERT INTO teacher_activity (name, program_year_id, cycle_id, subject_id, teacher_id, group_id, room_id, timeslot_id, start_time, act_date, reserved_flag, date_add, date_update, forced_flag) VALUES ('".$act_name."', '".$_POST['slctProgram']."','".$_POST['slctCycle']."', '".$_POST['slctSubjectName']."','".$_POST['slctTeacher']."','','".$_POST['slctRoom']."','".implode(',',$time)."','".$time[0]."','".$val."', '".$_POST['special_activity']."' ,'".$currentDateTime."','".$currentDateTime."','') ");
											$last_id = mysqli_insert_id($this->conn);
											if($last_id!=''){
												$result_mapping = mysqli_query($this->conn, "INSERT INTO special_activity_mapping(teacher_activity_id, special_activity_rule_id, area_id, special_activity_type, special_activity_category, duration,special_activity_name, adhoc_participants, adhoc_coordinator, date_add, date_update) VALUES ('".$last_id."','".$ruleId."','".$_POST['slctArea']."','".$_POST['special_activity_type']."', '".$_POST['special_activity_category']."', '".$duration."','".$_POST['txtActName']."', '".$_POST['participantsNo']."', '".$_POST['coordinator']."','".$currentDateTime."','".$currentDateTime."') ");
											}
										}
									}														
								}
								$date = new DateTime($endPADate);
								$date->modify('+2 day');
								$startPADate = $date->format('Y-m-d');						
							}else{
								$day = date("w", strtotime($startPADate));
								$day = $day-1;
								$rem_days = $last_day-$day;
								$date = new DateTime($startPADate);
								$date->modify('+'.$rem_days.' day');
								$endPADate = $date->format('Y-m-d');	
								if(count(unserialize($ruleStartEnddate['week2'])) > 0)
								{
									$week2 = unserialize($ruleStartEnddate['week2']);
									foreach($week2 as $day=> $time)
									{
										$day = $day + 1;
										echo $startPADate."--".$endPADate."--".$day;
										if($endPADate > $end_date)
										{
											$endPADate = $end_date;
										}
										$dateArr = $objtime->getDateForSpecificDayBetweenDates($startPADate,$endPADate,$day);
										foreach($dateArr as $val)
										{
											$sql_pgm_exp = $this->conn->query("select id from special_activity_exception where special_activity_rule_id='".$ruleId."' AND exception_date = '".$val."'");
											if(mysqli_num_rows($sql_pgm_exp) == 0)
											{
												$act_name_num = $act_name_num+1;
												$act_name='A'.$act_name_num ;
												$result = mysqli_query($this->conn, "INSERT INTO teacher_activity (name, program_year_id, cycle_id, subject_id, teacher_id, group_id, room_id, timeslot_id, start_time, act_date, reserved_flag, date_add, date_update, forced_flag) VALUES ('".$act_name."', '".$_POST['slctProgram']."','".$_POST['slctCycle']."', '".$_POST['slctSubjectName']."','".$_POST['slctTeacher']."','','".$_POST['slctRoom']."','".implode(',',$time)."','".$time[0]."','".$val."', '".$_POST['special_activity']."' ,'".$currentDateTime."','".$currentDateTime."','') ");
												$last_id = mysqli_insert_id($this->conn);
												if($last_id!=''){
													$result_mapping = mysqli_query($this->conn, "INSERT INTO special_activity_mapping(teacher_activity_id, special_activity_rule_id, area_id, special_activity_type, duration,special_activity_name, adhoc_participants, adhoc_coordinator, date_add, date_update) VALUES ('".$last_id."','".$ruleId."','".$_POST['slctArea']."','".$_POST['special_activity_type']."','".$duration."','".$_POST['txtActName']."','".$_POST['participantsNo']."', '".$_POST['coordinator']."', '".$currentDateTime."','".$currentDateTime."') ");
												}
											}
										}														
									}
								}
								$date = new DateTime($endPADate);
								$date->modify('+2 day');
								$startPADate = $date->format('Y-m-d');							
							}
						}					
					}
				}
				$message="Activities have been updated successfully";
				$_SESSION['succ_msg'] = $message;
				header('Location: special_activity_view.php');
				return 1;
		}
   }	
	//fetching detail for the listing special activity
	public function getSpecialActivityDetail($special_act){
		$sql = "SELECT ta.id,ta.name,ta.program_year_id,ta.cycle_id,ta.subject_id,ta.session_id,ta.teacher_id,ta.group_id,ta.room_id,ta.timeslot_id,ta.reserved_flag,ta.act_date,s.subject_name,ss.session_name,t.teacher_name,t.email,py.name program_name,rm.room_name,sam.special_activity_name, sam.adhoc_participants, sam.adhoc_coordinator FROM teacher_activity ta
						left join subject s on(s.id = ta.subject_id)
						left join subject_session ss on(ss.id=ta.session_id)
						left join teacher t on(t.id = ta.teacher_id)
						left join program_years py on(py.id=ta.program_year_id)
						left join room rm on(rm.id=ta.room_id)
						left join special_activity_mapping sam on(ta.id = sam.teacher_activity_id)
						WHERE ta.id IN ($special_act)";
		$result =  $this->conn->query($sql);
		return $result;				
	}
	//delete special activity by rule
	public function deleteSpecialActivities(){
		$sql = "SELECT ta.id  FROM teacher_activity ta
						left join special_activity_mapping sam on(ta.id = sam.teacher_activity_id)
						WHERE ta.reserved_flag='".$_POST['activity']."' and  sam.special_activity_type='".$_POST['activityType']."' and sam.special_activity_rule_id='".$_POST['id']."' and sam.special_activity_name='".$_POST['activityName']."' ";
		$result =  $this->conn->query($sql);
		$spActIds=array();
		if($result->num_rows > 0 ){
			while($data = $result->fetch_assoc()){
				$spActIds[] =  $data['id'];
			}
			$ids_str = implode(',',$spActIds);
		    $del_sp_act_query="delete from teacher_activity where id IN ($ids_str)";
			$this->conn->query($del_sp_act_query);
			$del_sp_act_mapping="delete from special_activity_mapping where teacher_activity_id IN ($ids_str)";
			$this->conn->query($del_sp_act_mapping);
			$message="Activities have been deleted successfully";
			$_SESSION['succ_msg'] = $message;
			return 1;
		}else{
		    $message="There is no activity to delete";
			$_SESSION['succ_msg'] = $message;
			return 0;
		}
	}
	//get a particular special activity by id
	public function getSpecialActivityDetailView(){
		$sql = "SELECT ta.id, ta.program_year_id, ta.cycle_id, ta.subject_id, ta.session_id, ta.teacher_id, ta.group_id, ta.room_id, ta.timeslot_id, ta.reserved_flag, ta.act_date, s.subject_name, t.teacher_name, t.email, py.name program_name, rm.room_name, sam.special_activity_name, sam.adhoc_start_date, sam.adhoc_participants, sam.adhoc_coordinator, sam.adhoc_end_date,sam.special_activity_type,ar.area_name
				FROM teacher_activity ta
				LEFT JOIN subject s ON ( s.id = ta.subject_id )
				LEFT JOIN subject_session ss ON ( ss.id = ta.session_id )
				LEFT JOIN teacher t ON ( t.id = ta.teacher_id )
				LEFT JOIN program_years py ON ( py.id = ta.program_year_id )
				LEFT JOIN room rm ON ( rm.id = ta.room_id )
				LEFT JOIN special_activity_mapping sam ON ( ta.id = sam.teacher_activity_id )
				LEFT JOIN area ar ON ( ar.id = sam.area_id )
				WHERE ta.id = sam.teacher_activity_id GROUP BY sam.special_activity_name";
		$result =  $this->conn->query($sql);
		return $result;				
	}
	//delete special activity by name
	public function getSpecialActivityByActName($spActName){
		$sql = "SELECT ta.id,ta.name, ta.timeslot_id, ta.reserved_flag, ta.act_date,sam.special_activity_name, sam.adhoc_participants, sam.adhoc_coordinator, sam.adhoc_start_date, sam.adhoc_end_date
				FROM teacher_activity ta
				LEFT JOIN special_activity_mapping sam ON ( ta.id = sam.teacher_activity_id )
				WHERE ta.id = sam.teacher_activity_id and sam.special_activity_name='".trim($spActName)."' ";
		$result =  $this->conn->query($sql);
		return $result;				
	}
	/*public function getSpecialActivityByActName($spActName){
		$sql = "SELECT ta.id,ta.name, ta.timeslot_id, ta.reserved_flag, ta.act_date,sam.special_activity_name, sam.adhoc_start_date, sam.adhoc_end_date
				FROM teacher_activity ta
				LEFT JOIN special_activity_mapping sam ON ( ta.id = sam.teacher_activity_id )
				WHERE ta.id = sam.teacher_activity_id and sam.special_activity_name='".trim($spActName)."' ";
		$result =  $this->conn->query($sql);
		return $result;				
	}
*/	
	//get list of special activities on editing name
	public function getSpecialActivityDetailOnGrpEdit($special_gp_act_name){
		$sql = "SELECT ta.id,ta.name,ta.program_year_id,ta.cycle_id,ta.subject_id,ta.session_id,ta.teacher_id,ta.group_id,ta.room_id,ta.timeslot_id,ta.reserved_flag,ta.act_date,s.subject_name,ss.session_name,t.teacher_name,t.email,py.name program_name,rm.room_name,sam.special_activity_rule_id,sam.special_activity_name, sam.adhoc_start_date, sam.adhoc_end_date, sam.adhoc_participants, sam.adhoc_coordinator FROM teacher_activity ta
						left join subject s on(s.id = ta.subject_id)
						left join subject_session ss on(ss.id=ta.session_id)
						left join teacher t on(t.id = ta.teacher_id)
						left join program_years py on(py.id=ta.program_year_id)
						left join room rm on(rm.id=ta.room_id)
						left join special_activity_mapping sam on(ta.id = sam.teacher_activity_id)
						WHERE sam.special_activity_name='".$special_gp_act_name."' ";
		$result =  $this->conn->query($sql);
		return $result;				
	}
	//get list of special activities on editing name
	public function getSpecialActivityDetailGrpEditOne($special_gp_act_name){
		$sql = "SELECT ta.id, ta.program_year_id, ta.cycle_id, ta.subject_id, ta.session_id, ta.teacher_id, ta.group_id, ta.room_id, ta.timeslot_id, ta.reserved_flag, ta.act_date,ta.start_time, s.subject_name, t.teacher_name, t.email, py.name program_name, rm.room_name,sam.duration,sam.special_activity_type, sam.special_activity_name, sam.adhoc_start_date, sam.adhoc_end_date,sam.special_activity_type,sam.area_id,ar.area_name, sam.adhoc_participants, sam.adhoc_coordinator, sam.special_activity_category
				FROM teacher_activity ta
				LEFT JOIN subject s ON ( s.id = ta.subject_id )
				LEFT JOIN subject_session ss ON ( ss.id = ta.session_id )
				LEFT JOIN teacher t ON ( t.id = ta.teacher_id )
				LEFT JOIN program_years py ON ( py.id = ta.program_year_id )
				LEFT JOIN room rm ON ( rm.id = ta.room_id )
				LEFT JOIN special_activity_mapping sam ON ( ta.id = sam.teacher_activity_id )
				LEFT JOIN area ar ON ( ar.id = sam.area_id )
				WHERE ta.id = sam.teacher_activity_id and sam.special_activity_name='".$special_gp_act_name."' GROUP BY sam.special_activity_name";
		$result =  $this->conn->query($sql);
		$result1 = $result->fetch_assoc();
		return $result1;				
	}
	public function addCalTemplate($templatename, $txtAColor){
				$currentDateTime = date("Y-m-d H:i:s");
				$last_id = 0;
				//check if template with same name already exist.
				$sql_pgm_exp = $this->conn->query("select id from day_schedule_template where template_name='".$templatename."'");
				//echo mysqli_num_rows($sql_pgm_exp); die;
				if(mysqli_num_rows($sql_pgm_exp) == 0)
				{
					$result = mysqli_query($this->conn, "INSERT INTO day_schedule_template(template_name, color_identifier_code, date_add, date_update) VALUES ('".$templatename."', '".$txtAColor."','".$currentDateTime."','".$currentDateTime."')");
					$last_id = mysqli_insert_id($this->conn);
				}
				return $last_id;		
	}
	public function addCalAvailRule($st_tslot, $end_tslot_id, $usage_id, $addTemplateId){
				$currentDateTime = date("Y-m-d H:i:s");
				$used_timeslot_ids = 1;
				if($addTemplateId!=0){
				//check if template with same name already exist.
				$sql_pgm_exp = $this->conn->query("select id from day_template_timeslots_usages where template_id='".$addTemplateId."' AND sch_start_time = '".$st_tslot."' AND sch_end_time = '".$end_tslot_id."' AND usage_name = '".$usage_id."'");
				if(mysqli_num_rows($sql_pgm_exp) == 0)
				{
					$result_mapping = mysqli_query($this->conn, "INSERT INTO day_template_timeslots_usages(template_id, sch_start_time, sch_end_time, used_timeslot_ids	, usage_id, usage_name, date_add, date_update) VALUES ('".$addTemplateId."','".$st_tslot."','".$end_tslot_id."','".$used_timeslot_ids."', '', '".$usage_id."','".$currentDateTime."','".$currentDateTime."') ");
				}else{
					//update the record
				}
				}
	}
	public function getAllDayTemplate(){
				$sql = "SELECT dst.id, dst.template_name, dst.color_identifier_code FROM day_schedule_template dst";
				$resultTemplate = $this->conn->query($sql);
				return $resultTemplate;			
	}
	public function getAllDayTempTSUsages($templateId){
				$sql = "SELECT sch_start_time, sch_end_time, used_timeslot_ids, usage_name FROM day_template_timeslots_usages WHERE template_id='".$templateId."'";
				$resultUsage = $this->conn->query($sql);
				return $resultUsage;			
	}
	
	public function addAssociation($programId, $selectedDays, $programName){
				//get all timeslots used in a template using template id
				$idtemplate= array();
				$currentDateTime = date("Y-m-d H:i:s");
				$sql = "SELECT id FROM day_schedule_template order by id ASC"; 
				$resultTemplate = $this->conn->query($sql);
				while($templateData = $resultTemplate->fetch_assoc()){
					$idtemplate[] = $templateData['id'];
				}
				$allAssocbyId = array();
				foreach($idtemplate as $key){
					$sqlAssoc = "SELECT template_id, sch_start_time, sch_end_time, used_timeslot_ids, usage_name FROM day_template_timeslots_usages where template_id = '".$key."'";
					$resultTemplateData = $this->conn->query($sqlAssoc);
					while($assocData = $resultTemplateData->fetch_assoc()){
						$allAssocbyId[$key][] = $assocData;
					}
				}
				//end
				//get all day_template_association for the selected program in an array, match it with the new array, remove the deleted entries , update matched entries and add new entried
				$allOldUsedDates = $allNewUsedDates = array();
				$sqldate = "SELECT day FROM day_template_association where program_year_id ='".$programId."'"; 
				$resultDatesData = $this->conn->query($sqldate);
				while($allDatesData = $resultDatesData->fetch_assoc()){
					$allOldUsedDates[] = $allDatesData['day'];
				}
				//get all program availability in program_cycle_additional_day_time table if doesnt exist match it with the new array, remove the deleted entries , update matched entries and add new entried
				$objTimeslot = new Timeslot();
				for($i=0; $i<count($selectedDays); $i++){
					$daytemp = explode('--', $selectedDays[$i]);  //Cy1--2016-03-11__1
					$cycleNo = substr($daytemp[0], 2);
					$templateIds = explode('__', $daytemp[1]);
					$daydate = $templateIds[0];
					$allNewUsedDates[] = $daydate;
					$ruleAppliedId = $templateIds[1];
					//get all activities of the above rule id
					$detailRule = $allAssocbyId[$ruleAppliedId];
					$alltimeslots = $allRecessTs = $allGroupMeetTs = array();
					foreach($detailRule as $templateData){
						$alltimeslots[] = $templateData['sch_start_time'].'-'.$templateData['sch_end_time'];
						//collect timeslots for recess
						if(($templateData['usage_name']=='Recess') || ($templateData['usage_name']=='Lunch')){
							$allRecessTs[] = $templateData['sch_start_time'].'-'.$templateData['sch_end_time'];
						}
						if($templateData['usage_name']=='Group-Meeting'){
							$allGroupMeetTs[] = $templateData['sch_start_time'].'-'.$templateData['sch_end_time'];
						}
					}
					
					$alltimeslotsUnique = array_unique($alltimeslots);
					$allTimeslotsIds = implode(',',$alltimeslotsUnique);
					$actualTSIdAvailable  = $objTimeslot->getTimeslotIds($allTimeslotsIds);
					//add association if doesnt exist
					if(in_array($daydate, $allOldUsedDates)){
						//update the record
						$resultAssoc = mysqli_query($this->conn, "UPDATE day_template_association set template_id='".$ruleAppliedId."', date_update=".$currentDateTime."' WHERE day='".$daydate."' and 	program_year_id='".$programId."'");
					}else{
						//add the record
						$resultAssoc = mysqli_query($this->conn, "INSERT INTO day_template_association(program_year_id, day, template_id, date_add, date_update) VALUES ('".$programId."', '".$daydate."', '".$ruleAppliedId."', '".$currentDateTime."','".$currentDateTime."')");
					}
					
					
					//add program availability in program_cycle_additional_day_time table if doesnt exist
					$sql_chkAddDayExist = $this->conn->query("select id from program_cycle_additional_day_time where program_year_id='".$programId."' AND additional_date = '".$daydate."'");
					if(mysqli_num_rows($sql_chkAddDayExist) == 0)
					{
						//add new record
						$resultProgAvail = mysqli_query($this->conn, "INSERT INTO program_cycle_additional_day_time(program_year_id, cycle_id, additional_date, timeslot_id, actual_timeslot_id, date_add, date_update) VALUES ('".$programId."', '".$cycleNo."', '".$daydate."', '".$allTimeslotsIds."', '".$actualTSIdAvailable."', '".$currentDateTime."','".$currentDateTime."')");
					}else{ //nothing to update data already exists
						//update record
						$resultUpdatePCADT = mysqli_query($this->conn, "UPDATE program_cycle_additional_day_time set timeslot_id='".$allTimeslotsIds."', actual_timeslot_id='".$actualTSIdAvailable."', date_update=".$currentDateTime."' WHERE additional_date='".$daydate."' and program_year_id='".$programId."'");
					}
					
					//add recess activity and group meeting into teacher_activity and special_activity_mapping
					//get the name of last activity
					$resultTeachAct = $this->conn->query("SELECT name FROM teacher_activity ORDER BY id DESC LIMIT 1");
					$dRow = $resultTeachAct->fetch_assoc();
					$actCnt = substr($dRow['name'],1);
					
					if(count($allRecessTs)>0){
					//insert recess if not already exists
						for($j=0; $j<count($allRecessTs); $j++){
							$reserveFlag = 3;
							$actualTSIdAvailable  = $objTimeslot->getTimeslotIds($allRecessTs[$j]);
							 
							$startTime = explode(',', $actualTSIdAvailable);
							$actStartTime = $startTime[0];
							$duration = count($startTime)*15;
							$sql_chkTeachrActExist = $this->conn->query("select id from teacher_activity where program_year_id = '".$programId."' AND timeslot_id='".$actualTSIdAvailable."' AND start_time = '".$actStartTime."' AND act_date = '".$daydate."' AND reserved_flag = '".$reserveFlag."'");
							if(mysqli_num_rows($sql_chkTeachrActExist) == 0)
							{
								//insert data as it doesnt exists
								$actName = 'A'.($actCnt+1);
								$resultTeacherActivityRec = mysqli_query($this->conn, "INSERT INTO teacher_activity(name, program_year_id, timeslot_id, start_time, act_date, reserved_flag, date_add, date_update) VALUES ('".$actName."', '".$programId."', '".$actualTSIdAvailable."', '".$actStartTime."', '".$daydate."', '".$reserveFlag."', '".$currentDateTime."','".$currentDateTime."')");
								$lastIdActRecess = mysqli_insert_id($this->conn);
								//special_activity_mapping
								$resultSpecialActivityRec = mysqli_query($this->conn, "INSERT INTO special_activity_mapping(teacher_activity_id, special_activity_type, duration, special_activity_name, date_add, date_update) VALUES ('".$lastIdActRecess."', '".$reserveFlag."', '".$duration."', '".$programName."-Recess', '".$currentDateTime."','".$currentDateTime."')");
								$actCnt = $actCnt+1;
							}
						}
					}
					//print_r($allGroupMeetTs); die;
					if(count($allGroupMeetTs)>0){
					//insert group meeting if not already exists
						for($k=0; $k<count($allGroupMeetTs); $k++){
							$reserveFlag = 4;
							$actualTSIdAvailable  = $objTimeslot->getTimeslotIds($allGroupMeetTs[$k]);
							$startTime = explode(',', $actualTSIdAvailable);
							$actStartTime = $startTime[0];
							$durationRec = count($startTime)*15;
							$sql_chkTeachrActExist = $this->conn->query("select id from teacher_activity where program_year_id = '".$programId."' AND timeslot_id='".$actualTSIdAvailable."' AND start_time = '".$actStartTime."' AND act_date = '".$daydate."' AND reserved_flag = '".$reserveFlag."'");
							if(mysqli_num_rows($sql_chkTeachrActExist) == 0)
							{
								$actName = 'A'.($actCnt+1);
								$resultTeacherActivityGM = mysqli_query($this->conn, "INSERT INTO teacher_activity(name, program_year_id, timeslot_id, start_time, act_date, reserved_flag, date_add, date_update) VALUES ('".$actName."', '".$programId."', '".$actualTSIdAvailable."', '".$actStartTime."', '".$daydate."', '".$reserveFlag."', '".$currentDateTime."','".$currentDateTime."')");
								$lastIdActGM = mysqli_insert_id($this->conn);
								//special_activity_mapping
								$resultSpecialActivityGM = mysqli_query($this->conn, "INSERT INTO special_activity_mapping(teacher_activity_id, special_activity_type, duration, special_activity_name, date_add, date_update) VALUES ('".$lastIdActGM."', '".$reserveFlag."', '".$durationRec."', '".$programName."-Group Meeting', '".$currentDateTime."','".$currentDateTime."')");
								$actCnt = $actCnt+1;
							}
						}
					}
				}
				//delete the old records which has been deselected
					$arrDelDates = array();
					$arrDelDates = array_diff($allOldUsedDates, $allNewUsedDates);
					//echo "<pre>";
					//print_r($arrDelDates); 
					if(count($arrDelDates) >0){
						foreach($arrDelDates as $daydate){
							//delete all the activities from different tables for the deleted date on selected program
							//echo "DELETE from day_template_association where program_year_id ='".$programId."' AND day ='".$daydate."'";
							$resultAssocDel = mysqli_query($this->conn, "DELETE from day_template_association where program_year_id ='".$programId."' AND day ='".$daydate."'");
							
							//echo "DELETE from program_cycle_additional_day_time where program_year_id ='".$programId."' AND additional_date = '".$daydate."' AND timeslot_id = '".$allTimeslotsIds."'";
							$resultPCADDel = mysqli_query($this->conn, "DELETE from program_cycle_additional_day_time where program_year_id ='".$programId."' AND additional_date = '".$daydate."'");
							
							/*$resultTeaActDel = $this->conn->query("DELETE from teacher_activity where program_year_id = '".$programId."' AND timeslot_id='".$actualTSIdAvailable."' AND start_time = '".$actStartTime."' AND act_date = '".$daydate."' AND reserved_flag IN(3, 4)");*/
							/*echo "DELETE ta.*, sam.* 
												FROM teacher_activity ta 
												LEFT JOIN special_activity_mapping sam 
												ON sam.teacher_activity_id = ta.id 
												where ta.program_year_id = '".$programId."' AND ta.timeslot_id='".$actualTSIdAvailable."' AND ta.start_time = '".$actStartTime."' AND ta.act_date = '".$daydate."' AND ta.reserved_flag IN(3, 4)"; */
							$resultTeaActDel = mysqli_query($this->conn, "DELETE ta.*, sam.* 
												FROM teacher_activity ta 
												LEFT JOIN special_activity_mapping sam 
												ON sam.teacher_activity_id = ta.id 
												where ta.program_year_id = '".$programId."' AND ta.act_date = '".$daydate."' AND ta.reserved_flag IN(3, 4)");
						 
							/*$resultTeaActDel = $this->conn->query("DELETE from special_activity_mapping where program_year_id = '".$programId."' AND timeslot_id='".$actualTSIdAvailable."' AND start_time = '".$actStartTime."' AND act_date = '".$daydate."' AND reserved_flag IN(3, 4)");*/
						}
					}
					 //die;
				return 1;
	}
	
}
