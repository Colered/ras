<?php
class Timetable extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
 	public function viewTimetable(){
		$tt_query="select * from timetable_detail"; 
		$q_res = mysqli_query($this->conn, $tt_query);
		return $q_res;
   	}
	public function getTimetableYear($id){
		$tt_query="select * from timetable where id ='".$id."'"; 
		$q_res = mysqli_query($this->conn, $tt_query);
		return $q_res;
   	}
   public function getSubject($id){
		$subject_query="select * from  subject where id ='".$id."'"; 
		$q_res = mysqli_query($this->conn, $subject_query);
		return $q_res;
   	}
	public function getArea($id){
		$area_query="select * from  area where id ='".$id."'";
		$q_res = mysqli_query($this->conn, $area_query);
		return $q_res;
   	}
	public function getSession($id){
		$session_query="select * from  subject_session where id ='".$id."'";
		$q_res = mysqli_query($this->conn, $session_query);
		return $q_res;
   	}
	public function getTeacher($id){
		$teacher_query="select * from  teacher where id ='".$id."'";
		$q_res = mysqli_query($this->conn, $teacher_query);
		return $q_res;
   	}
	public function getClassroom($id){
		$room_query="select * from  room where id ='".$id."'";
		$q_res = mysqli_query($this->conn, $room_query);
		return $q_res;
   	}
	public function getProgramYear($id){
		$program_year_query="select * from  program_years where id ='".$id."'";
		$q_res = mysqli_query($this->conn, $program_year_query);
		return $q_res;
   	}
	public function gerProgram($id){
		$program_year_query="select * from  program where id ='".$id."'";
		$q_res = mysqli_query($this->conn, $program_year_query);
		return $q_res;
   	}
	public function getCycle($id){
		$cycle_query="select * from  cycle where program_year_id ='".$id."'";
		$q_res = mysqli_query($this->conn, $cycle_query);
		return $q_res;
   	}
	public function generateTimetable($date, $end_date, $from_time)
	{	
		$number = 0;
		$allocated_activities = '';
		$result_array = array();
		$start_date = $date;
		$programs = $this->search_programs($start_date,$from_time,$end_date);
		//print"<pre>";print_r($programs);die;
		
			$reserved_array = array();
			$i=0;
			foreach($programs as $key=>$value)
			{				
				$program_id = $key;
				$reserved_timeslots = array();				
				
				foreach($value as $k=>$v)
				{
					$date = $k;
					if(!$this->checkHoliday($date))
					{
						$end_time = '';
						$reserved_rooms = array();
						$reserved_teachers = array();
						foreach($v as $start_id)
						{
							$timeslots = array();
							$timeslots[0] = $start_id;
							$start_time = $this->getTimeSlots($timeslots);
							$start_time = $start_time['0'];
							$start_time =  date('h:i A',strtotime($start_time));
							if($start_time >= $end_time)
							{
								$end_time = date("h:i A", strtotime($start_time." + 15 minutes"));
								$sql_reserv_act = $this->conn->query("select ta.id as activity_id,ta.name,ta.program_year_id,py.name as program_name, ta.subject_id,su.subject_name,ta.session_id,s.session_name as session_name,ta.teacher_id,t.teacher_name,ta.group_id,ta.room_id,r.room_name,s.order_number,ta.start_time, s.duration, ta.timeslot_id from teacher_activity ta 
								inner join subject_session s on s.id = ta.session_id
								inner join program_years py on py.id = ta.program_year_id
								inner join subject su on su.id = ta.subject_id
								inner join teacher t on t.id = ta.teacher_id
								inner join room r on r.id = ta.room_id
								where start_time = '".$start_id."' and reserved_flag = 1 and DATE_FORMAT(act_date,'%Y-%m-%d') = '".$date."' and ta.program_year_id = '".$program_id."'");
								while($result_reserv_act = mysqli_fetch_array($sql_reserv_act))
								{							
									$end_time = date("h:i A", strtotime($start_time." + ".$result_reserv_act['duration']." minutes"));
									//$min_order_id = $this->getMinimumOrderBySubject($result_reserv_act['subject_id']);
									if(!$this->search_array($result_reserv_act['name'],$reserved_array)) 
									{									
										$order_no_array = $this->getSubjectsWithLessOrder($result_reserv_act['subject_id'],$result_reserv_act['order_number']);
										$order_no_value = 0;
										foreach($order_no_array as $order_no)
										{
											if($this->search_array($result_reserv_act['subject_id']."-".$order_no,$reserved_array))
											{
												$order_no_value++;
											}else{
												break;
											}
										}
										if($order_no_value == count($order_no_array))
										{
											$reserved_array[$date][$i][$start_time." - ".$end_time]['activity_id'] =  $result_reserv_act['activity_id'];
											$reserved_array[$date][$i][$start_time." - ".$end_time]['name'] =  $result_reserv_act['name'];
											$reserved_array[$date][$i][$start_time." - ".$end_time]['program_year_id'] = $result_reserv_act['program_year_id'];
											$reserved_array[$date][$i][$start_time." - ".$end_time]['program_name'] = $result_reserv_act['program_name'];							
											$reserved_array[$date][$i][$start_time." - ".$end_time]['teacher_id'] = $result_reserv_act['teacher_id'];
											$reserved_array[$date][$i][$start_time." - ".$end_time]['teacher_name'] = $result_reserv_act['teacher_name'];
											$reserved_array[$date][$i][$start_time." - ".$end_time]['group_id'] = $result_reserv_act['group_id'];
											$reserved_array[$date][$i][$start_time." - ".$end_time]['room_id'] = $result_reserv_act['room_id'];
											$reserved_array[$date][$i][$start_time." - ".$end_time]['room_name'] = $result_reserv_act['room_name'];
											$reserved_array[$date][$i][$start_time." - ".$end_time]['session_id'] = $result_reserv_act['session_id'];
											$reserved_array[$date][$i][$start_time." - ".$end_time]['session_name'] = $result_reserv_act['session_name'];
											$reserved_array[$date][$i][$start_time." - ".$end_time]['subject_id'] = $result_reserv_act['subject_id'];
											$reserved_array[$date][$i][$start_time." - ".$end_time]['subject_name'] = $result_reserv_act['subject_name'];
											$reserved_array[$date][$i][$start_time." - ".$end_time]['order_no'] = $result_reserv_act['order_number'];
											$reserved_array[$date][$i][$start_time." - ".$end_time]['subject_order'] = $result_reserv_act['subject_id']."-".$result_reserv_act['order_number'];
											$reserved_array[$date][$i][$start_time." - ".$end_time]['date'] = $date;
											$reserved_rooms[$date][$start_time." - ".$end_time] = $result_reserv_act['room_id'];
											$reserved_teachers[$date][$start_time." - ".$end_time] = $result_reserv_act['teacher_id'];
											$ts_array = explode(",",$result_reserv_act['timeslot_id']);
											foreach($ts_array as $ts_id)
											{
												$reserved_timeslots[] = trim($ts_id);
											}
											$number++;
											break;
										}
										
									}							
								}
							}
						}
						$total_timeslots = array();
						foreach($v as $start_id)
						{
							$total_timeslots[] = $start_id;
						}
						$unreserved_timeslots = array_diff($total_timeslots,$reserved_timeslots);						
						$unreserved_times = $this->getTimeSlots($unreserved_timeslots);
						foreach($unreserved_times as $un_tsid)
						{							
							$sql_free_act = $this->conn->query("select ta.id as activity_id,ta.name,ta.program_year_id,py.name as program_name, ta.subject_id, su.subject_name, ta.session_id,s.session_name as session_name,ta.teacher_id,t.teacher_name,ta.group_id,s.order_number,s.duration 
							from teacher_activity ta 
							inner join subject_session s on s.id = ta.session_id 
							inner join program_years py on py.id = ta.program_year_id 
							inner join subject su on su.id = ta.subject_id 
							inner join teacher t on t.id = ta.teacher_id 
							where reserved_flag = 0 and ta.program_year_id = '".$program_id."' order by ta.id");
							while($result_free_act = mysqli_fetch_array($sql_free_act))
							{
								$start_time = $un_tsid;
								$end_time = date("h:i A", strtotime($start_time." + ".$result_free_act['duration']." minutes"));
								
								$objT = new Teacher();
								$all_ts = $objT -> getTimeslotId($start_time."-".$end_time);
								$time = explode(",",$all_ts);						
								$ts_cnt = count(array_intersect($unreserved_timeslots, $time));								
								if($ts_cnt == count($time))
								{
									if($this->checkTeacherAvailability($result_free_act['teacher_id'],$date,$all_ts))
									{
										$j = 0;
										$rooms = $this->search_room($date,$all_ts);
										//$min_order_id = $this->getMinimumOrderBySubject($result_free_act['subject_id']);
										if(!$this->search_array($result_free_act['name'],$reserved_array) && !$this->search_array($result_free_act['subject_id']."-".$result_free_act['order_number'],$reserved_array) && !empty($rooms))
										{
											$order_no_array = $this->getSubjectsWithLessOrder($result_free_act['subject_id'],$result_free_act['order_number']);
											$order_no_value = 0;
											foreach($order_no_array as $order_no)
											{
												if($this->search_array($result_free_act['subject_id']."-".$order_no,$reserved_array))
												{
													$order_no_value++;
												}else{
													break;
												}
											}
											if($order_no_value == count($order_no_array))
											{
												$reserved_array[$date][$i][$start_time." - ".$end_time]['activity_id'] =  $result_free_act['activity_id'];
												$reserved_array[$date][$i][$start_time." - ".$end_time]['name'] =  $result_free_act['name'];
												$reserved_array[$date][$i][$start_time." - ".$end_time]['program_year_id'] = $result_free_act['program_year_id'];
												$reserved_array[$date][$i][$start_time." - ".$end_time]['program_name'] = $result_free_act['program_name'];
												$reserved_array[$date][$i][$start_time." - ".$end_time]['teacher_id'] = $result_free_act['teacher_id'];
												$reserved_array[$date][$i][$start_time." - ".$end_time]['teacher_name'] = $result_free_act['teacher_name'];
												$reserved_array[$date][$i][$start_time." - ".$end_time]['group_id'] = $result_free_act['group_id'];
												$reserved_array[$date][$i][$start_time." - ".$end_time]['session_id'] = $result_free_act['session_id'];
												$reserved_array[$date][$i][$start_time." - ".$end_time]['session_name'] = $result_free_act['session_name'];
												$reserved_array[$date][$i][$start_time." - ".$end_time]['subject_id'] = $result_free_act['subject_id'];
												$reserved_array[$date][$i][$start_time." - ".$end_time]['subject_name'] = $result_free_act['subject_name'];
												$reserved_array[$date][$i][$start_time." - ".$end_time]['order_no'] = $result_free_act['order_number'];	
												$reserved_array[$date][$i][$start_time." - ".$end_time]['subject_order'] =  $result_free_act['subject_id']."-".$result_free_act['order_number'];
												$reserved_array[$date][$i][$start_time." - ".$end_time]['date'] = $date;
												$reserved_array[$date][$i][$start_time." - ".$end_time]['room_id'] = $rooms[$j]['id'];
												$reserved_array[$date][$i][$start_time." - ".$end_time]['room_name'] = $rooms[$j]['room_name'];
												$unreserved_timeslots = array_diff($unreserved_timeslots,$time);
												$unreserved_times = $this->getTimeSlots($unreserved_timeslots);	
												$number++;
												break;
												
											}
											$j++;
										}
									}
									
								}								
							}
							//print"<pre>";print_r($unreserved_times);die;

						}



						
					}
				}
				$i++;
			}
			//print"<pre>";print_r($reserved_array);die;
		
		if(empty($reserved_array))
		{
			$err['system_error'] = 'System could not generate the timetable. Please check your data first';
			return $err;
		}	
		//print"<pre>";print_r($output_array);die;
		return $reserved_array;		
	}
	public function addTimetable($name, $start_date, $end_date)
	{
		$sql_insert = "insert into timetable set
						   timetable_name = '".$name."',
						   start_date = '".$start_date."',
						   end_date = '".$end_date."',
						   date_add = '".date("Y-m-d H:i:s")."',
						   date_update = '".date("Y-m-d H:i:s")."'";
		if($this->conn->query($sql_insert))
		{
			 $last_ins_id = $this->conn->insert_id;
			 return $last_ins_id;
		}else{
			return 0;
		}
	}
	public function addTimetableDetail($timeslot, $tt_id, $activity_id, $program_year_id, $teacher_id, $group_id, $room_id, $session_id, $subject_id, $date, $date_add, $date_upd)
	{
		$sql_insert = "insert into timetable_detail set
									   tt_id = '".$tt_id."',
									   activity_id = '".$activity_id."',
									   program_year_id = '".$program_year_id."',
									   teacher_id = '".$teacher_id."',
									   group_id = '".$group_id."',
									   room_id = '".$room_id."',
									   subject_id = '".$subject_id."',
									   session_id = '".$session_id."',
									   date = '".date('Ymd', strtotime($date))."',
									   timeslot = '".$timeslot."',
									   date_add = '".$date_add."',
									   date_upd = '".$date_upd."'";
		if($this->conn->query($sql_insert))
		{
			 return 1;
		}else{
			return 0;
		}
	}
	public function addWebCalEntry($date, $cal_time, $name, $room_name, $description, $duration, $teacher_id, $subject_id, $room_id, $program_year_id)
	{
		$sql_insert_cal = "insert into webcal_entry set
									   cal_date = '".date('Ymd', strtotime($date))."',
									   cal_time = '".$cal_time."',
									   cal_mod_date = '".date('Ymd', strtotime($date))."',
									   cal_mod_time = '".gmdate ( 'Gis' )."',
									   cal_duration = '".$duration."',
									   cal_due_date = '".date('Ymd', strtotime($date))."',
									   cal_due_time = '".$cal_time."',
									   cal_priority = '5',
									   cal_type = 'E',
									   cal_access = 'P',
									   cal_name = '".$name."',
									   cal_location = '".$room_name."',
									   cal_description = '".$description."',
									   teacher_id = '".$teacher_id."',
									   subject_id = '".$subject_id."',
									   room_id = '".$room_id."',
									   program_year_id = '".$program_year_id."'";				   
		if($this->conn->query($sql_insert_cal))
		{
			 $last_ins_id = $this->conn->insert_id;
			 return $last_ins_id;
		}else{
			return 0;
		}
	}
	public function addWebCalEntryUser($cal_id)
	{
		$sql_insert_cal_user = "insert into webcal_entry_user set
									   cal_id = '".$cal_id."',
									   cal_login = 'admin',
									   cal_status = 'A'";				   
		if($this->conn->query($sql_insert_cal_user))
		{
			 return 1;
		}else{
			return 0;
		}
	}

	public function search_array($needle, $haystack)
	{
		 if(in_array($needle, $haystack)) {
			  return true;
		 }
		 foreach($haystack as $element) {
			  if(is_array($element) && $this->search_array($needle, $element))
				   return true;
		 }
	   return false;
	}
	public function checkTeacherAvailability($teacher_id,$date,$tsIdsAll)
	{
		//check if the selected date is not added as exception by the teacher while providing availability
		$query = $this->conn->query("select id from teacher_availability_exception where teacher_id = '".$teacher_id."' and exception_date = '".$date."'");		
		if(mysqli_num_rows($query) == 0)
		{
			//find the day using date
			$day = date('w', strtotime($date));
			$final_day = $day - 1;
			//check if teacher is available on the given time and day
			$teachAvail_query=$this->conn->query("select tm.id 
								from teacher_availability_rule_teacher_map tm 
								inner join teacher_availability_rule_day_map td 
								on td.teacher_availability_rule_id = tm.teacher_availability_rule_id
								inner join teacher_availability_rule ta 
								on ta.id = td.teacher_availability_rule_id
								where start_date <= '".$date."' and end_date >= '".$date."' and day= '".$final_day."' and tm.teacher_id='".$teacher_id."' and td.actual_timeslot_id like '%".$tsIdsAll."%'");
			if(mysqli_num_rows($teachAvail_query) > 0)
			{
				return 1;
			}			
		}
	}
	public function search_room($date,$slot)
	{
		$rooms = array();
		$day = date('w', strtotime($date));
		$final_day = $day - 1;
		$sql_room = $this->conn->query("select distinct room_id, room.room_name
								from classroom_availability_rule_room_map cm
								inner join classroom_availability_rule_day_map cd on cd.classroom_availability_rule_id = cm.classroom_availability_rule_id
								inner join classroom_availability_rule ca on ca.id = cd.classroom_availability_rule_id
								inner join room on room.id = cm.room_id
								where start_date <= '".$date."' and end_date >= '".$date."' and day= '".$final_day."' and actual_timeslot_id like '%".$slot."%'");
								
							
		$k = 0;
		while($result_room = mysqli_fetch_array($sql_room))
		{
			$sql = $this->conn->query("select id from classroom_availability_exception where room_id = '".$result_room['room_id']."' and exception_date = '".$date."'");
			$room_cnt = mysqli_num_rows($sql);
			if($room_cnt == 0)
			{
				$rooms[$k]['id'] = $result_room['room_id'];
				$rooms[$k]['room_name'] = $result_room['room_name'];
				$k++;
				
			}				
		}
		//print"<pre>";print_r($rooms);die;
		return $rooms;
	}
	
	public function search_programs($start_date,$from_time,$end_date)
	{
		$final_pgms = array();
		$last_day = 5;
		$sql_pgm = $this->conn->query("SELECT distinct py.id as program_id
														FROM program_years py
														INNER JOIN program p on p.id = py.program_id
														WHERE DATE_FORMAT(start_date,'%Y-%m-%d') >= '".$start_date."' and start_year = '".$from_time."' and DATE_FORMAT(start_date,'%Y-%m-%d') <= '".$end_date."'");	
		$pgm_cnt = mysqli_num_rows($sql_pgm);
		if($pgm_cnt > 0)
		{
			while($result_pgm = mysqli_fetch_array($sql_pgm))
			{
				$sql_pgm_cycle = $this->conn->query("select * from cycle where program_year_id = '".$result_pgm['program_id']."' and start_week >= '".$start_date."' and start_week <= '".$end_date."'");
				$pgm_cycle_cnt = mysqli_num_rows($sql_pgm_cycle);
				if($pgm_cycle_cnt > 0)
				{
					while($result_pgm_cycle = mysqli_fetch_array($sql_pgm_cycle))
					{
						if($result_pgm_cycle['end_week'] > $end_date)
						{
							$end_week = $end_date;
						}else{
							$end_week = $result_pgm_cycle['end_week'];
							}
						if($result_pgm_cycle['occurrence'] == '1w')
						{	
							$week1 = unserialize($result_pgm_cycle['week1']);
							foreach($week1 as $key=> $value)
							{
								$day = $key + 1;
								$dateArr = $this->getDateForSpecificDayBetweenDates($result_pgm_cycle['start_week'],$end_week,$day);	
								foreach($dateArr as $val)
								{
									$sql_pgm_exp = $this->conn->query("select id from program_cycle_exception where exception_date = '".$val."' and program_year_id = '".$result_pgm['program_id']."'");
									if(mysqli_num_rows($sql_pgm_exp) == 0)
									{
										$final_pgms[$result_pgm['program_id']][$val] = $value;
									}
								}								
							}							
						}else if($result_pgm_cycle['occurrence'] == '2w'){
							echo $weeks = $this->countWeeksBetweenDates($result_pgm_cycle['start_week'],$end_week);
							$start_week = $result_pgm_cycle['start_week'];
							for($i=0; $i < $weeks; $i++)
							{
								if($i%2 == 0)
								{
									$day = date("w", strtotime($start_week));
									$day = $day-1;
									$rem_days = $last_day-$day;
									$date = new DateTime($start_week);
									$date->modify('+'.$rem_days.' day');
									$end_week = $date->format('Y-m-d');
									if($end_week > $end_date){
										$end_week = $end_date;
									}
									$week1 = unserialize($result_pgm_cycle['week1']);
									foreach($week1 as $key=> $value)
									{
										$day = $key + 1;										
										$dateArr = $this->getDateForSpecificDayBetweenDates($start_week,$end_week,$day);
										foreach($dateArr as $val)
										{
											$sql_pgm_exp = $this->conn->query("select id from program_cycle_exception where exception_date = '".$val."' and program_year_id = '".$result_pgm['program_id']."'");
											if(mysqli_num_rows($sql_pgm_exp) == 0)
											{
												$final_pgms[$result_pgm['program_id']][$val] = $value;
											}
										}														
									}
									$date = new DateTime($end_week);
									$date->modify('+2 day');
									$start_week = $date->format('Y-m-d');
								}else{
									if(count(unserialize($result_pgm_cycle['week2'])) > 0)
									{
										$day = date("w", strtotime($start_week));
										$day = $day-1;
										$rem_days = $last_day-$day;
										$date = new DateTime($start_week);
										$date->modify('+'.$rem_days.' day');
										$end_week = $date->format('Y-m-d');	
										$week2 = unserialize($result_pgm_cycle['week2']);
										foreach($week2 as $key=> $value)
										{
											$day = $key + 1;
											$dateArr = $this->getDateForSpecificDayBetweenDates($start_week,$end_week,$day);
											foreach($dateArr as $val)
											{
												$sql_pgm_exp = $this->conn->query("select id from program_cycle_exception where exception_date = '".$val."' and program_year_id = '".$result_pgm['program_id']."'");
												if(mysqli_num_rows($sql_pgm_exp) == 0)
												{
													$final_pgms[$result_pgm['program_id']][$val] = $value;
												}
											}														
										}
									}
									$date = new DateTime($end_week);
									$date->modify('+2 day');
									$start_week = $date->format('Y-m-d');
								}
							}							
						}
					}					
				}
			}
		}
	
	return $final_pgms;
	}
	public function countWeeksBetweenDates($start_week, $end_week)
	{
		$start_date = strtotime($start_week);
		$end_date = strtotime($end_week);

		$start_week = date('W', $start_date);
		$end_week = date('W', $end_date); 

		$start_year = date('Y', $start_date);
		$end_year = date('Y', $end_date);
		$years = $end_year-$start_year;

		if($years == 0){
			$weeks_past = $end_week-$start_week+1;
		}
		if($years == 1){
			$weeks_past = (52-$start_week+1)+$end_week;
		}
		if($years > 1){
			$weeks_past = (52-$start_week+1)+$end_week+($years*52);
		}

		return $weeks_past;
	}
	
	public function getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber)
	{
		$startDate = strtotime($startDate);
		$endDate = strtotime($endDate);

		$dateArr = array();

		do
		{
			if(date("w", $startDate) != $weekdayNumber)
			{
				$startDate += (24 * 3600); // add 1 day
			}
		} while(date("w", $startDate) != $weekdayNumber);


		while($startDate <= $endDate)
		{
			$dateArr[] = date('Y-m-d', $startDate);
			$startDate += (7 * 24 * 3600); // add 7 days
		}

		return($dateArr);
	}	
	public function deleteData()
	{
		$sql_delete_tt = $this->conn->query("DELETE FROM timetable");
		$sql_delete = $this->conn->query("DELETE FROM timetable_detail");
		$sql_delete_cal = $this->conn->query("DELETE FROM webcal_entry");
		$sql_delete_cal_user = $this->conn->query("DELETE FROM webcal_entry_user");
	}
	public function checkName($name)
	{
		$sql_select = $this->conn->query("select id from timetable where timetable_name = '".$name."'");
		$row_cnt = mysqli_num_rows($sql_select);
		if($row_cnt > 0)
		{
			return 1;
		}else{
			return 0;
		}
	}
	public function checkHoliday($date)
	{
		$sql_select = $this->conn->query("select id from holidays where holiday_date = '".$date."'");
		$row_cnt = mysqli_num_rows($sql_select);
		if($row_cnt > 0)
		{
			return 1;
		}else{
			return 0;
		}

	}
	public function getRoomName($room_id)
	{
		$sql_room_name = $this->conn->query("select room_name from room where id = '".$room_id."'");
		$rooms = mysqli_fetch_array($sql_room_name);
		return $rooms['room_name'];
	}
	public function getRoomBySubject($subject_id)
	{
		$sql_select = $this->conn->query("select room_id from teacher_activity where subject_id = '".$subject_id."' and reserved_flag = 1");
		$row_cnt = mysqli_num_rows($sql_select);
		if($row_cnt > 0)
		{
			$rooms = mysqli_fetch_array($sql_select);
			return $rooms['room_id'];			
		}else{
			return 0;
		}

	}
	public function getSubjectsWithLessOrder($subject_id, $order_no)
	{
		//$order_no = array();
		$sql_select = $this->conn->query("select order_number FROM `subject_session` WHERE subject_id = '".$subject_id."' and order_number < '".$order_no."'");
		$row_cnt = mysqli_num_rows($sql_select);
		$order_no_arr = array();
		if($row_cnt > 0)
		{	
			while($row = mysqli_fetch_array($sql_select))
			{
				$order_no_arr[] =  $row['order_number'];
				
			}//print"<pre>";print_r($order_no_arr);die;
						
		}
		return $order_no_arr;
	}
	public function getTimeSlots($ts_array)
	{
		$tt_array = array();
		foreach($ts_array as $ts_id)
		{
			$sql_slot = $this->conn->query("select timeslot_range from timeslot where id='".$ts_id."'");
			$result_slot = mysqli_fetch_array($sql_slot);
			$tslot = explode("-",$result_slot['timeslot_range']);
			$tt_array[] =  $tslot['0'];
		}
		return $tt_array;
	}
		
}
