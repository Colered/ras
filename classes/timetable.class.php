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
		$start_final_day = '';
		$end_final_day = '';
		$flag = '0';
		$number = 0;
		$allocated_activities = '';
		$result_array = array();
		$start_date = $date;
		
		for($cnt = 1;$cnt<=3;$cnt++)
		{
			$reserved_array = array();
			while(strtotime($date) <= strtotime($end_date))
			{
				
				$day = date('w', strtotime($date));
				$final_day = $day - 1;
				if(!$this->checkHoliday($date))
				{
					if($day != 0)
					{
						$sql_slot = $this->conn->query("select id,timeslot_range from timeslot");
						$slot_cnt = mysqli_num_rows($sql_slot);
						if($slot_cnt > 0)
						{
							while($result_slot = mysqli_fetch_array($sql_slot))
							{
								$reserved_teachers = array();
								$reserved_rooms = array();
								$counter = array();
								$sql_pgm = $this->conn->query("SELECT distinct py.id as program_id
														FROM program_years py
														INNER JOIN program p on p.id = py.program_id
														WHERE DATE_FORMAT(start_date,'%Y-%m-%d') <= '".$start_date."' and start_year = '".$from_time."'");
														
								$pgm_cnt = mysqli_num_rows($sql_pgm);
								if($pgm_cnt > 0)
								{
									$i=0;
									while($result_pgm = mysqli_fetch_array($sql_pgm))
									{
										$sql_reserv_act = $this->conn->query("select ta.id as activity_id,ta.name,ta.program_year_id,py.name as program_name, ta.subject_id,su.subject_name,ta.session_id,s.session_name as session_name,ta.teacher_id,t.teacher_name,ta.group_id,ta.room_id,r.room_name,s.order_number
										from teacher_activity ta 
										inner join subject_session s on s.id = ta.session_id
										inner join program_years py on py.id = ta.program_year_id
										inner join subject su on su.id = ta.subject_id
										inner join teacher t on t.id = ta.teacher_id
										inner join room r on r.id = ta.room_id
										where timeslot_id = '".$result_slot['id']."' and reserved_flag = 1 and ta.program_year_id = '".$result_pgm['program_id']."' and DATE_FORMAT(act_date,'%Y-%m-%d') = '".$date."' order by rand()");
										$res = 0;
										while($result_reserv_act = mysqli_fetch_array($sql_reserv_act))
										{
											$min_order_id = $this->getMinimumOrderBySubject($result_reserv_act['subject_id']);		
											if(!$this->search_array($result_reserv_act['name'],$reserved_array)) 
											{												
												if($result_reserv_act['order_number'] == $min_order_id)
												{													
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['activity_id'] =  $result_reserv_act['activity_id'];
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['name'] =  $result_reserv_act['name'];
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['program_year_id'] = $result_reserv_act['program_year_id'];
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['program_name'] = $result_reserv_act['program_name'];							
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['teacher_id'] = $result_reserv_act['teacher_id'];
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['teacher_name'] = $result_reserv_act['teacher_name'];
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['group_id'] = $result_reserv_act['group_id'];
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_id'] = $result_reserv_act['room_id'];
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_name'] = $result_reserv_act['room_name'];
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['session_id'] = $result_reserv_act['session_id'];
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['session_name'] = $result_reserv_act['session_name'];
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['subject_id'] = $result_reserv_act['subject_id'];
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['subject_name'] = $result_reserv_act['subject_name'];
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['order_no'] = $result_reserv_act['order_number'];
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['subject_order'] = $result_reserv_act['subject_id']."-".$result_reserv_act['order_number'];
													$reserved_array[$date][$result_slot['timeslot_range']][$i]['date'] = $date;
													$reserved_rooms[$result_slot['timeslot_range']][$i] = $result_reserv_act['room_id'];
													$reserved_teachers[$result_slot['timeslot_range']][$i] = $result_reserv_act['teacher_id'];
													$number++;
													$res++;
													$i++;
													break;
												}else
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
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['activity_id'] =  $result_reserv_act['activity_id'];
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['name'] =  $result_reserv_act['name'];
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['program_year_id'] = $result_reserv_act['program_year_id'];
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['program_name'] = $result_reserv_act['program_name'];							
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['teacher_id'] = $result_reserv_act['teacher_id'];
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['teacher_name'] = $result_reserv_act['teacher_name'];
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['group_id'] = $result_reserv_act['group_id'];
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_id'] = $result_reserv_act['room_id'];
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_name'] = $result_reserv_act['room_name'];
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['session_id'] = $result_reserv_act['session_id'];
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['session_name'] = $result_reserv_act['session_name'];
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['subject_id'] = $result_reserv_act['subject_id'];
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['subject_name'] = $result_reserv_act['subject_name'];
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['order_no'] = $result_reserv_act['order_number'];
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['subject_order'] = $result_reserv_act['subject_id']."-".$result_reserv_act['order_number'];
														$reserved_array[$date][$result_slot['timeslot_range']][$i]['date'] = $date;
														$reserved_rooms[$result_slot['timeslot_range']][$i] = $result_reserv_act['room_id'];
														$reserved_teachers[$result_slot['timeslot_range']][$i] = $result_reserv_act['teacher_id'];
														$number++;
														$res++;
														$i++;
														break;
													}
												}
											}
										}
										if($res == 0)
										{
											$teachers = $this->search_teachers($date,$result_slot['id'],$final_day);			
											foreach($teachers as $teacher)
											{						
												$sql_free_act = $this->conn->query("select ta.id as activity_id,ta.name,ta.program_year_id,py.name as program_name, ta.subject_id, su.subject_name, ta.session_id,s.session_name as session_name,ta.teacher_id,t.teacher_name,ta.group_id,s.order_number 
												from teacher_activity ta 
												inner join subject_session s on s.id = ta.session_id 
												inner join program_years py on py.id = ta.program_year_id 
												inner join subject su on su.id = ta.subject_id 
												inner join teacher t on t.id = ta.teacher_id 
												where teacher_id = ".$teacher." and reserved_flag = 0 and ta.program_year_id = '".$result_pgm['program_id']."' order by rand()");
												
												$flag = 0;
												while($result_free_act = mysqli_fetch_array($sql_free_act))
												{
													$j = 0;
													$rooms = $this->search_room($date,$result_slot['id'],$final_day);
													if(!empty($rooms) && $this->search_array($rooms[$j]['id'],$reserved_rooms))
													{
														$j++;
													}
													$min_order_id = $this->getMinimumOrderBySubject($result_free_act['subject_id']);
													if(!$this->search_array($result_free_act['name'],$reserved_array) && !$this->search_array($result_free_act['subject_id']."-".$result_free_act['order_number'],$reserved_array) && !empty($rooms) && isset($rooms[$j]['id']) && !$this->search_array($result_free_act['teacher_id'],$reserved_teachers))
													{
														if($result_free_act['order_number'] == $min_order_id)
														{
															$reserved_array[$date][$result_slot['timeslot_range']][$i]['activity_id'] =  $result_free_act['activity_id'];
															$reserved_array[$date][$result_slot['timeslot_range']][$i]['name'] =  $result_free_act['name'];
															$reserved_array[$date][$result_slot['timeslot_range']][$i]['program_year_id'] = $result_free_act['program_year_id'];
															$reserved_array[$date][$result_slot['timeslot_range']][$i]['program_name'] = $result_free_act['program_name'];
															$reserved_array[$date][$result_slot['timeslot_range']][$i]['teacher_id'] = $result_free_act['teacher_id'];
															$reserved_array[$date][$result_slot['timeslot_range']][$i]['teacher_name'] = $result_free_act['teacher_name'];
															$reserved_array[$date][$result_slot['timeslot_range']][$i]['group_id'] = $result_free_act['group_id'];
															$reserved_array[$date][$result_slot['timeslot_range']][$i]['session_id'] = $result_free_act['session_id'];
															$reserved_array[$date][$result_slot['timeslot_range']][$i]['session_name'] = $result_free_act['session_name'];
															$reserved_array[$date][$result_slot['timeslot_range']][$i]['subject_id'] = $result_free_act['subject_id'];
															$reserved_array[$date][$result_slot['timeslot_range']][$i]['subject_name'] = $result_free_act['subject_name'];
															$reserved_array[$date][$result_slot['timeslot_range']][$i]['order_no'] = $result_free_act['order_number'];	
															$reserved_array[$date][$result_slot['timeslot_range']][$i]['subject_order'] =  $result_free_act['subject_id']."-".$result_free_act['order_number'];
															$reserved_array[$date][$result_slot['timeslot_range']][$i]['date'] = $date;
															$reserved_teachers[$result_slot['timeslot_range']][$i] = $result_free_act['teacher_id'];
															$reserved_rooms[$result_slot['timeslot_range']][$i] = $rooms[$j]['id'];
															if(array_key_exists($result_free_act['subject_id'], $counter))
															{
																$room_name = $this->getRoomName($counter[$result_free_act['subject_id']]);
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_id'] = $counter[$result_free_act['subject_id']];
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_name'] = $room_name;
															}
															else{
																$room_id = $this->getRoomBySubject($result_free_act['subject_id']);
																if($room_id)
																{
																	$room_name = $this->getRoomName($room_id);
																	$counter[$result_free_act['subject_id']] = $room_id;
																	$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_id'] = $room_id;
																	$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_name'] = $room_name;

																}else{
																	$room_name = $this->getRoomName($rooms[$j]['id']);
																	$counter[$result_free_act['subject_id']] = $rooms[$j]['id'];
																	$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_id'] = $rooms[$j]['id'];
																	$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_name'] = $room_name;
																}
															}
															$number++;
															$i++;
															$flag = 1;
															break;
														}
														else{
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
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['activity_id'] = $result_free_act['activity_id'];
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['name'] =  $result_free_act['name'];
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['program_year_id'] = $result_free_act['program_year_id'];
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['program_name'] = $result_free_act['program_name'];
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['teacher_id'] = $result_free_act['teacher_id'];
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['teacher_name'] = $result_free_act['teacher_name'];
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['group_id'] = $result_free_act['group_id'];
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['session_id'] = $result_free_act['session_id'];
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['session_name'] = $result_free_act['session_name'];
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['subject_id'] = $result_free_act['subject_id'];
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['subject_name'] = $result_free_act['subject_name'];
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['order_no'] = $result_free_act['order_number'];	
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['subject_order'] =  $result_free_act['subject_id']."-".$result_free_act['order_number'];
																$reserved_array[$date][$result_slot['timeslot_range']][$i]['date'] = $date;
																$reserved_teachers[$result_slot['timeslot_range']][$i] = $result_free_act['teacher_id'];
																$reserved_rooms[$result_slot['timeslot_range']][$i] = $rooms[$j]['id'];
																if(array_key_exists($result_free_act['subject_id'], $counter))
																{
																	$room_name = $this->getRoomName($counter[$result_free_act['subject_id']]);
																	$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_id'] = $counter[$result_free_act['subject_id']];
																	$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_name'] = $room_name;
																}
																else{
																		$room_id = $this->getRoomBySubject($result_free_act['subject_id']);
																		if($room_id)
																		{
																			$room_name = $this->getRoomName($room_id);
																			$counter[$result_free_act['subject_id']] = $room_id;
																			$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_id'] = $room_id;
																			$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_name'] = $room_name;

																		}else{
																			$room_name = $this->getRoomName($rooms[$j]['id']);
																			$counter[$result_free_act['subject_id']] = $rooms[$j]['id'];
																			$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_id'] = $rooms[$j]['id'];
																			$reserved_array[$date][$result_slot['timeslot_range']][$i]['room_name'] = $room_name;
																		}
																}
																$number++;
																$i++;
																$flag = 1;
																break;
															}
														}
														$j++;
													}																	
												}
												if($flag == 1)
												break;
											}
											
										}
									}
								}else{
									$err['program_not_found'] = 'No program found';
									return $err;									
								}
							//print"<pre>";print_r($counter);	die;
							}
						}else{
							$err['timeslot_not_found'] = 'No Timeslot found';
							return $err;							
						}
					}
				}
				$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
				
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
		if(empty($output_array))
		{
			$err['system_error'] = 'System could not generate the timetable. Please check your data first';
			return $err;
		}	
		//print"<pre>";print_r($output_array);die;
		return $output_array;		
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
	public function search_room($date,$slot,$final_day)
	{
		$rooms = array();
		$sql_room = $this->conn->query("select distinct room_id, room.room_name
								from classroom_availability_rule_room_map cm
								inner join classroom_availability_rule_day_map cd on cd.classroom_availability_rule_id = cm.classroom_availability_rule_id
								inner join classroom_availability_rule ca on ca.id = cd.classroom_availability_rule_id
								inner join room on room.id = cm.room_id
								where start_date <= '".$date."' and end_date >= '".$date."' and day= '".$final_day."' and timeslot_id like '%".$slot."%'");
								
							
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
	public function search_teachers($date, $slot, $final_day)
	{
		$teachers = array();
		$newteachers = array();
		$sql_teachers = $this->conn->query("select distinct teacher_id 
								from teacher_availability_rule_teacher_map tm 
								inner join teacher_availability_rule_day_map td on td.teacher_availability_rule_id = tm.teacher_availability_rule_id
								inner join teacher_availability_rule ta on ta.id = td.teacher_availability_rule_id
								where start_date <= '".$date."' and end_date >= '".$date."' and day= '".$final_day."' and td.timeslot_id like '%".$slot."%'");
		while($result_teachers = mysqli_fetch_array($sql_teachers))
		{
			$sql = $this->conn->query("select id from teacher_availability_exception where teacher_id = '".$result_teachers['teacher_id']."' and exception_date = '".$date."'");
			$teacher_cnt = mysqli_num_rows($sql);
			if($teacher_cnt == 0)
			{
				$newteachers[] = $result_teachers['teacher_id'];
			}
		}		
		return $newteachers;
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
	public function getMinimumOrderBySubject($subject_id)
	{
		$sql_select = $this->conn->query("select min(order_number) as min_order_id FROM `subject_session` WHERE subject_id = '".$subject_id."'");
		$row_cnt = mysqli_num_rows($sql_select);
		if($row_cnt > 0)
		{
			$min_order_id = mysqli_fetch_array($sql_select);
			return $min_order_id;			
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
}
