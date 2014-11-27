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
	public function getTeachersInRange($from,$to,$teacher_id='',$program_id='',$area_id='',$profesor_id='',$cycle_id=''){
		 $teacher_sql = "select t.id,td.date,t.teacher_name,t.teacher_type,py.name,p.company,u.name as unit,t.payrate,s.session_name from timetable_detail td inner join teacher t on t.id = td.teacher_id inner join subject su on su.id = td.subject_id inner join program_years py on py.id = td.program_year_id inner join program p on p.id = py.program_id inner join unit u on u.id = p.unit inner join subject_session s on s.id = td.session_id where date between '".$from."' and '".$to."'";
		 if($teacher_id != '')
		{
			 $teacher_sql .= " and teacher_id = '".$teacher_id."'";
		}
		if($program_id != '')
		{
			$teacher_sql .= " and td.program_year_id = '".$program_id."'";
		}
		if($area_id != '')
		{
			$teacher_sql .= " and su.area_id = '".$area_id."'";
		}
		$teacher_sql .= " order by td.teacher_id";		
		$q_res = mysqli_query($this->conn, $teacher_sql);
		return $q_res;
	}
	public function getTeacherId($from,$to,$teacher_id='',$program_id='',$area_id='',$profesor_id='',$cycle_id=''){
		$teacher_sql = "select distinct teacher_id,count(session_id) as session_id,t.teacher_name,t.payrate from timetable_detail td inner join teacher t on t.id = td.teacher_id inner join subject su on su.id = td.subject_id where date between '".$from."' and '".$to."'";
		if($teacher_id != '')
		{
			 $teacher_sql .= " and teacher_id = '".$teacher_id."'";
		}
		if($program_id != '')
		{
			$teacher_sql .= " and td.program_year_id = '".$program_id."'";
		}
		if($area_id != '')
		{
			$teacher_sql .= " and su.area_id = '".$area_id."'";
		}
		$teacher_sql .= " group by td.teacher_id order by td.teacher_id";
		//echo $teacher_sql;die;
		$q_res = mysqli_query($this->conn, $teacher_sql);
		return $q_res;
	}
	/*public function getAllTeachers($from,$to){
		$teacher_sql = "select distinct teacher_id,t.teacher_name from timetable_detail td inner join teacher t on t.id = td.teacher_id where date between '".$from."' and '".$to."' group by td.teacher_id order by td.teacher_id";
		$q_res = mysqli_query($this->conn, $teacher_sql);
		return $q_res;
	}*/
	
	public function generateTimetable($date, $end_date, $from_time)
	{	
		$start_date = $date;
		//function call to search all programs with their dates and times, which occur in the timetable range
		$programs = $this->search_programs($start_date,$from_time,$end_date);		
		//sort the programs array by date
		$new_programs = array();
		foreach($programs as $pgm_id => $vals)
		{
			foreach($vals as $newkey => &$values)
			{
				uksort($values, function($a, $b){
				$a = new DateTime($a);
				$b = new DateTime($b);

				return $a->getTimestamp() - $b->getTimestamp();
			});
			$new_programs[$pgm_id][$newkey] =  $values;		
			}
		}		
		$reserved_array = array();
		$reserved_teachers = array();
		$reserved_rooms = array();
		$teachers_count = array();
		$teachers_sat = array();
		$locations = array();
		$reserved_areas = array();
		$reserved_subject_rooms = array();
		$i=0;		
		foreach($new_programs as $key=>$cycles)
		{				
			$program_id = $key;
			foreach($cycles as $cyc_id=>$value)
			{
				$cycle_id = $cyc_id;				
				foreach($value as $k=>$v)
				{
					$date = $k;
					$f_day = $this->getDayFromDate($date);
					//check if the date is a holiday. If not proceed further
					if(!$this->checkHoliday($date))
					{
						$end_time = '';	
						$sat_flag = 0;	
						$reserved_timeslots = array();
						//search all the reserved activities for that date
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
								$sql_reserv_act = $this->conn->query("select ta.id as activity_id,ta.name,ta.program_year_id,py.name as program_name, ta.subject_id,su.subject_name,su.area_id,ta.session_id,s.session_name as session_name,ta.teacher_id,t.teacher_name,ta.group_id,ta.room_id,r.room_name,s.order_number,ta.start_time, s.duration, ta.timeslot_id, b.location_id from teacher_activity ta 
								inner join subject_session s on s.id = ta.session_id
								inner join program_years py on py.id = ta.program_year_id
								inner join subject su on su.id = ta.subject_id
								inner join teacher t on t.id = ta.teacher_id
								inner join room r on r.id = ta.room_id
								inner join building b on r.building_id = b.id
								where start_time = '".$start_id."' and reserved_flag = 1 and DATE_FORMAT(act_date,'%Y-%m-%d') = '".$date."' and ta.program_year_id = '".$program_id."' and su.cycle_no = '".$cycle_id."'");
								while($result_reserv_act = mysqli_fetch_array($sql_reserv_act))
								{							
									$end_time = date("h:i A", strtotime($start_time." + ".$result_reserv_act['duration']." minutes"));
									//Here will check if the activity is not already allocated and all the sessions with lesser order number are allocated, we will proceed with this activity
									if(!$this->search_array($result_reserv_act['name'],$reserved_array)) 
									{
										//Here will check a teacher can take maximum of 4 sessions per day
										if((array_key_exists($date,$teachers_count) && array_key_exists($result_reserv_act['teacher_id'],$teachers_count[$date]) && $teachers_count[$date][$result_reserv_act['teacher_id']] < 4) || !array_key_exists($date,$teachers_count) || !array_key_exists($result_reserv_act['teacher_id'],$teachers_count[$date]))
										{
											//Here will check a teacher can have maximum of two saturdays working per cycle
											if(($f_day == 5 && array_key_exists($cycle_id,$teachers_sat) && array_key_exists($result_reserv_act['teacher_id'],$teachers_sat[$cycle_id]) && ($teachers_sat[$cycle_id][$result_reserv_act['teacher_id']] < 2 || $sat_flag > 0)) || $f_day != 5 || ($f_day == 5 && !array_key_exists($cycle_id,$teachers_sat)))				
											{
												//Here will check a teacher cannot have classes in different locations on same day
												if((array_key_exists($date,$locations) && array_key_exists($result_reserv_act['teacher_id'],$locations[$date]) && in_array($result_reserv_act['location_id'],$locations[$date])) || !array_key_exists($date,$locations) || !array_key_exists($result_reserv_act['teacher_id'],$locations[$date]))
												{
													//Here will check sessions from same area will be scheduled on saturday 
													if(($f_day == 5 && array_key_exists($date,$reserved_areas) && $reserved_areas[$date] == $result_reserv_act['area_id']) || $f_day != 5 || ($f_day == 5 && !array_key_exists($date,$reserved_areas)))
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
															$reserved_array[$date][$i][$start_time." - ".$end_time]['cycle_id'] = $cycle_id;
															$reserved_rooms[$date][$start_time." - ".$end_time][$i] = $result_reserv_act['room_id'];
															$reserved_teachers[$date][$start_time." - ".$end_time][$i] = $result_reserv_act['teacher_id'];
															$ts_array = explode(",",$result_reserv_act['timeslot_id']);								
															foreach($ts_array as $ts_id)
															{
																$reserved_timeslots[] = trim($ts_id);
															}
															
															if(array_key_exists($date,$teachers_count) && array_key_exists($result_reserv_act['teacher_id'],$teachers_count[$date]))
															{
																$teachers_count[$date][$result_reserv_act['teacher_id']] = $teachers_count[$date][$result_reserv_act['teacher_id']] + 1;
															}else{
																$teachers_count[$date][$result_reserv_act['teacher_id']] = 1;
															}
															if($f_day == 5 && $sat_flag == 0)
															{
																if(array_key_exists($cycle_id,$teachers_sat) && array_key_exists($result_reserv_act['teacher_id'],$teachers_sat[$cycle_id]))
																{
																$teachers_sat[$cycle_id][$result_reserv_act['teacher_id']] = $teachers_sat[$cycle_id][$result_reserv_act['teacher_id']] + 1;
																}else{
																	$teachers_sat[$cycle_id][$result_reserv_act['teacher_id']] = 1;
																}													
																$sat_flag++;
															}
															if($f_day == 5)
															{
																$reserved_areas[$date] = $result_reserv_act['area_id'];
															}
															$locations[$date][$result_reserv_act['teacher_id']] = $result_reserv_act['location_id'];
															break;													
														}
													}
												}
											}
										}
									}							
								}
							}
						}
						
						//search the free activities for the remaining timeslots for the same date
						$total_timeslots = array();
						foreach($v as $start_id)
						{
							$total_timeslots[] = $start_id;
						}					
						$unreserved_timeslots = array_diff($total_timeslots,$reserved_timeslots);	
						$unreserved_times = $this->getTimeSlots($unreserved_timeslots);
						
						foreach($unreserved_times as $un_tsid)
						{
							$sql_free_act = $this->conn->query("select ta.id as activity_id,ta.name,ta.program_year_id,py.name as program_name, ta.subject_id, su.subject_name,su.area_id, ta.session_id,s.session_name as session_name,ta.teacher_id,t.teacher_name,ta.group_id,s.order_number,s.duration 
							from teacher_activity ta 
							inner join subject_session s on s.id = ta.session_id 
							inner join program_years py on py.id = ta.program_year_id 
							inner join subject su on su.id = ta.subject_id 
							inner join teacher t on t.id = ta.teacher_id 
							where reserved_flag = 0 and ta.program_year_id = '".$program_id."' and su.cycle_no = '".$cycle_id."' order by ta.id");
							$flag = '';
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
									//first we will check if the teacher of the free activity is available at that time
									if($this->checkTeacherAvailability($result_free_act['teacher_id'],$date,$all_ts))
									{										
										//Then we will check if the teacher is not busy with any other activity at that time
										if(!$this->isTeacherReserved($date,$start_time,$end_time,$result_free_act['teacher_id'],$reserved_teachers))
										{										
											//Here will check a teacher can take maximum of 4 sessions per day
											if((array_key_exists($date,$teachers_count) && array_key_exists($result_free_act['teacher_id'],$teachers_count[$date]) && $teachers_count[$date][$result_free_act['teacher_id']] < 4) || !array_key_exists($date,$teachers_count) || !array_key_exists($result_free_act['teacher_id'],$teachers_count[$date]))
											{												
												//Here will check a teacher can have maximum of two saturdays working per cycle
												if(($f_day == 5 && array_key_exists($cycle_id,$teachers_sat) && array_key_exists($result_free_act['teacher_id'],$teachers_sat[$cycle_id]) && ($teachers_sat[$cycle_id][$result_free_act['teacher_id']] < 2 || $sat_flag > 0)) || $f_day != 5 || ($f_day == 5 && !array_key_exists($cycle_id,$teachers_sat)))
												{																				
													//Here we will get the room of a subject that lies with in that week range
													$room_id_res = $this->getRoomBySubject($result_free_act['subject_id'],$date);
													if($room_id_res == ''){
														$room_id = $this->getRoomFromReservedAct($result_free_act['subject_id'],$date,$reserved_subject_rooms);
													}else{
														$room_id = $room_id_res;
													}												
													if($room_id)
													{
														//If room found,we will check its availability at that time
														if($this->checkRoomAvailability($room_id,$date,$all_ts))
														{															
															//If available,we will check if room is not busy with any other activity
															if(!$this->isRoomReserved($date,$start_time,$end_time,$room_id,$reserved_rooms))
															{																
																$loc_id = $this->getLocation($room_id);	
																//Here will check a teacher cannot have classes in different locations on same day
																if((array_key_exists($date,$locations) && array_key_exists($result_free_act['teacher_id'],$locations[$date]) && in_array($loc_id,$locations[$date])) || !array_key_exists($date,$locations) || !array_key_exists($result_free_act['teacher_id'],$locations[$date]))
																{	
																	//Here will check sessions from same area will be scheduled on saturday 
																	if(($f_day == 5 && array_key_exists($date,$reserved_areas) && $reserved_areas[$date] == $result_free_act['area_id']) || $f_day != 5 || ($f_day == 5 && !array_key_exists($date,$reserved_areas)))
																	{																
																		//If activity is not already allocated ,session is not already taken and all the sessions with lesser order number have been taken, then we will allocate the activity
																		if(!$this->search_array($result_free_act['name'],$reserved_array) && !$this->search_array($result_free_act['subject_id']."-".$result_free_act['order_number'],$reserved_array))
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
																				$room_name = $this->getRoomName($room_id);				
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
																				$reserved_array[$date][$i][$start_time." - ".$end_time]['cycle_id'] = $cycle_id."-".$f_day;
																				$reserved_array[$date][$i][$start_time." - ".$end_time]['room_id'] = $room_id;
																				$reserved_array[$date][$i][$start_time." - ".$end_time]['room_name'] = $room_name;
																				$reserved_teachers[$date][$start_time." - ".$end_time][$i] = $result_free_act['teacher_id'];
																				$reserved_rooms[$date][$start_time." - ".$end_time][$i] = $room_id;
																				$reserved_subject_rooms[$date][$result_free_act['subject_id']] = $room_id;
																				$unreserved_timeslots = array_diff($unreserved_timeslots,$time);
																				$unreserved_times = $this->getTimeSlots($unreserved_timeslots);	
																				if(array_key_exists($date,$teachers_count) && array_key_exists($result_free_act['teacher_id'],$teachers_count[$date]))
																				{
																					$teachers_count[$date][$result_free_act['teacher_id']] = $teachers_count[$date][$result_free_act['teacher_id']] + 1;
																				}else{
																					$teachers_count[$date][$result_free_act['teacher_id']] = 1;
																				}
																				
																				if($f_day == 5 && $sat_flag == 0)
																				{
																					if(array_key_exists($cycle_id,$teachers_sat) && array_key_exists($result_free_act['teacher_id'],$teachers_sat[$cycle_id]))
																					{
																					$teachers_sat[$cycle_id][$result_free_act['teacher_id']] = $teachers_sat[$cycle_id][$result_free_act['teacher_id']] + 1;
																					}else{
																						$teachers_sat[$cycle_id][$result_free_act['teacher_id']] = 1;
																					}														
																					$sat_flag++;
																				}
																				if($f_day == 5)
																				{
																					$reserved_areas[$date] = $result_free_act['area_id'];
																				}
																				$locations[$date][$result_free_act['teacher_id']] = $loc_id;
																				break;												
																			}											
																		}
																	}
																}
															}
														}
													}
													else
													{ //if no room we get, then we will search for rooms for that time
														$rooms = $this->search_room($date,$all_ts);									
														foreach($rooms as $room)
														{
															//Here, will check if the room is not busy with any other activity
															if(!$this->isRoomReserved($date,$start_time,$end_time,$room['id'],$reserved_rooms))
															{
																//Here will check a teacher cannot have classes in different locations on same day
																if((array_key_exists($date,$locations) && array_key_exists($result_free_act['teacher_id'],$locations[$date]) && in_array($room['location_id'],$locations[$date])) || !array_key_exists($date,$locations) || !array_key_exists($result_free_act['teacher_id'],$locations[$date]))
																{
																	//Here will check sessions from same area will be scheduled on saturday 
																	if(($f_day == 5 && array_key_exists($date,$reserved_areas) && $reserved_areas[$date] == $result_free_act['area_id']) || $f_day != 5 || ($f_day == 5 && !array_key_exists($date,$reserved_areas)))
																	{
																		//If activity is not already allocated ,session is not already taken and all the sessions with lesser order number have been taken, then we will allocate the activity
																		if(!$this->search_array($result_free_act['name'],$reserved_array) && !$this->search_array($result_free_act['subject_id']."-".$result_free_act['order_number'],$reserved_array))
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
																				$room_name = $this->getRoomName($room['id']);
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
																				$reserved_array[$date][$i][$start_time." - ".$end_time]['cycle_id'] = $cycle_id."-".$f_day;
																				$reserved_array[$date][$i][$start_time." - ".$end_time]['room_id'] = $room['id'];
																				$reserved_array[$date][$i][$start_time." - ".$end_time]['room_name'] = $room_name;
																				$reserved_teachers[$date][$start_time." - ".$end_time][$i] = $result_free_act['teacher_id'];
																				$reserved_rooms[$date][$start_time." - ".$end_time][$i] = $room['id'];	
																				$reserved_subject_rooms[$date][$result_free_act['subject_id']] = $room['id'];
																				if(array_key_exists($date,$teachers_count) && array_key_exists($result_free_act['teacher_id'],$teachers_count[$date]))
																				{
																					$teachers_count[$date][$result_free_act['teacher_id']] = $teachers_count[$date][$result_free_act['teacher_id']] + 1;
																				}else{
																					$teachers_count[$date][$result_free_act['teacher_id']] = 1;
																				}
																				if($f_day == 5 && $sat_flag == 0)
																				{
																					if(array_key_exists($cycle_id,$teachers_sat) && array_key_exists($result_free_act['teacher_id'],$teachers_sat[$cycle_id]))
																					{
																					$teachers_sat[$cycle_id][$result_free_act['teacher_id']] = $teachers_sat[$cycle_id][$result_free_act['teacher_id']] + 1;
																					}else{
																						$teachers_sat[$cycle_id][$result_free_act['teacher_id']] = 1;
																					}
																					$sat_flag++;
																				}
																				if($f_day == 5)
																				{
																					$reserved_areas[$date] = $result_free_act['area_id'];
																				}
																				$unreserved_timeslots = array_diff($unreserved_timeslots,$time);
																				$unreserved_times = $this->getTimeSlots($unreserved_timeslots);
																				$locations[$date][$result_free_act['teacher_id']] = $room['location_id'];
																				$flag = 1;
																				break;												
																			}											
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}								
								}
								if($flag == 1)
									break;
							}
						}					
					}
				}
			}
			
			$i++;
		}
		//If array is empty,means no activity has been allocated. We will shoe the message to user
		if(empty($reserved_array))
		{
			$err['system_error'] = 'System could not generate the timetable. Please check your data first';
			return $err;
		}			
		return $reserved_array;		
	}

	//function to check if the teacher is not allocated to any other activity at the same date and same time
	public function isTeacherReserved($date,$start_time,$end_time,$teacher_id,$reserved_teachers = array())
	{
		if(array_key_exists($date, $reserved_teachers))
		{
			foreach($reserved_teachers[$date] as $key => $value)
			{											
				$ts_array = explode("-",$key);									
				$st = DateTime::createFromFormat('H:i a', trim($ts_array['0']));
				$et = DateTime::createFromFormat('H:i a', trim($ts_array['1']));
				$s_time = DateTime::createFromFormat('H:i a', $start_time);
				$e_time = DateTime::createFromFormat('H:i a', $end_time);					
				if(($s_time >= $st && $s_time < $et) || ($e_time > $st && $e_time <= $et))
				{												
					if($this->search_array($teacher_id,$reserved_teachers[$date][$key]))
					{
						//echo "---". $ts_array['0']."---".$ts_array['1']."---".$start_time."---".$end_time;die("if");
						return 1;
					}else{
						return 0;
					}
				}
			}
		}
	}
	public function getRoomFromReservedAct($subject_id,$date,$reserved_rooms = array())
	{
		
		foreach($reserved_rooms as $key => $value)
		{
			$timestamp = strtotime($key);
			$startDateOfWeek = (date("D", $timestamp) == 'Mon') ? date('Y-m-d', $timestamp) : date('Y-m-d', strtotime('Last Monday', $timestamp));
			$endDateOfWeek = (date("D", $timestamp) == 'Sun') ? date('Y-m-d', $timestamp) : date('Y-m-d', strtotime('Next Sunday', $timestamp));
			if($date >= $startDateOfWeek && $date <= $endDateOfWeek)
			{
				if(array_key_exists($subject_id,$reserved_rooms[$key]))
				{
					$rid = $reserved_rooms[$key][$subject_id];
					return $rid;
				}
			}
		}
	}

	//function to check if the room is not allocated to any other activity at the same date and same time
	public function isRoomReserved($date,$start_time,$end_time,$room_id,$reserved_rooms = array())
	{
		if(array_key_exists($date, $reserved_rooms))
		{
			foreach($reserved_rooms[$date] as $key => $value)
			{											
				$ts_array = explode("-",$key);									
				$st = DateTime::createFromFormat('H:i a', trim($ts_array['0']));
				$et = DateTime::createFromFormat('H:i a', trim($ts_array['1']));
				$s_time = DateTime::createFromFormat('H:i a', $start_time);
				$e_time = DateTime::createFromFormat('H:i a', $end_time);					
				if(($s_time >= $st && $s_time < $et) || ($e_time > $st && $e_time <= $et))
				{												
					if($this->search_array($room_id,$reserved_rooms[$date][$key]))
					{
						//echo "---". $ts_array['0']."---".$ts_array['1']."---".$start_time."---".$end_time;die("if");
						return 1;
					}else{
						return 0;
					}
				}
			}
		}
	}

	public function getDayFromDate($date)
	{
		$day = date('w', strtotime($date));
		$final_day = $day - 1;
		return $final_day;
	}

	//function to add the timetable basic details in database
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

	//function to add the full timetable details in database
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

	//function to add the activities in calendar table so that they show up in calendar
	public function addWebCalEntry($date, $cal_time, $name, $room_name, $description, $duration, $teacher_id, $subject_id, $room_id, $program_year_id)
	{
		$sql_insert_cal = "insert into webcal_entry set
									   cal_date = '".$date."',
									   cal_time = '".$cal_time."',
									   cal_mod_date = '".date('Ymd', strtotime($date))."',
									   cal_mod_time = '".gmdate ( 'Gis' )."',
									   cal_duration = '".$duration."',
									   cal_due_date = '".$date."',
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

	//function to add the activities in calendar table so that they show up in calendar
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

	//function to search a value in an array recursively
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

	//function to check teacher availability at a particular date, day and timeslots
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

	//function to check room availability at a particular date, day and timeslots
	public function checkRoomAvailability($room_id,$date,$tsIdsAll)
	{
		//check if the selected date is not added as exception in classroom availability
		$query = $this->conn->query("select id from classroom_availability_exception where room_id = '".$room_id."' and exception_date = '".$date."'");
		if(mysqli_num_rows($query) == 0)
		{
			//find the day using date
			$day = date('w', strtotime($date));
			$final_day = $day - 1;
			//check if classroom is available on the given time and day
			$classroomAvail_query=$this->conn->query("select cm.room_id, room.room_name
							from classroom_availability_rule_room_map cm
							inner join classroom_availability_rule_day_map cd on cd.classroom_availability_rule_id = cm.classroom_availability_rule_id
							inner join classroom_availability_rule ca on ca.id = cd.classroom_availability_rule_id
							inner join room on room.id = cm.room_id
							where start_date <= '".$date."' and end_date >= '".$date."' and day= '".$final_day."' and cm.room_id='".$room_id."' and actual_timeslot_id like '%".$tsIdsAll."%'");
			if(mysqli_num_rows($classroomAvail_query) > 0)
			{
				return 1;
			}
		}
	}

	//function to search room on a particular date and timeslot
	public function search_room($date,$slot)
	{
		$rooms = array();
		$day = date('w', strtotime($date));
		$final_day = $day - 1;
		$sql_room = $this->conn->query("select distinct room_id, room.room_name, b.location_id
								from classroom_availability_rule_room_map cm
								inner join classroom_availability_rule_day_map cd on cd.classroom_availability_rule_id = cm.classroom_availability_rule_id
								inner join classroom_availability_rule ca on ca.id = cd.classroom_availability_rule_id
								inner join room on room.id = cm.room_id
								inner join building b on room.building_id = b.id
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
				$rooms[$k]['location_id'] = $result_room['location_id'];
				$k++;
				
			}				
		}
		//print"<pre>";print_r($rooms);die;
		return $rooms;
	}

	//function to get all the programs, which lies in the duration of timetable generation period with their date and timeslot list
	public function search_programs($start_date,$from_time,$end_date)
	{
		$final_pgms = array();
		$last_day = 5;	
		$sql_pgm_cycle = $this->conn->query("select * from cycle where start_week >= '".$start_date."' and start_week <= '".$end_date."'");
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
							$sql_pgm_exp = $this->conn->query("select id from program_cycle_exception where exception_date = '".$val."' and program_year_id = '".$result_pgm_cycle['program_year_id']."'");
							if(mysqli_num_rows($sql_pgm_exp) == 0)
							{
								$final_pgms[$result_pgm_cycle['program_year_id']][$result_pgm_cycle['id']][$val] = $value;
							}
						}								
					}											
				}else if($result_pgm_cycle['occurrence'] == '2w'){
					$weeks = $this->countWeeksBetweenDates($result_pgm_cycle['start_week'],$end_week);
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
									$sql_pgm_exp = $this->conn->query("select id from program_cycle_exception where exception_date = '".$val."' and program_year_id = '".$result_pgm_cycle['program_year_id']."'");
									if(mysqli_num_rows($sql_pgm_exp) == 0)
									{
										$final_pgms[$result_pgm_cycle['program_year_id']][$result_pgm_cycle['id']][$val] = $value;
									}
								}														
							}
							$date = new DateTime($end_week);
							$date->modify('+2 day');
							$start_week = $date->format('Y-m-d');
						}else{	
							$day = date("w", strtotime($start_week));
							$day = $day-1;
							$rem_days = $last_day-$day;
							$date = new DateTime($start_week);
							$date->modify('+'.$rem_days.' day');
							$end_week = $date->format('Y-m-d');	
							if(count(unserialize($result_pgm_cycle['week2'])) > 0)
							{
								$week2 = unserialize($result_pgm_cycle['week2']);
								foreach($week2 as $key=> $value)
								{
									$day = $key + 1;
									$dateArr = $this->getDateForSpecificDayBetweenDates($start_week,$end_week,$day);
									foreach($dateArr as $val)
									{
										$sql_pgm_exp = $this->conn->query("select id from program_cycle_exception where exception_date = '".$val."' and program_year_id = '".$result_pgm_cycle['program_year_id']."'");
										if(mysqli_num_rows($sql_pgm_exp) == 0)
										{
											$final_pgms[$result_pgm_cycle['program_year_id']][$result_pgm_cycle['id']][$val] = $value;
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
				//print"<pre>";print_r($final_pgms);die;
				$sql_pgm_add_date = $this->conn->query("select additional_date,actual_timeslot_id from program_cycle_additional_day_time where additional_date between  '".$result_pgm_cycle['start_week']."' and '".$result_pgm_cycle['end_week']."' and program_year_id = '".$result_pgm_cycle['program_year_id']."'");
				while($result_pgm_add_date = mysqli_fetch_array($sql_pgm_add_date))
				{
					$ts_array = explode(",",$result_pgm_add_date['actual_timeslot_id']);
					if(array_key_exists($result_pgm_add_date['additional_date'],$final_pgms[$result_pgm_cycle['program_year_id']][$result_pgm_cycle['id']]))
					{
						$new_arr = array_unique(array_merge($final_pgms[$result_pgm_cycle['program_year_id']][$result_pgm_cycle['id']][$result_pgm_add_date['additional_date']],$ts_array));		
						$final_pgms[$result_pgm_cycle['program_year_id']][$result_pgm_cycle['id']][$result_pgm_add_date['additional_date']] = $new_arr;
					}else{
						$final_pgms[$result_pgm_cycle['program_year_id']][$result_pgm_cycle['id']][$result_pgm_add_date['additional_date']] = $ts_array;
					}
				}	
			}					
		}		
		return $final_pgms;
	}

	//function will check the number of weeks between two dates
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

	//function will get all the dates of a specific day in the given timerange
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
			$date = new DateTime(date('Y-m-d', $startDate));
			$date->modify('+7 day');
			$startDate = $date->format('Y-m-d');
			$startDate = strtotime($startDate);
		}
		return($dateArr);
	}

	public function deleteData()
	{
		$sql_delete_tt = $this->conn->query("TRUNCATE TABLE timetable");
		$sql_delete = $this->conn->query("TRUNCATE TABLE timetable_detail");
		$sql_delete_cal = $this->conn->query("TRUNCATE TABLE webcal_entry");
		$sql_delete_cal_user = $this->conn->query("TRUNCATE TABLE webcal_entry_user");
		return 1;
	}

	//function to check the timetable name,if it already exists in database
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

	//function to check if there is a holiday on a particular date
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

	//function to get room name by id
	public function getRoomName($room_id)
	{
		$sql_room_name = $this->conn->query("select room_name from room where id = '".$room_id."'");
		$rooms = mysqli_fetch_array($sql_room_name);
		return $rooms['room_name'];
	}

	//function to get room of a subject within a week range
	public function getRoomBySubject($subject_id,$date)
	{
		
		$sql_select = $this->conn->query("select id,room_id,act_date from teacher_activity where subject_id = '".$subject_id."' and reserved_flag = 1");
		$row_cnt = mysqli_num_rows($sql_select);
		if($row_cnt > 0)
		{
			while($rooms = mysqli_fetch_array($sql_select))
			{
				$timestamp = strtotime($rooms['act_date']);
				$startDateOfWeek = (date("D", $timestamp) == 'Mon') ? date('Y-m-d', $timestamp) : date('Y-m-d', strtotime('Last Monday', $timestamp));
				$endDateOfWeek = (date("D", $timestamp) == 'Sun') ? date('Y-m-d', $timestamp) : date('Y-m-d', strtotime('Next Sunday', $timestamp));
				if($date >= $startDateOfWeek && $date <= $endDateOfWeek)
				{
					return $rooms['room_id'];
				}else{
					return 0;
				}
			}					
		}else{
			return 0;
		}
	}

	public function getLocation($room_id)
	{
		$sql_select = $this->conn->query("select location_id from building b inner join room r on r.building_id = b.id where r.id = '".$room_id."'");
		$result = mysqli_fetch_array($sql_select);
		return $result['location_id'];
	}

	//function to get all sessions with lesser order than the current one
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

	//function to get the timeslot value by id
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
	//function to list timetable
	public function getTimetablesData()
	{
		$tt_query="select * from timetable limit 1"; 
		$q_res = mysqli_query($this->conn, $tt_query);
		return $q_res;
	}		
}
