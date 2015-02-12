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
	public function getCycleId($date,$program_id)
	{
		$cyc_sql = "SELECT * FROM cycle WHERE program_year_id ='".$program_id."' and start_week <= '".$date."' and end_week >= '".$date."'";
		$q_res = mysqli_query($this->conn, $cyc_sql);
		$data = mysqli_fetch_array($q_res);
		if($data['no_of_cycle'] == 1)
		{
			$cycle_id = 1;
		}elseif($data['no_of_cycle'] == 2){
			$cyc_sql_no = "SELECT min(id) as min_id,max(id) as max_id FROM cycle WHERE program_year_id ='".$program_id."'";
			$q_res_no = mysqli_query($this->conn, $cyc_sql_no);
			$row = mysqli_fetch_array($q_res_no);
			if($data['id'] == $row['min_id'])
				$cycle_id = 1;
			else
				$cycle_id = 2;
		}elseif($data['no_of_cycle'] == 3){
			$cyc_sql_no = "SELECT min(id) as min_id,max(id) as max_id FROM cycle WHERE program_year_id ='".$program_id."'";
			$q_res_no = mysqli_query($this->conn, $cyc_sql_no);
			$row = mysqli_fetch_array($q_res_no);
			if($data['id'] == $row['min_id'])
				$cycle_id = 1;
			elseif($data['id'] == $row['max_id'])
				$cycle_id = 3;
			else
				$cycle_id = 2;
		}
		return $cycle_id;
	}
	public function getTeachersInRange($from,$to,$teacher_id='',$program_id='',$area_id='',$profesor_id='',$cycle_id='',$module=''){
		 $teacher_sql = "select t.id,td.date,td.timeslot,t.teacher_name,t.teacher_type,tt.teacher_type_name,py.id as program_id,py.name,p.company,u.name as unit,t.payrate,s.session_name,a.area_name,su.subject_name,s.case_number,s.technical_notes,r.room_name from timetable_detail td inner join teacher t on t.id = td.teacher_id inner join subject su on su.id = td.subject_id inner join program_years py on py.id = td.program_year_id inner join program p on p.id = py.program_id inner join unit u on u.id = p.unit inner join subject_session s on s.id = td.session_id inner join area a on a.id = su.area_id inner join room r on r.id = td.room_id left join teacher_type tt on tt.id = t.teacher_type where date between '".$from."' and '".$to."'";
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
		if($profesor_id != '')
		{
			$teacher_sql .= " and t.teacher_type = '".$profesor_id."'";
		}
		if($cycle_id != '')
		{
			$cyc_arr = explode(",",$cycle_id);
			$teacher_sql .= " and (";			
			for($i=0;$i<count($cyc_arr);$i++)
			{
				if($i == count($cyc_arr)-1)
				{
					$teacher_sql .= "td.cycle_id = '".$cyc_arr[$i]."'";
				}else{
					$teacher_sql .= "td.cycle_id = '".$cyc_arr[$i]."' || ";
				}
			}
			$teacher_sql .= ")";
		}
		if($module != '')
		{
			$teacher_sql .= " and p.unit = '".$module."'";
		}

		$teacher_sql .= " order by td.teacher_id";
		//echo $teacher_sql;die;
		$q_res = mysqli_query($this->conn, $teacher_sql);
		return $q_res;
	}
	public function getTeacherId($from,$to,$teacher_id='',$program_id='',$area_id='',$profesor_id='',$cycle_id='',$module=''){
		$teacher_sql = "select distinct teacher_id,count(session_id) as session_id,t.teacher_name,t.payrate from timetable_detail td inner join teacher t on t.id = td.teacher_id inner join subject su on su.id = td.subject_id inner join program_years py on py.id = td.program_year_id inner join program p on p.id = py.program_id inner join unit u on u.id = p.unit where date between '".$from."' and '".$to."'";
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
		if($profesor_id != '')
		{
			$teacher_sql .= " and t.teacher_type = '".$profesor_id."'";
		}
		if($cycle_id != '')
		{
			$cyc_arr = explode(",",$cycle_id);
			$teacher_sql .= " and (";			
			for($i=0;$i<count($cyc_arr);$i++)
			{
				if($i == count($cyc_arr)-1)
				{
					$teacher_sql .= "td.cycle_id = '".$cyc_arr[$i]."'";
				}else{
					$teacher_sql .= "td.cycle_id = '".$cyc_arr[$i]."' || ";
				}
			}
			$teacher_sql .= ")";
		}
		if($module != '')
		{
			$teacher_sql .= " and p.unit = '".$module."'";
		}
		$teacher_sql .= " group by td.teacher_id order by td.teacher_id";
		//echo $teacher_sql;die;
		$q_res = mysqli_query($this->conn, $teacher_sql);
		return $q_res;
	}
	public function getAllCycle()
	{
		 $row_program_ids=$array1=$array2=$array3=array();
		 $result=$this->conn->query("select DISTINCT program_year_id FROM  cycle");
		 $i=1;
		 while($data=$result->fetch_assoc()){
						$sql="SELECT * FROM cycle WHERE program_year_id ='".$data['program_year_id']."' GROUP BY id HAVING COUNT( * ) >=1 ORDER BY id ASC ";
						$cycle_ids=$this->conn->query($sql);
						$group="$"."group".$i;
						$group=array();
						while($data1=$cycle_ids->fetch_assoc()){
						   $group[]=$data1['id'];
						}
						$i++;
						$array1[]=(isset($group['0'])) ? ($group['0']) : '';
						$array2[]=(isset($group['1'])) ? ($group['1']) : '';
						$array3[]=(isset($group['2'])) ? ($group['2']) : '';
		 }
		 $strArray1=implode(",",$array1);
		 $strArray2=implode(",",$array2);
		 $strArray3=implode(",",$array3);
		 return array($strArray1,$strArray2,$strArray3);
     }

	 /**************************************Timetable related functions starts here**********************************************/

	//Main Function to generate the timetable
	public function generateTimetable($date, $end_date,$programs)
	{
		//function call to get maximum number of sessions of each area allowed for a day
		$program_session_area = $this->getProgramSessionCount($programs);
		//function call to search all programs with their dates and times, which occur in the timetable range
		$programs = $this->search_programs($date,$end_date,$programs);
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
		//print"<pre>";print_r($new_programs);die;

		$reserved_array = array();
		$reserved_teachers = array();
		$reserved_rooms = array();
		$teachers_count = array();
		$teachers_sat = array();
		$locations = array();
		$reserved_areas = array();
		$reserved_subject_rooms = array();
		$program_session_count = array();
		
		//function call to all reserved activities from the database
		$reserved_activities = $this->searchReservedActivities();
		//function call to get all the semi reserved activities from the database
		$semi_reserved_activities = $this->searchSemiReservedActivities();		
		//function call to get the list of holidays from the database
		$holidays = $this->checkHoliday();
		//prepare timeslot array in advance
		$allTimeslots = $this->getAllTimeslots();
						
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
					//check if the date is a holiday. If not proceed further
					if(!in_array($date,$holidays))
					{
						$end_time = '';	
						$sat_flag = 0;
						$f_day = $this->getDayFromDate($date);
						$reserved_timeslots = array();	
						//CHECK if the day has any reserved activities scheduled
						if(array_key_exists($date,$reserved_activities))
						{
							foreach($v as $start_id)
							{
								$timeslots = array();
								$timeslots[0] = $start_id;
								$start_time = $this->getTimeSlots($timeslots);
								$start_time = $start_time['0'];
								$start_time =  date('h:i A',strtotime($start_time));
								if(strtotime($start_time) >= strtotime($end_time))
								{								
									$end_time = date("h:i A", strtotime($start_time." + 15 minutes"));
									foreach($reserved_activities[$date] as $res_act_id => $res_act_detail)
									{
										if($res_act_detail['program_year_id'] == $program_id && $res_act_detail['cycle_id'] == $cycle_id && $res_act_detail['start_time'] == $start_id)
										{
											//Here will check if the activity is not already allocated then we will proceed with this activity
											if(!$this->search_array($res_act_detail['name'],$reserved_array)) 
											{
												$end_time = date("h:i A", strtotime($start_time." + ".$res_act_detail['duration']." minutes"));												
												$activities_array =$this->makeArray($date,$cycle_id,$res_act_detail['activity_id'],$res_act_detail['name'],$res_act_detail['program_year_id'],$res_act_detail['area_id'],$res_act_detail['program_name'],$res_act_detail['teacher_id'],$res_act_detail['teacher_name'],$res_act_detail['teacher_type'],$res_act_detail['room_id'],$res_act_detail['room_name'],$res_act_detail['session_id'],$res_act_detail['session_name'],$res_act_detail['subject_id'],$res_act_detail['subject_name'],$res_act_detail['order_number']);
												$reserved_array[$date][$i][$start_time." - ".$end_time] = $activities_array;
												$reserved_rooms[$date][$start_time." - ".$end_time][$i] = $res_act_detail['room_id'];
												$reserved_teachers[$date][$start_time." - ".$end_time][$i] = $res_act_detail['teacher_id'];
												$ts_array = explode(",",$res_act_detail['timeslot_id']);
												foreach($ts_array as $ts_id)
												{
													$reserved_timeslots[] = trim($ts_id);
												}
												
												if(array_key_exists($date,$teachers_count) && array_key_exists($res_act_detail['teacher_id'],$teachers_count[$date]))
												{
													$teachers_count[$date][$res_act_detail['teacher_id']] = $teachers_count[$date][$res_act_detail['teacher_id']] + 1;
												}else{
													$teachers_count[$date][$res_act_detail['teacher_id']] = 1;
												}
												if($f_day == 5 && $sat_flag == 0)
												{
													if(array_key_exists($cycle_id,$teachers_sat) && array_key_exists($res_act_detail['teacher_id'],$teachers_sat[$cycle_id]))
													{
													$teachers_sat[$cycle_id][$res_act_detail['teacher_id']] = $teachers_sat[$cycle_id][$res_act_detail['teacher_id']] + 1;
													}else{
														$teachers_sat[$cycle_id][$res_act_detail['teacher_id']] = 1;
													}													
													$sat_flag++;
												}
												if($f_day == 5 && $res_act_detail['forced_flag'] != '1')
												{
													$reserved_areas[$date][$program_id] = $res_act_detail['area_id'];
												}
												$locations[$date][$res_act_detail['teacher_id']] = $res_act_detail['location_id'];
												if(array_key_exists($date,$program_session_count) && array_key_exists($program_id,$program_session_count[$date]) && array_key_exists($res_act_detail['area_id'],$program_session_count[$date][$program_id]))
												{
													$program_session_count[$date][$program_id][$res_act_detail['area_id']] =  $program_session_count[$date][$program_id][$res_act_detail['area_id']] + 1;
												}else{
													$program_session_count[$date][$program_id][$res_act_detail['area_id']] = 1;
												}
												break;	
											}
										}
									}
								}
							}
						}
						//Calculate the unreserved timeslots for a date
						$total_timeslots = array();
						foreach($v as $start_id)
						{
							$total_timeslots[] = $start_id;
						}
						$unreserved_timeslots = array_diff($total_timeslots,$reserved_timeslots);
						$unreserved_times = $this->getTimeSlots($unreserved_timeslots);
						//process only if semi reserved activities exist and some unallocated timeslots left for day
						if(!empty($semi_reserved_activities) && !empty($unreserved_times))
						{
							//first will give the priority to those activities only which have a date
							if(array_key_exists($date,$semi_reserved_activities))
							{
								//process them
								$reserved_array = $this->processSemiReservedActivities($semi_reserved_activities,$program_id,$cycle_id,$program_session_count,$teachers_count,$teachers_sat,$reserved_areas,$allTimeslots,$reserved_teachers,$reserved_subject_rooms,$locations,$unreserved_timeslots,$unreserved_times,$program_session_area,$reserved_rooms,$f_day,$reserved_array,$i,$date,$date);
								$program_session_count = $reserved_array['1'];
								$teachers_count = $reserved_array['2'];
								$teachers_sat = $reserved_array['3'];
								$reserved_areas = $reserved_array['4'];
								$reserved_subject_rooms = $reserved_array['5'];
								$locations = $reserved_array['6'];
								$reserved_teachers = $reserved_array['7'];
								$reserved_rooms = $reserved_array['8'];
								$unreserved_timeslots = $reserved_array['9'];
								$unreserved_times = $reserved_array['10'];
								$reserved_array = $reserved_array['0'];							
							}
							//Here will process those activities without a date
							$reserved_array = $this->processSemiReservedActivities($semi_reserved_activities,$program_id,$cycle_id,$program_session_count,$teachers_count,$teachers_sat,$reserved_areas,$allTimeslots,$reserved_teachers,$reserved_subject_rooms,$locations,$unreserved_timeslots,$unreserved_times,$program_session_area,$reserved_rooms,$f_day,$reserved_array,$i,$date,'0000-00-00');
							$program_session_count = $reserved_array['1'];
							$teachers_count = $reserved_array['2'];
							$teachers_sat = $reserved_array['3'];
							$reserved_areas = $reserved_array['4'];
							$reserved_subject_rooms = $reserved_array['5'];
							$locations = $reserved_array['6'];
							$reserved_teachers = $reserved_array['7'];
							$reserved_rooms = $reserved_array['8'];
							$unreserved_timeslots = $reserved_array['9'];
							$unreserved_times = $reserved_array['10'];
							$reserved_array = $reserved_array['0'];	
						}
						//process free activities only if some unallocated timeslots left for day
						if(!empty($unreserved_times))
						{
							$free_activities = $this->searchFreeActivities($program_id, $cycle_id);
							foreach($unreserved_times as $un_tsid)
							{
								foreach($free_activities as $free_act_id => $free_act_detail)
								{
									//First we will check the count of Max No Sessions of Same Area during a Class day 
									if((array_key_exists($date,$program_session_count) && array_key_exists($program_id,$program_session_count[$date]) && array_key_exists($free_act_detail['area_id'],$program_session_count[$date][$program_id]) && $program_session_count[$date][$program_id][$free_act_detail['area_id']]<$program_session_area[$program_id][$f_day]) || !array_key_exists($date,$program_session_count) || !array_key_exists($program_id,$program_session_count[$date]) || !array_key_exists($free_act_detail['area_id'],$program_session_count[$date][$program_id]))
									{
										//Here will check a teacher can take maximum of 4 sessions per day
										if((array_key_exists($date,$teachers_count) && array_key_exists($free_act_detail['teacher_id'],$teachers_count[$date]) && $teachers_count[$date][$free_act_detail['teacher_id']] < 4) || !array_key_exists($date,$teachers_count) || !array_key_exists($free_act_detail['teacher_id'],$teachers_count[$date]))
										{
											//Here will check a teacher can have maximum of two saturdays working per cycle
											if(($f_day == 5 && array_key_exists($cycle_id,$teachers_sat) && array_key_exists($free_act_detail['teacher_id'],$teachers_sat[$cycle_id]) && ($teachers_sat[$cycle_id][$free_act_detail['teacher_id']] < 2 || $sat_flag > 0)) || $f_day != 5 || ($f_day == 5 && !array_key_exists($cycle_id,$teachers_sat)) || ($f_day == 5 && array_key_exists($cycle_id,$teachers_sat) && !array_key_exists($free_act_detail['teacher_id'],$teachers_sat[$cycle_id])))
											{
												//Here will check sessions from same area will be scheduled on saturday 
												if(($f_day == 5 && array_key_exists($date,$reserved_areas) && array_key_exists($program_id,$reserved_areas[$date]) && $reserved_areas[$date][$program_id] == $free_act_detail['area_id']) || $f_day != 5 || ($f_day == 5 && !array_key_exists($date,$reserved_areas)) || ($f_day == 5 && !array_key_exists($program_id,$reserved_areas[$date])))
												{
													//If activity is not already allocated ,session is not already taken and all the sessions with lesser order number have been taken, then we will allocate the activity
													if(!$this->search_array($free_act_detail['name'],$reserved_array) && !$this->search_array($free_act_detail['subject_id']."-".$free_act_detail['order_number'],$reserved_array))
													{
														$order_no_array = $this->getSubjectsWithLessOrder($free_act_detail['subject_id'],$free_act_detail['order_number']);
														$order_no_value = 0;
														foreach($order_no_array as $order_no)
														{
															if($this->search_array($free_act_detail['subject_id']."-".$order_no,$reserved_array))
															{
																$order_no_value++;
															}else{
																break;
															}
														}
														if($order_no_value == count($order_no_array))
														{
															$start_time = $un_tsid;
															$end_time = date("h:i A", strtotime($start_time." + ".$free_act_detail['duration']." minutes"));	
															$objT = new Teacher();
															$all_ts = $objT -> getTimeslotId($start_time."-".$end_time);
															$time = explode(",",$all_ts);						
															$ts_cnt = count(array_intersect($unreserved_timeslots, $time));
															if($ts_cnt == count($time))
															{
																//Here we will check if the teacher of the free activity is available at that time
																if($this->checkTeacherAvailability($free_act_detail['teacher_id'],$date,$all_ts) && (!$this->isTeacherReserved($date,$start_time,$end_time,$free_act_detail['teacher_id'],$reserved_teachers)))
																{
																	//Search for a room for this activity
																	$room_id = $this->searchRoom($free_act_detail['subject_id'],$date,$reserved_rooms,$all_ts,$start_time,$end_time);
																	//if room found,then proceed further, otherwise exit.
																	if($room_id >0)
																	{
																		//Here will check a teacher cannot have classes in different locations on same day
																		$loc_id = $this->getLocation($room_id);
																		if((array_key_exists($date,$locations) && array_key_exists($free_act_detail['teacher_id'],$locations[$date]) && $locations[$date][$free_act_detail['teacher_id']] == $loc_id) || !array_key_exists($date,$locations) || !array_key_exists($free_act_detail['teacher_id'],$locations[$date]))
																		{
																			//Append the reserved activity array here
																			$room_name = $this->getRoomName($room_id);
																			$activities_array =$this->makeArray($date,$cycle_id,$free_act_detail['activity_id'],$free_act_detail['name'],$free_act_detail['program_year_id'],$free_act_detail['area_id'],$free_act_detail['program_name'],$free_act_detail['teacher_id'],$free_act_detail['teacher_name'],$free_act_detail['teacher_type'],$room_id,$room_name,$free_act_detail['session_id'],$free_act_detail['session_name'],$free_act_detail['subject_id'],$free_act_detail['subject_name'],$free_act_detail['order_number']);
																			$reserved_array[$date][$i][$start_time." - ".$end_time] = $activities_array;
																			$reserved_teachers[$date][$start_time." - ".$end_time][$i] = $free_act_detail['teacher_id'];
																			$reserved_rooms[$date][$start_time." - ".$end_time][$i] = $room_id;
																			$reserved_subject_rooms[$date][$free_act_detail['subject_id']] = $room_id;
																			$unreserved_timeslots = array_diff($unreserved_timeslots,$time);
																			$unreserved_times = $this->getTimeSlots($unreserved_timeslots);	
																			if(array_key_exists($date,$teachers_count) && array_key_exists($free_act_detail['teacher_id'],$teachers_count[$date]))
																			{
																				$teachers_count[$date][$free_act_detail['teacher_id']] = $teachers_count[$date][$free_act_detail['teacher_id']] + 1;
																			}else{
																				$teachers_count[$date][$free_act_detail['teacher_id']] = 1;
																			}
																			
																			if($f_day == 5 && $sat_flag == 0)
																			{
																				if(array_key_exists($cycle_id,$teachers_sat) && array_key_exists($free_act_detail['teacher_id'],$teachers_sat[$cycle_id]))
																				{
																				$teachers_sat[$cycle_id][$free_act_detail['teacher_id']] = $teachers_sat[$cycle_id][$free_act_detail['teacher_id']] + 1;
																				}else{
																					$teachers_sat[$cycle_id][$free_act_detail['teacher_id']] = 1;
																				}														
																				$sat_flag++;
																			}
																			if($f_day == 5)
																			{
																				$reserved_areas[$date][$program_id] = $free_act_detail['area_id'];
																			}
																			$locations[$date][$free_act_detail['teacher_id']] = $loc_id;
																			if(array_key_exists($date,$program_session_count) && array_key_exists($program_id,$program_session_count[$date]) && array_key_exists($free_act_detail['area_id'],$program_session_count[$date][$program_id]))
																			{
																				$program_session_count[$date][$program_id][$free_act_detail['area_id']] =  $program_session_count[$date][$program_id][$free_act_detail['area_id']] + 1;
																			}else{
																				$program_session_count[$date][$program_id][$free_act_detail['area_id']] = 1;
																			}
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
						}
					}
				}
			}
			$i++;
		}//print"<pre>";print_r($reserved_array);die;	
		//If array is empty,means no activity has been allocated. We will show the message to user
		if(empty($reserved_array))
		{
			$err['system_error'] = 'System could not generate the timetable. Please check your data first';
			return $err;
		}			
		return $reserved_array;		
	}

	//Function to get all the programs, which lies in the duration of timetable generation period with their date and timeslot list
	public function search_programs($start_date,$end_date,$programs = array())
	{
		$final_pgms = array();
		$last_day = 5;
		$program_list = '';
		if(count($programs)>0)
		{
			$program_list.= " and(";
		}
		foreach($programs as $pgm)
		{
			$program_list.= " program_year_id = '".$pgm."' ||";

		}
		$program_list = substr($program_list, 0, -2);
		if(count($programs)>0)
		{
			$program_list.= ")";
		}
		$sql_pgm_cycle = $this->conn->query("SELECT * FROM cycle WHERE ((start_week >=  '".$start_date."' AND start_week <=  '".$end_date."') OR (start_week <=  '".$start_date."' AND end_week >=  '".$end_date."') OR ('".$start_date."' >=  start_week AND '".$start_date."' <=  end_week) OR  ('".$end_date."' >=  start_week AND '".$end_date."' <=  end_week))".$program_list."");
		$pgm_cycle_cnt = mysqli_num_rows($sql_pgm_cycle);
		if($pgm_cycle_cnt > 0)
		{
			while($result_pgm_cycle = mysqli_fetch_array($sql_pgm_cycle))
			{
				$i=0;
				//if end date and start date are beyond the cycle date range
				if($result_pgm_cycle['end_week'] > $end_date)
				{
					$end_week = $end_date;
					$end_week1 = $end_date;
				}else{
					$end_week = $result_pgm_cycle['end_week'];
					$end_week1 = $result_pgm_cycle['end_week'];
					}
				if($result_pgm_cycle['start_week'] < $start_date)
				{
					$start_week = $start_date;
					$start_week1 = $start_date;
				}else{
					$start_week = $result_pgm_cycle['start_week'];
					$start_week1 = $result_pgm_cycle['start_week'];
					}
				if($result_pgm_cycle['occurrence'] == '1w')
				{	
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
				}else if($result_pgm_cycle['occurrence'] == '2w'){
					$weeks = $this->countWeeksBetweenDates($start_week,$end_week);
					$week_cycles = $this->countWeeksBetweenDates($result_pgm_cycle['start_week'],$start_week);
					if($week_cycles%2 == 0)
					{
						$i++;
					}
					for($j=0; $j < $weeks; $j++)
					{						
						if($i%2 == 0)
						{
							$day = date("w", strtotime($start_week));
							$day = $day-1;
							$rem_days = $last_day-$day;
							$date = new DateTime($start_week);
							$date->modify('+'.$rem_days.' day');
							$end_week = $date->format('Y-m-d');
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
							$i++;
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
							$i++;
						}
					}								
				}
				$sql_pgm_add_date = $this->conn->query("select additional_date,actual_timeslot_id from program_cycle_additional_day_time where additional_date >= '".$start_week1."' and additional_date <= '".$end_week1."' and program_year_id = '".$result_pgm_cycle['program_year_id']."'");
				while($result_pgm_add_date = mysqli_fetch_array($sql_pgm_add_date))
				{
					$ts_array = explode(",",$result_pgm_add_date['actual_timeslot_id']);
					if(isset($final_pgms[$result_pgm_cycle['program_year_id']][$result_pgm_cycle['id']]))
					{
						if(array_key_exists($result_pgm_add_date['additional_date'],$final_pgms[$result_pgm_cycle['program_year_id']][$result_pgm_cycle['id']]))
						{
							$new_arr = array_unique(array_merge($final_pgms[$result_pgm_cycle['program_year_id']][$result_pgm_cycle['id']][$result_pgm_add_date['additional_date']],$ts_array));
							$sorted_array = array();
							foreach($new_arr as $new_key => $arr1)
							{
								$sorted_array[$new_key] = $arr1;							
							}
							array_multisort($sorted_array, SORT_ASC, $new_arr);	
							$final_pgms[$result_pgm_cycle['program_year_id']][$result_pgm_cycle['id']][$result_pgm_add_date['additional_date']] = $new_arr;											
						}else{
							$final_pgms[$result_pgm_cycle['program_year_id']][$result_pgm_cycle['id']][$result_pgm_add_date['additional_date']] = $ts_array;
						}
					}else{
						$final_pgms[$result_pgm_cycle['program_year_id']][$result_pgm_cycle['id']][$result_pgm_add_date['additional_date']] = $ts_array;
					}
				}	
			}					
		}
		return $final_pgms;
	}

	//Function to get session count of an area of each day set for each program
	public function getProgramSessionCount($programs)
	{
		$program_session_area = array();
		foreach($programs as $pgm_year_id)
		{
			$sql_max_session = $this->conn->query("select max_no_session,py.id as program_year_id from program p inner join program_years py on py.program_id = p.id where py.id = '".$pgm_year_id."'");
			while($data_max_session = mysqli_fetch_array($sql_max_session))
			{
				$data_session_array = explode("-",$data_max_session['max_no_session']);
				$program_session_area[$data_max_session['program_year_id']] = array('0'=>$data_session_array['0'],'1'=>$data_session_array['1'],'2'=>$data_session_array['2'],'3'=>$data_session_array['3'],'4'=>$data_session_array['4'],'5'=>$data_session_array['5']);
			}

		}
		return $program_session_area;
	}

	//Function to check if there is a holiday on a particular date
	public function checkHoliday()
	{
		$holiday_date = array();
		$objH =new Holidays();
		$holiday_data=$objH->viewHoliday();
		while($row_holiday = $holiday_data->fetch_assoc()){
			$holiday_date[] = $row_holiday['holiday_date'];
		}
		//print"<pre>";print_r($holiday_date);die;
		return $holiday_date;
	}
	
	//Function to get day from the date
	public function getDayFromDate($date)
	{
		$day = date('w', strtotime($date));
		$final_day = $day - 1;
		return $final_day;
	}

	//Function will check the number of weeks between two dates
	public function countWeeksBetweenDates($start_week, $end_week)
	{
		$weeks=$this->weeks($start_week,$end_week);
		$diff_weeks=count($weeks);
		return $diff_weeks;
	}
	public function weeks($ladate2,$ladate3) 
	{
		$start_week= date("W",strtotime($ladate2));
		$end_week= date("W",strtotime($ladate3));
		$number_of_weeks= $end_week - $start_week;
		$weeks=array();
		$weeks[]=$start_week;
		$increment_date=$ladate2;
		$i="1";
		if ($number_of_weeks<0){
			$start_year=date("Y",strtotime($ladate2));
			$last_week_of_year= date("W",strtotime("$start_year-12-28"));
			$number_of_weeks=($last_week_of_year-$start_week)+$end_week;
		}
		while ($i<=$number_of_weeks)
		{
			$increment_date=date("Y-m-d", strtotime($ladate2. " +$i week"));
			$weeks[]=date("W",strtotime($increment_date));

			$i=$i+1;
		}
		return $weeks;
	}

	//Function will get all the dates of a specific day in the given timerange
	public function getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber,$class_room_id='',$teacher_availablity_id='',$program_id='')
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
		
		    if($class_room_id!='' || $teacher_availablity_id!='' || $program_id!=''){
				$dateArr[] = date('Ymd', $startDate);
			}else{
				$dateArr[] = date('Y-m-d', $startDate);
			}
			//$dateArr[] = date('Y-m-d', $startDate);
			$date = new DateTime(date('Y-m-d', $startDate));
			$date->modify('+7 day');
			$startDate = $date->format('Y-m-d');
			$startDate = strtotime($startDate);
		}
		return($dateArr);
	}

	//Function to make final reserved array
	public function makeArray($date,$cycle_id,$activity_id,$name,$program_year_id,$area_id,$program_name,$teacher_id,$teacher_name,$teacher_type,$room_id,$room_name,$session_id,$session_name,$subject_id,$subject_name,$order_number)
	{
		$activities_array = array();
		$activities_array['activity_id'] = $activity_id;
		$activities_array['name'] =  $name;
		$activities_array['program_year_id'] = $program_year_id;
		$activities_array['area_id'] = $area_id;
		$activities_array['program_name'] = $program_name;	
		$activities_array['teacher_id'] = $teacher_id;
		$activities_array['teacher_name'] = $teacher_name;
		$activities_array['teacher_type'] = $teacher_type;
		$activities_array['room_id'] = $room_id;
		$activities_array['room_name'] = $room_name;
		$activities_array['session_id'] = $session_id;
		$activities_array['session_name'] = $session_name;
		$activities_array['subject_id'] = $subject_id;
		$activities_array['subject_name'] = $subject_name;
		$activities_array['subject_order'] = $subject_id."-".$order_number;
		$activities_array['date'] = $date;
		$activities_array['cycle_id'] = $cycle_id;
		return $activities_array;
	}

	//Function to search a value in an array recursively
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

	//Function to search reserved activities from the database
	public function searchReservedActivities()
	{
		$reserved_activities = array();
		$sql_reserv_act = $this->conn->query("select ta.id as activity_id,ta.name,ta.act_date,ta.program_year_id,ta.cycle_id,py.name as program_name, ta.subject_id,su.subject_name,su.area_id,ta.session_id,s.session_name as session_name,ta.teacher_id,t.teacher_name,t.teacher_type,ta.room_id,r.room_name,s.order_number,s.duration, ta.start_time,ta.timeslot_id, b.location_id, ta.forced_flag from teacher_activity ta 
		left join subject_session s on s.id = ta.session_id
		left join program_years py on py.id = ta.program_year_id
		left join subject su on su.id = ta.subject_id
		left join teacher t on t.id = ta.teacher_id
		left join room r on r.id = ta.room_id
		left join building b on r.building_id = b.id
		where reserved_flag = 1");
		while($result_reserv_act = mysqli_fetch_array($sql_reserv_act))
		{
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['activity_id'] = $result_reserv_act['activity_id'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['name'] = $result_reserv_act['name'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['program_year_id'] = $result_reserv_act['program_year_id'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['cycle_id'] = $result_reserv_act['cycle_id'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['program_name'] = $result_reserv_act['program_name'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['subject_id'] = $result_reserv_act['subject_id'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['subject_name'] = $result_reserv_act['subject_name'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['area_id'] = $result_reserv_act['area_id'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['session_id'] = $result_reserv_act['session_id'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['session_name'] = $result_reserv_act['session_name'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['start_time'] = $result_reserv_act['start_time'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['teacher_id'] = $result_reserv_act['teacher_id'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['teacher_name'] = $result_reserv_act['teacher_name'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['teacher_type'] = $result_reserv_act['teacher_type'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['room_id'] = $result_reserv_act['room_id'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['room_name'] = $result_reserv_act['room_name'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['order_number'] = $result_reserv_act['order_number'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['duration'] = $result_reserv_act['duration'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['timeslot_id'] = $result_reserv_act['timeslot_id'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['location_id'] = $result_reserv_act['location_id'];
			$reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['forced_flag'] = $result_reserv_act['forced_flag'];
		}
		return $reserved_activities;
	}

	//Function to search the semi reserved activities from the database
	public function searchSemiReservedActivities()
	{
		$semi_reserved_activities = array();
		$sql_reserv_act = $this->conn->query("select ta.id as activity_id,ta.name,ta.act_date,ta.program_year_id,ta.cycle_id,py.name as program_name, ta.subject_id,su.subject_name,su.area_id,ta.session_id,s.session_name as session_name,ta.teacher_id,t.teacher_name,t.teacher_type,ta.room_id,r.room_name,s.order_number,s.duration, ta.start_time,ta.timeslot_id, b.location_id, ta.forced_flag from teacher_activity ta 
		left join subject_session s on s.id = ta.session_id
		left join program_years py on py.id = ta.program_year_id
		left join subject su on su.id = ta.subject_id
		left join teacher t on t.id = ta.teacher_id
		left join room r on r.id = ta.room_id
		left join building b on r.building_id = b.id
		where reserved_flag = 2 order by s.order_number");
		while($result_reserv_act = mysqli_fetch_array($sql_reserv_act))
		{
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['activity_id'] = $result_reserv_act['activity_id'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['name'] = $result_reserv_act['name'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['program_year_id'] = $result_reserv_act['program_year_id'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['cycle_id'] = $result_reserv_act['cycle_id'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['program_name'] = $result_reserv_act['program_name'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['subject_id'] = $result_reserv_act['subject_id'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['subject_name'] = $result_reserv_act['subject_name'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['area_id'] = $result_reserv_act['area_id'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['session_id'] = $result_reserv_act['session_id'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['session_name'] = $result_reserv_act['session_name'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['start_time'] = $result_reserv_act['start_time'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['teacher_id'] = $result_reserv_act['teacher_id'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['teacher_name'] = $result_reserv_act['teacher_name'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['teacher_type'] = $result_reserv_act['teacher_type'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['room_id'] = $result_reserv_act['room_id'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['room_name'] = $result_reserv_act['room_name'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['order_number'] = $result_reserv_act['order_number'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['duration'] = $result_reserv_act['duration'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['timeslot_id'] = $result_reserv_act['timeslot_id'];
			$semi_reserved_activities[$result_reserv_act['act_date']][$result_reserv_act['activity_id']]['location_id'] = $result_reserv_act['location_id'];			
		}
		return $semi_reserved_activities;
	}

	//Function to search the free activities from the database
	public function searchFreeActivities($program_id,$cycle_id)
	{
		$free_activities = array();
		$sql_free_act = $this->conn->query("select ta.id as activity_id,ta.name,ta.program_year_id,py.name as program_name, ta.subject_id, su.subject_name,su.area_id, ta.session_id,ta.cycle_id,s.session_name as session_name,ta.teacher_id,t.teacher_name,t.teacher_type,s.order_number,s.duration 
							from teacher_activity ta 
							left join subject_session s on s.id = ta.session_id 
							left join program_years py on py.id = ta.program_year_id 
							left join subject su on su.id = ta.subject_id 
							left join teacher t on t.id = ta.teacher_id 
							where reserved_flag = 0 and ta.program_year_id = '".$program_id."' and ta.cycle_id = '".$cycle_id."' order by s.order_number,ta.id");
		while($result_free_act = mysqli_fetch_array($sql_free_act))
		{
			$free_activities[$result_free_act['activity_id']]['activity_id'] = $result_free_act['activity_id'];
			$free_activities[$result_free_act['activity_id']]['name'] = $result_free_act['name'];
			$free_activities[$result_free_act['activity_id']]['program_year_id'] = $result_free_act['program_year_id'];
			$free_activities[$result_free_act['activity_id']]['cycle_id'] = $result_free_act['cycle_id'];
			$free_activities[$result_free_act['activity_id']]['program_name'] = $result_free_act['program_name'];
			$free_activities[$result_free_act['activity_id']]['subject_id'] = $result_free_act['subject_id'];
			$free_activities[$result_free_act['activity_id']]['subject_name'] = $result_free_act['subject_name'];
			$free_activities[$result_free_act['activity_id']]['area_id'] = $result_free_act['area_id'];
			$free_activities[$result_free_act['activity_id']]['session_id'] = $result_free_act['session_id'];
			$free_activities[$result_free_act['activity_id']]['session_name'] = $result_free_act['session_name'];
			$free_activities[$result_free_act['activity_id']]['teacher_id'] = $result_free_act['teacher_id'];
			$free_activities[$result_free_act['activity_id']]['teacher_name'] = $result_free_act['teacher_name'];
			$free_activities[$result_free_act['activity_id']]['teacher_type'] = $result_free_act['teacher_type'];
			$free_activities[$result_free_act['activity_id']]['order_number'] = $result_free_act['order_number'];
			$free_activities[$result_free_act['activity_id']]['duration'] = $result_free_act['duration'];
		}
		return $free_activities;
	}

	//Function to process semi reserved activities
	public function processSemiReservedActivities($semi_reserved_activities,$program_id,$cycle_id,$program_session_count,$teachers_count,$teachers_sat,$reserved_areas,$allTimeslots,$reserved_teachers,$reserved_subject_rooms,$locations,$unreserved_timeslots,$unreserved_times,$program_session_area,$reserved_rooms,$f_day,$reserved_array,$i,$date,$semi_res_date)
	{
		foreach($semi_reserved_activities[$semi_res_date] as $semi_res_act_id=>$semi_res_act_detail)
		{
			if($semi_res_act_detail['program_year_id'] == $program_id && $semi_res_act_detail['cycle_id'] == $cycle_id)
			{
				if(($semi_res_date != '0000-00-00' && (($semi_res_act_detail['start_time'] == "" && $semi_res_act_detail['room_id'] == "0") || ($semi_res_act_detail['start_time'] != "" && $semi_res_act_detail['room_id'] == "0") || ($semi_res_act_detail['start_time'] == "" && $semi_res_act_detail['room_id'] != "0"))) || ($semi_res_date == '0000-00-00' && (($semi_res_act_detail['start_time'] != "" && $semi_res_act_detail['room_id'] != "0") || ($semi_res_act_detail['start_time'] != "" && $semi_res_act_detail['room_id'] == "0") || ($semi_res_act_detail['start_time'] == "" && $semi_res_act_detail['room_id'] != "0"))))
				{					
					//First we will check the count of Max No Sessions of Same Area during a Class day 
					if((array_key_exists($date,$program_session_count) && array_key_exists($program_id,$program_session_count[$date]) && array_key_exists($semi_res_act_detail['area_id'],$program_session_count[$date][$program_id]) && $program_session_count[$date][$program_id][$semi_res_act_detail['area_id']]<$program_session_area[$program_id][$f_day]) || !array_key_exists($date,$program_session_count) || !array_key_exists($program_id,$program_session_count[$date]) || !array_key_exists($semi_res_act_detail['area_id'],$program_session_count[$date][$program_id]))
					{						
						//Here will check a teacher can take maximum of 4 sessions per day
						if((array_key_exists($date,$teachers_count) && array_key_exists($semi_res_act_detail['teacher_id'],$teachers_count[$date]) && $teachers_count[$date][$semi_res_act_detail['teacher_id']] < 4) || !array_key_exists($date,$teachers_count) || !array_key_exists($semi_res_act_detail['teacher_id'],$teachers_count[$date]))
						{							
							//Here will check a teacher can have maximum of two saturdays working per cycle
							if(($f_day == 5 && array_key_exists($cycle_id,$teachers_sat) && array_key_exists($semi_res_act_detail['teacher_id'],$teachers_sat[$cycle_id]) && ($teachers_sat[$cycle_id][$semi_res_act_detail['teacher_id']] < 2 || $sat_flag > 0)) || $f_day != 5 || ($f_day == 5 && !array_key_exists($cycle_id,$teachers_sat)) || ($f_day == 5 && array_key_exists($cycle_id,$teachers_sat) && !array_key_exists($semi_res_act_detail['teacher_id'],$teachers_sat[$cycle_id])))
							{
								//Here will check sessions from same area will be scheduled on saturday 
								if(($f_day == 5 && array_key_exists($date,$reserved_areas) && array_key_exists($program_id,$reserved_areas[$date]) && $reserved_areas[$date][$program_id] == $semi_res_act_detail['area_id']) || $f_day != 5 || ($f_day == 5 && !array_key_exists($date,$reserved_areas)) || ($f_day == 5 && !array_key_exists($program_id,$reserved_areas[$date])))
								{									
									//If activity is not already allocated ,session is not already taken and all the sessions with lesser order number have been taken, then we will allocate the activity
									if(!$this->search_array($semi_res_act_detail['name'],$reserved_array) && !$this->search_array($semi_res_act_detail['subject_id']."-".$semi_res_act_detail['order_number'],$reserved_array))
									{
										$order_no_array = $this->getSubjectsWithLessOrder($semi_res_act_detail['subject_id'],$semi_res_act_detail['order_number']);
										$order_no_value = 0;
										foreach($order_no_array as $order_no)
										{
											if($this->search_array($semi_res_act_detail['subject_id']."-".$order_no,$reserved_array))
											{
												$order_no_value++;
											}else{
												break;
											}
										}										
										if($order_no_value == count($order_no_array))
										{
											//If start time is given use it otherwise use the unallocated timeslots of a day
											if($semi_res_act_detail['start_time'] != "")
											{
												$start_time = $allTimeslots[$semi_res_act_detail['start_time']]['start_time'];
												$end_time = date("h:i A", strtotime($start_time." + ".$semi_res_act_detail['duration']." minutes"));
												//Here we will check if the teacher of the free activity is available at that time
												if($this->checkTeacherAvailability($semi_res_act_detail['teacher_id'],$date,$semi_res_act_detail['timeslot_id']) && !$this->isTeacherReserved($date,$start_time,$end_time,$semi_res_act_detail['teacher_id'],$reserved_teachers))
												{												
													if($semi_res_act_detail['room_id'] != "0")
													{
														$edit_room_id = $semi_res_act_detail['room_id'];
													}else{
														$edit_room_id = '';
													}													
													//If room is available,then proceed further otherwise exit
													$room_id = $this->searchRoom($semi_res_act_detail['subject_id'],$date,$reserved_rooms,$semi_res_act_detail['timeslot_id'],$start_time,$end_time,$edit_room_id);
													if($room_id > 0)
													{
														$loc_id = $this->getLocation($room_id);	
														//Here will check a teacher cannot have classes in different locations on same day
														if((array_key_exists($date,$locations) && array_key_exists($semi_res_act_detail['teacher_id'],$locations[$date]) && $locations[$date][$semi_res_act_detail['teacher_id']] == $loc_id) || !array_key_exists($date,$locations) || !array_key_exists($semi_res_act_detail['teacher_id'],$locations[$date]))
														{
															//Append the reserved array
															$room_name = $this->getRoomName($room_id);
															$times_array = explode(",",$semi_res_act_detail['timeslot_id']);
															$activities_array =$this->makeArray($date,$cycle_id,$semi_res_act_detail['activity_id'],$semi_res_act_detail['name'],$semi_res_act_detail['program_year_id'],$semi_res_act_detail['area_id'],$semi_res_act_detail['program_name'],$semi_res_act_detail['teacher_id'],$semi_res_act_detail['teacher_name'],$semi_res_act_detail['teacher_type'],$room_id,$room_name,$semi_res_act_detail['session_id'],$semi_res_act_detail['session_name'],$semi_res_act_detail['subject_id'],$semi_res_act_detail['subject_name'],$semi_res_act_detail['order_number']);
															$reserved_array[$date][$i][$start_time." - ".$end_time] = $activities_array;
															$reserved_teachers[$date][$start_time." - ".$end_time][$i] = $semi_res_act_detail['teacher_id'];
															$reserved_rooms[$date][$start_time." - ".$end_time][$i] = $room_id;
															$reserved_subject_rooms[$date][$semi_res_act_detail['subject_id']] = $room_id;
															$unreserved_timeslots = array_diff($unreserved_timeslots,$times_array);
															$unreserved_times = $this->getTimeSlots($unreserved_timeslots);	

															if(array_key_exists($date,$teachers_count) && array_key_exists($semi_res_act_detail['teacher_id'],$teachers_count[$date]))
															{
																$teachers_count[$date][$semi_res_act_detail['teacher_id']] = $teachers_count[$date][$semi_res_act_detail['teacher_id']] + 1;
															}else{
																$teachers_count[$date][$semi_res_act_detail['teacher_id']] = 1;
															}																	
															if($f_day == 5 && $sat_flag == 0)
															{
																if(array_key_exists($cycle_id,$teachers_sat) && array_key_exists($semi_res_act_detail['teacher_id'],$teachers_sat[$cycle_id]))
																{
																	$teachers_sat[$cycle_id][$semi_res_act_detail['teacher_id']] = $teachers_sat[$cycle_id][$semi_res_act_detail['teacher_id']] + 1;
																}else{
																	$teachers_sat[$cycle_id][$semi_res_act_detail['teacher_id']] = 1;
																}														
																$sat_flag++;
															}
															if($f_day == 5)
															{
																$reserved_areas[$date][$program_id] = $semi_res_act_detail['area_id'];
															}
															$locations[$date][$semi_res_act_detail['teacher_id']] = $loc_id;
															if(array_key_exists($date,$program_session_count) && array_key_exists($program_id,$program_session_count[$date]) && array_key_exists($semi_res_act_detail['area_id'],$program_session_count[$date][$program_id]))
															{
																$program_session_count[$date][$program_id][$semi_res_act_detail['area_id']] =  $program_session_count[$date][$program_id][$semi_res_act_detail['area_id']] + 1;
															}else{
																$program_session_count[$date][$program_id][$semi_res_act_detail['area_id']] = 1;
															}															
														}
													}
												}
											}else
											{											
												foreach($unreserved_times as $timeslot_id)
												{
													$start_time = $timeslot_id;
													$end_time = date("h:i A", strtotime($start_time." + ".$semi_res_act_detail['duration']." minutes"));	
													$objT = new Teacher();
													$all_ts = $objT -> getTimeslotId($start_time."-".$end_time);
													$time = explode(",",$all_ts);						
													$ts_cnt = count(array_intersect($unreserved_timeslots, $time));					
													if($ts_cnt == count($time))
													{
														//Here we will check if the teacher of the free activity is available at that time
														if($this->checkTeacherAvailability($semi_res_act_detail['teacher_id'],$date,$all_ts) && !$this->isTeacherReserved($date,$start_time,$end_time,$semi_res_act_detail['teacher_id'],$reserved_teachers))
														{
															if($semi_res_act_detail['room_id'] != "0")
															{
																$edit_room_id = $semi_res_act_detail['room_id'];
															}else{
																$edit_room_id = '';
															}
															//If room is available,then proceed further otherwise exit
															$room_id = $this->searchRoom($semi_res_act_detail['subject_id'],$date,$reserved_rooms,$all_ts,$start_time,$end_time,$edit_room_id);
															if($room_id > 0)
															{
																$loc_id = $this->getLocation($room_id);	
																//Here will check a teacher cannot have classes in different locations on same day
																if((array_key_exists($date,$locations) && array_key_exists($semi_res_act_detail['teacher_id'],$locations[$date]) && $locations[$date][$semi_res_act_detail['teacher_id']] == $loc_id) || !array_key_exists($date,$locations) || !array_key_exists($semi_res_act_detail['teacher_id'],$locations[$date]))
																{
																	//Append the reserved array
																	$room_name = $this->getRoomName($room_id);
																	$activities_array =$this->makeArray($date,$cycle_id,$semi_res_act_detail['activity_id'],$semi_res_act_detail['name'],$semi_res_act_detail['program_year_id'],$semi_res_act_detail['area_id'],$semi_res_act_detail['program_name'],$semi_res_act_detail['teacher_id'],$semi_res_act_detail['teacher_name'],$semi_res_act_detail['teacher_type'],$room_id,$room_name,$semi_res_act_detail['session_id'],$semi_res_act_detail['session_name'],$semi_res_act_detail['subject_id'],$semi_res_act_detail['subject_name'],$semi_res_act_detail['order_number']);
																	$reserved_array[$date][$i][$start_time." - ".$end_time] = $activities_array;
																	$reserved_teachers[$date][$start_time." - ".$end_time][$i] = $semi_res_act_detail['teacher_id'];
																	$reserved_rooms[$date][$start_time." - ".$end_time][$i] = $room_id;
																	$reserved_subject_rooms[$date][$semi_res_act_detail['subject_id']] = $room_id;
																	$unreserved_timeslots = array_diff($unreserved_timeslots,$time);
																	$unreserved_times = $this->getTimeSlots($unreserved_timeslots);	

																	if(array_key_exists($date,$teachers_count) && array_key_exists($semi_res_act_detail['teacher_id'],$teachers_count[$date]))
																	{
																		$teachers_count[$date][$semi_res_act_detail['teacher_id']] = $teachers_count[$date][$semi_res_act_detail['teacher_id']] + 1;
																	}else{
																		$teachers_count[$date][$semi_res_act_detail['teacher_id']] = 1;
																	}																
																	if($f_day == 5 && $sat_flag == 0)
																	{
																		if(array_key_exists($cycle_id,$teachers_sat) && array_key_exists($semi_res_act_detail['teacher_id'],$teachers_sat[$cycle_id]))
																		{
																			$teachers_sat[$cycle_id][$semi_res_act_detail['teacher_id']] = $teachers_sat[$cycle_id][$semi_res_act_detail['teacher_id']] + 1;
																		}else{
																			$teachers_sat[$cycle_id][$semi_res_act_detail['teacher_id']] = 1;
																		}														
																		$sat_flag++;
																	}
																	if($f_day == 5)
																	{
																		$reserved_areas[$date][$program_id] = $semi_res_act_detail['area_id'];
																	}
																	$locations[$date][$semi_res_act_detail['teacher_id']] = $loc_id;
																	if(array_key_exists($date,$program_session_count) && array_key_exists($program_id,$program_session_count[$date]) && array_key_exists($semi_res_act_detail['area_id'],$program_session_count[$date][$program_id]))
																	{
																		$program_session_count[$date][$program_id][$semi_res_act_detail['area_id']] =  $program_session_count[$date][$program_id][$semi_res_act_detail['area_id']] + 1;
																	}else{
																		$program_session_count[$date][$program_id][$semi_res_act_detail['area_id']] = 1;
																	}
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
				}
			}			
		}
		return array($reserved_array,$program_session_count,$teachers_count,$teachers_sat,$reserved_areas,$reserved_subject_rooms,$locations,$reserved_teachers,$reserved_rooms,$unreserved_timeslots,$unreserved_times);
	}
	
	//Function to get all timeslots from the database
	public function getAllTimeslots()
	{
		$allTimeslots = array();
		$sql_timeslot = $this->conn->query("select id,start_time,end_time from timeslot");
		while($result_timeslot = mysqli_fetch_array($sql_timeslot))
		{
			$allTimeslots[$result_timeslot['id']]['start_time'] = $result_timeslot['start_time'];
			$allTimeslots[$result_timeslot['id']]['end_time'] = $result_timeslot['end_time'];
		}
		return $allTimeslots;
	}

	//Function to get the timeslot value by id
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

	//Function to check teacher availability at a particular date, day and timeslots
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
								where start_date <= '".$date."' and end_date >= '".$date."' and day= '".$final_day."' and tm.teacher_id='".$teacher_id."' and actual_timeslot_id REGEXP '" . $this->RexExpFormat($tsIdsAll)."'");
			if(mysqli_num_rows($teachAvail_query) > 0)
			{
				return 1;
			}			
		}
	}

	//Function to check if the teacher is not allocated to any other activity at the same date and same time
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
	
	//Function to replace commas for db query
	public function RexExpFormat($str)
	{
	  $TempStr="";
	  $TempStr=$TempStr."[[:<:]]".$str."[[:>:]]";	  
	  return $TempStr;
	}

	//Function to search a room for semi reserved or free activity
	public function searchRoom($subject_id,$date,$reserved_rooms,$all_ts,$start_time,$end_time,$edit_room_id='')
	{
		$final_room_id = '';
		if($edit_room_id != '')
		{
			//This will check if any room is used by reserved activity of same subject in same week
			$room_id = $this->getRoomBySubject($subject_id,$date);
			if($room_id == '0')
			{
				//This will check if any room is used by already allocated free activity of same subject in same week
				$room_res_id = $this->getRoomFromReservedAct($subject_id,$date,$reserved_rooms);
				if($room_res_id == '0')
				{
					//check availability of a room
					if($this->checkRoomAvailability($edit_room_id,$date,$all_ts) && !$this->isRoomReserved($date,$start_time,$end_time,$edit_room_id,$reserved_rooms))
					{
						$final_room_id = $edit_room_id;
					}else{
						$final_room_id = 0;
					}
				}else{
					if($room_res_id != $edit_room_id)
						$final_room_id = 0;
					else
						$final_room_id = $edit_room_id;
				}
			}else{
				if($room_id != $edit_room_id)
					$final_room_id = 0;
				else
					$final_room_id = $edit_room_id;

			}
		}else
		{
			$room_id = $this->getRoomBySubject($subject_id,$date);
			if($room_id == '0')
			{
				$room_res_id = $this->getRoomFromReservedAct($subject_id,$date,$reserved_rooms);
				if($room_res_id == '0')
				{
					$rooms = $this->search_room($date,$all_ts);
					$temp_room_id = '';
					foreach($rooms as $room)
					{
						if(!$this->isRoomReserved($date,$start_time,$end_time,$room['id'],$reserved_rooms))
						{
							$temp_room_id = $room['id'];
							break;
						}
					}
					if($temp_room_id != '')
						$final_room_id = $temp_room_id;
						else
						$final_room_id = 0;
				}else{
					if($this->checkRoomAvailability($room_res_id,$date,$all_ts) && !$this->isRoomReserved($date,$start_time,$end_time,$room_res_id,$reserved_rooms))
					{
						$final_room_id = $room_res_id;
					}else{
						$final_room_id = 0;
					}
				}
			}else{
				if($this->checkRoomAvailability($room_id,$date,$all_ts) && !$this->isRoomReserved($date,$start_time,$end_time,$room_id,$reserved_rooms))
				{
					$final_room_id = $room_id;
				}else{
					$final_room_id = 0;
				}
			}			
		}
		return $final_room_id;
	}

	//Function to get room of a subject used by reserved activity within a week range
	public function getRoomBySubject($subject_id,$date)
	{
		$room_id_res = '';
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
					$room_id_res = $rooms['room_id'];
					break;
				}
			}
			if($room_id_res != '')
				return $room_id_res;
			else
				return 0;
		}else{
			return 0;
		}
	}
	
	//Function to check if any room is used by already allocated free activity of same subject in same week
	public function getRoomFromReservedAct($subject_id,$date,$reserved_rooms = array())
	{
		$rid = '';
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
					break;
				}
			}
		}
		if($rid != '')
				return $rid;
			else
				return 0;
	}	
	
	//Function to search room on a particular date and timeslot
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
								where start_date <= '".$date."' and end_date >= '".$date."' and day= '".$final_day."' and actual_timeslot_id REGEXP '" . $this->RexExpFormat($slot)."'");
								
							
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

	//Function to check room availability at a particular date, day and timeslots
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
							where start_date <= '".$date."' and end_date >= '".$date."' and day= '".$final_day."' and cm.room_id='".$room_id."' and actual_timeslot_id REGEXP '" . $this->RexExpFormat($tsIdsAll)."'");
			if(mysqli_num_rows($classroomAvail_query) > 0)
			{
				return 1;
			}
		}
	}

	//Function to check if the room is not allocated to any other activity at the same date and same time
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

	//Function to get room name by id
	public function getRoomName($room_id)
	{
		$sql_room_name = $this->conn->query("select room_name from room where id = '".$room_id."'");
		$rooms = mysqli_fetch_array($sql_room_name);
		return $rooms['room_name'];
	}
	
	//Function to get the location from a room
	public function getLocation($room_id)
	{
		$sql_select = $this->conn->query("select location_id from building b inner join room r on r.building_id = b.id where r.id = '".$room_id."'");
		$result = mysqli_fetch_array($sql_select);
		return $result['location_id'];
	}

	//Function to get all sessions with lesser order than the current one
	public function getSubjectsWithLessOrder($subject_id, $order_no)
	{
		//$order_no = array();
		$sql_select = $this->conn->query("select order_number FROM `subject_session` WHERE subject_id = '".$subject_id."' and order_number < '".$order_no."' order by order_number desc limit 1");
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
	
	//Cleans the timetable related tables
	public function deleteData()
	{
		$sql_delete_tt = $this->conn->query("TRUNCATE TABLE timetable");
		$sql_delete = $this->conn->query("TRUNCATE TABLE timetable_detail");
		$sql_delete_cal = $this->conn->query("TRUNCATE TABLE webcal_entry");
		$sql_delete_cal_user = $this->conn->query("TRUNCATE TABLE webcal_entry_user");
		return 1;
	}

	//Function to check the timetable name,if it already exists in database
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

	//Function to add the timetable basic details in database
	public function addTimetable($name, $start_date, $end_date,$program_list)
	{
		$sql_insert = "insert into timetable set
						   timetable_name = '".$name."',
						   start_date = '".$start_date."',
						   end_date = '".$end_date."',
						   programs = '".$program_list."',
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

	//Function to add the full timetable details in database
	public function addTimetableDetail($timeslot, $tt_id, $activity_id, $program_year_id, $teacher_id, $room_id, $session_id, $subject_id, $date, $date_add, $date_upd,$cycle_id)
	{
		$sql_insert = "insert into timetable_detail set
									   tt_id = '".$tt_id."',
									   activity_id = '".$activity_id."',
									   program_year_id = '".$program_year_id."',
									   teacher_id = '".$teacher_id."',
									   room_id = '".$room_id."',
									   subject_id = '".$subject_id."',
									   session_id = '".$session_id."',
									   date = '".date('Ymd', strtotime($date))."',
									   timeslot = '".$timeslot."',
									   date_add = '".$date_add."',
									   date_upd = '".$date_upd."',
									   cycle_id = '".$cycle_id."'";
		if($this->conn->query($sql_insert))
		{
			 return 1;
		}else{
			return 0;
		}
	}

	//Function to add the activities in calendar table so that they show up in calendar
	public function addWebCalEntry($date, $cal_time, $name, $room_name, $description, $duration, $teacher_id, $subject_id, $room_id, $program_year_id,$cycle_id,$area_id,$teacher_type)
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
									   program_year_id = '".$program_year_id."',
									   teacher_type_id = '".$teacher_type."',
									   cycle_id = '".$cycle_id."',
									   area_id = '".$area_id."'";				   
		if($this->conn->query($sql_insert_cal))
		{
			 $last_ins_id = $this->conn->insert_id;
			 return $last_ins_id;
		}else{
			return 0;
		}
	}

	//Function to add the activities in calendar table so that they show up in calendar
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
	
	/**************************************Timetable related functions ends here**********************************************/

	//Below functions are used by activity list page to show different colors for the activities
	//function to list timetable
	public function getTimetablesData()
	{
		$tt_query="select * from timetable limit 1"; 
		$q_res = mysqli_query($this->conn, $tt_query);
		return $q_res;
	}
	public function checkTimetable()
	{
		$tt_query="select * from timetable_detail"; 
		$q_res = mysqli_query($this->conn, $tt_query);
		return $q_res;
	}
	public function getLowestActDetail()
	{
		$tt_query="select * from timetable_detail where id='1'"; 
		$q_res = mysqli_query($this->conn, $tt_query);
		return $q_res;
	}
	public function getLowestTeachAct($activity_id)
	{
		$tt_query="select * from teacher_activity where id='".$activity_id."'"; 
		$q_res = mysqli_query($this->conn, $tt_query);
		return $q_res;
	}	
	public function updateTeachAct($activity_id,$room_id,$date,$timeslot_id,$start_time,$date_update)
	{
		$sql_upd = "update teacher_activity set room_id = '".$room_id."',
												timeslot_id = '".$timeslot_id."',
												start_time = '".$start_time."',
												act_date = '".$date."',
												reserved_flag = '1',
												date_update = '".$date_update."'
												where id = '".$activity_id."'";
		$q_res = mysqli_query($this->conn, $sql_upd);
	}	
}
