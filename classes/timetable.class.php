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
	public function generateTimetable($start_date, $end_date, $start_week, $end_week, $from_time)
	{
		$days = array('0','1','2','3','4','5');
		$start_final_day = '';
		$end_final_day = '';
		$flag = '0';
		$number = 0;
		$allocated_activities = '';
		$result_array = array();
		for($cnt = 1;$cnt<=3;$cnt++)
		{
			$reserved_array = array();
			For($w = $start_week; $w<=$end_week;$w++)
			{
				foreach($days as $shuffled_days)
				{
					if($w == $start_week)
					{
						$timestamp = strtotime($start_date);
						$day = date('w', $timestamp);
						$start_final_day = $day-1;
					}
					if($w == $end_week)
					{
						$timestamp = strtotime($end_date);
						$day = date('w', $timestamp);
						$end_final_day = $day-1;
					}

					if(($w == $start_week && $shuffled_days >= $start_final_day) || ($shuffled_days <= $end_final_day && $w == $end_week) || ($w != $start_week && $w != $end_week))
					{
						$date = new DateTime();
						$date->setISODate($from_time, $w);
						$date->modify('+'.$shuffled_days.' days');
						$class_date = $date->format('Y-m-d');
						//$class_date =  extractdate($from_time,$w,$shuffled_days);
						$sql_slot = $this->conn->query("select id,timeslot_range from timeslot");
						while($result_slot = mysqli_fetch_array($sql_slot))
						{
							$sql_pgm = $this->conn->query("SELECT distinct py.id as program_id
													FROM cycle c
													INNER JOIN program_years py ON py.id = c.program_year_id
													WHERE start_year = '".$from_time."'
													AND c.days LIKE '%".$shuffled_days."%'
													AND c.start_week >= '".$start_week."'
													AND c.end_week <= '".$end_week."'");
													
							while($result_pgm = mysqli_fetch_array($sql_pgm))
							{
								$sql_reserv_act = $this->conn->query("select ta.id as activity_id,ta.name,ta.program_year_id,py.name as program_name, ta.subject_id,su.subject_name,ta.session_id,s.session_name as session_name,ta.teacher_id,t.teacher_name,ta.group_id,ta.room_id,r.room_name,s.order_number
								from teacher_activity ta 
								inner join subject_session s on s.id = ta.session_id
								inner join program_years py on py.id = ta.program_year_id
								inner join subject su on su.id = ta.subject_id
								inner join teacher t on t.id = ta.teacher_id
								inner join room r on r.id = ta.room_id
								where timeslot_id = '".$result_slot['id']."' and reserved_flag = 1 order by rand()");
								$res = 0;
								while($result_reserv_act = mysqli_fetch_array($sql_reserv_act))
								{
									
									if($result_reserv_act['order_number'] > 0){
										$subject_order = $result_reserv_act['subject_id']."-".($result_reserv_act['order_number']-1);
									}else{
										$subject_order = $result_reserv_act['subject_id']."-".$result_reserv_act['order_number'];
									}
									if(!$this->search_array($result_reserv_act['name'],$reserved_array)) 
									{
										
										if($result_reserv_act['order_number'] == 0)
										{
											
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['activity_id'] =  $result_reserv_act['activity_id'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['name'] =  $result_reserv_act['name'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['program_year_id'] = $result_reserv_act['program_year_id'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['program_name'] = $result_reserv_act['program_name'];							
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['teacher_id'] = $result_reserv_act['teacher_id'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['teacher_name'] = $result_reserv_act['teacher_name'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['group_id'] = $result_reserv_act['group_id'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['room_id'] = $result_reserv_act['room_id'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['room_name'] = $result_reserv_act['room_name'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['session_id'] = $result_reserv_act['session_id'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['session_name'] = $result_reserv_act['session_name'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_id'] = $result_reserv_act['subject_id'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_name'] = $result_reserv_act['subject_name'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['order_no'] = $result_reserv_act['order_number'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_order'] = $result_reserv_act['subject_id']."-".$result_reserv_act['order_number'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['date'] = $class_date;
											$number++;
											$res++;
											break;
										}elseif($this->search_array($subject_order,$reserved_array))
										{
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['activity_id'] =  $result_reserv_act['activity_id'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['name'] =  $result_reserv_act['name'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['program_year_id'] = $result_reserv_act['program_year_id'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['program_name'] = $result_reserv_act['program_name'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['teacher_id'] = $result_reserv_act['teacher_id'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['teacher_name'] = $result_reserv_act['teacher_name'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['group_id'] = $result_reserv_act['group_id'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['room_id'] = $result_reserv_act['room_id'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['room_name'] = $result_reserv_act['room_name'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['session_id'] = $result_reserv_act['session_id'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['session_name'] = $result_reserv_act['session_name'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_id'] = $result_reserv_act['subject_id'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_name'] = $result_reserv_act['subject_name'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['order_no'] = $result_reserv_act['order_number'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_order'] = $result_reserv_act['subject_id']."-".$result_reserv_act['order_number'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['date'] = $class_date;
											$number++;
											$res++;
											break;
										}
									}
								}
								//echo $res;die;
								if($res == 0)
								{
									$teachers = $this->search_teachers($w,$result_slot['id'],$shuffled_days);
									//print"<pre>";print_r($teachers);die;
									foreach($teachers as $teacher)
									{						
										/*echo "select ta.id as activity_id,ta.name,ta.program_year_id,py.name as program_name, ta.subject_id, su.subject_name, ta.session_id,s.session_name as session_name,ta.teacher_id,t.teacher_name,ta.group_id,s.order_number 
										from teacher_activity ta 
										inner join subject_session s on s.id = ta.session_id 
										inner join program_years py on py.id = ta.program_year_id 
										inner join subject su on su.id = ta.subject_id 
										inner join teacher t on t.id = ta.teacher_id 
										where teacher_id = ".$teacher." and reserved_flag = 0 order by ta.id";
										die;*/
										$sql_free_act = $this->conn->query("select ta.id as activity_id,ta.name,ta.program_year_id,py.name as program_name, ta.subject_id, su.subject_name, ta.session_id,s.session_name as session_name,ta.teacher_id,t.teacher_name,ta.group_id,s.order_number 
										from teacher_activity ta 
										inner join subject_session s on s.id = ta.session_id 
										inner join program_years py on py.id = ta.program_year_id 
										inner join subject su on su.id = ta.subject_id 
										inner join teacher t on t.id = ta.teacher_id 
										where teacher_id = ".$teacher." and reserved_flag = 0 order by rand()");
										$flag = 0;
										while($result_free_act = mysqli_fetch_array($sql_free_act))
										{
											$i = 0;
											$rooms = $this->search_room($w,$result_slot['id'],$shuffled_days);
											//print"<pre>";print_r($rooms);die;
											if($result_free_act['order_number'] > 0){
												$subject_order = $result_free_act['subject_id']."-".($result_free_act['order_number']-1);
											}else{
												$subject_order = $result_free_act['subject_id']."-".$result_free_act['order_number'];
											}
											if(!$this->search_array($result_free_act['name'],$reserved_array) && !$this->search_array($result_free_act['subject_id']."-".$result_free_act['order_number'],$reserved_array))
											{
												if($result_free_act['order_number'] == 0)
												{
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['activity_id'] =  $result_free_act['activity_id'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['name'] =  $result_free_act['name'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['program_year_id'] = $result_free_act['program_year_id'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['program_name'] = $result_free_act['program_name'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['teacher_id'] = $result_free_act['teacher_id'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['teacher_name'] = $result_free_act['teacher_name'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['group_id'] = $result_free_act['group_id'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['room_id'] = $rooms[$i]['id'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['room_name'] = $rooms[$i]['room_name'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['session_id'] = $result_free_act['session_id'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['session_name'] = $result_free_act['session_name'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_id'] = $result_free_act['subject_id'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_name'] = $result_free_act['subject_name'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['order_no'] = $result_free_act['order_number'];	
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_order'] =  $result_free_act['subject_id']."-".$result_free_act['order_number'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['date'] = $class_date;	
													$number++;
													$flag = 1;
													break;
												}elseif($this->search_array($subject_order,$reserved_array)){
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['activity_id'] =  $result_free_act['activity_id'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['name'] =  $result_free_act['name'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['program_year_id'] = $result_free_act['program_year_id'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['program_name'] = $result_free_act['program_name'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['teacher_id'] = $result_free_act['teacher_id'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['teacher_name'] = $result_free_act['teacher_name'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['group_id'] = $result_free_act['group_id'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['room_id'] = $rooms[$i]['id'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['room_name'] = $rooms[$i]['room_name'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['session_id'] = $result_free_act['session_id'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['session_name'] = $result_free_act['session_name'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_id'] = $result_free_act['subject_id'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_name'] = $result_free_act['subject_name'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['order_no'] = $result_free_act['order_number'];	
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_order'] =  $result_free_act['subject_id']."-".$result_free_act['order_number'];
													$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['date'] = $class_date;
													$number++;
													$flag = 1;
													break;
												}
												$i++;
											}
																			
										}
										if($flag == 1)
										break;
									}
								}
							}				
						}
					}
				}
			}
		//print"<pre>";print_r($reserved_array);die;
		$result_array[$cnt] = $reserved_array;
		$allocated_activities[$cnt] =  $number;
		}
		$output_array = array();
		if($allocated_activities[1] == $allocated_activities[2] && $allocated_activities[2] == $allocated_activities[3])
		{
			$output_array = $result_array[1];
		}else{
			if(($allocated_activities[1] > $allocated_activities[2]) && ($allocated_activities[1] > $allocated_activities[3]))
			{
				$output_array = $result_array[1];
			}elseif($allocated_activities[2] > $allocated_activities[3]){
				$output_array = $result_array[2];
			}else{
				$output_array = $result_array[3];
			}
		}
		return $output_array;
	}
	public function addTimetable($name, $start_date, $end_date, $start_week, $end_week)
	{
		$sql_insert = "insert into timetable set
						   timetable_name = '".$name."',
						   start_date = '".$start_date."',
						   end_date = '".$end_date."',
						   start_week = '".$start_week."',
						   end_week = '".$end_week."',
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
	public function addTimetableDetail($week, $day, $timeslot, $tt_id, $activity_id, $program_year_id, $teacher_id, $group_id, $room_id, $session_id, $subject_id, $date, $date_add, $date_upd)
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
									   week = '".$week."',
									   day = '".$day."',
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
	public function addWebCalEntry($date, $cal_time, $name, $room_name, $description)
	{
		$sql_insert_cal = "insert into webcal_entry set
									   cal_date = '".date('Ymd', strtotime($date))."',
									   cal_time = '".$cal_time."',
									   cal_mod_date = '".date('Ymd', strtotime($date))."',
									   cal_mod_time = '".gmdate ( 'Gis' )."',
									   cal_duration = '60',
									   cal_due_date = '".date('Ymd', strtotime($date))."',
									   cal_due_time = '".$cal_time."',
									   cal_priority = '5',
									   cal_type = 'E',
									   cal_access = 'P',
									   cal_name = '".$name."',
									   cal_location = '".$room_name."',
									   cal_description = '".$description."'";				   
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
	public function search_room($week,$slot,$shuffled_days)
	{
		
		$sql_room = $this->conn->query("select room_id, room.room_name
								from classroom_availability_rule_room_map cm
								inner join classroom_availability_rule_day_map cd on cd.classroom_availability_rule_id = cm.classroom_availability_rule_id
								inner join classroom_availability_rule ca on ca.id = cd.classroom_availability_rule_id
								inner join room on room.id = cm.room_id
								where weeks like '%".$week."%' and timeslot_id like '%".$slot."%' and day=".$shuffled_days);
							
		$k = 0;
		while($result_room = mysqli_fetch_array($sql_room))
		{
			
			$sql = $this->conn->query("select exception_date from classroom_availability_exception where room_id = '".$result_room['room_id']."'");
			$room_cnt = mysqli_num_rows($sql);
			if($room_cnt > 0)
			{
				while($data = mysqli_fetch_array($sql))
				{			
					$wk =   idate('W', strtotime($data['exception_date']));
					$wk_day = date('N', strtotime($data['exception_date']));
					$final_wk_day = $wk_day-1;
					if($wk == $week && $final_wk_day != $shuffled_days)
					{
						$rooms[$k]['id'] = $result_room['room_id'];
						$rooms[$k]['room_name'] = $result_room['room_name'];
						$k++;
						break;
					}
				}


			}else{
				$rooms[$k]['id'] = $result_room['room_id'];
				$rooms[$k]['room_name'] = $result_room['room_name'];
				$k++;
			}
				
		}
		//print"<pre>";print_r($rooms);print"</pre>";
		return $rooms;
	}
	public function search_teachers($week,$slot,$shuffled_days)
	{
		$teachers = array();
		$newteachers = array();
		$sql_teachers = $this->conn->query("select teacher_id 
								from teacher_availability_rule_teacher_map tm 
								inner join teacher_availability_rule_day_map td on td.teacher_availability_rule_id = tm.teacher_availability_rule_id
								inner join teacher_availability_rule ta on ta.id = td.teacher_availability_rule_id
								where ta.weeks like '%".$week."%' and td.timeslot_id like '%".$slot."%' and td.day=".$shuffled_days);
		while($result_teachers = mysqli_fetch_array($sql_teachers))
		{
			$sql = $this->conn->query("select exception_date from teacher_availability_exception where teacher_id = '".$result_teachers['teacher_id']."'");
			$teacher_cnt = mysqli_num_rows($sql);
			if($teacher_cnt > 0)
			{
				while($data = mysqli_fetch_array($sql))
				{			
					$wk =   idate('W', strtotime($data['exception_date']));
					$wk_day = date('N', strtotime($data['exception_date']));
					$final_wk_day = $wk_day-1;
					if($wk == $week && $final_wk_day != $shuffled_days)
					{
						$newteachers[] = $result_teachers['teacher_id'];
						break;
					}
				}
			}else{
				$newteachers[] = $result_teachers['teacher_id'];
			}
		}
		//print_r($newteachers);die;
		return $newteachers;
	}
	public function deleteData()
	{
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
}
