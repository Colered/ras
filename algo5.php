<?php
$link = mysql_connect('172.16.220.164', 'root', 'cidot@123');
if($link) {
   mysql_select_db('cidot_ras2' ,$link);
}
$days = array('0','1','2','3','4','5');
$start_week = '1';
$start_date = '2014-01-01';
$end_date = '2014-01-15';
$end_week = '3';
$from_time = '2014';
$start_final_day = '';
$end_final_day = '';
$flag = '0';
$number = 0;
$allocated_activities = '';
$reserved_array = array();
$result_array = array();
for($cnt = 1;$cnt<=3;$cnt++)
{
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
				$sql_slot = mysql_query("select id,timeslot_range from timeslot");
				while($result_slot = mysql_fetch_array($sql_slot))
				{
					$sql_pgm = mysql_query("SELECT distinct py.id as program_id
											FROM cycle c
											INNER JOIN program_years py ON py.id = c.program_year_id
											WHERE start_year = '".$from_time."'
											AND c.days LIKE '%".$shuffled_days."%'
											AND c.start_week >= '".$start_week."'
											AND c.end_week <= '".$end_week."'");
					while($result_pgm = mysql_fetch_array($sql_pgm))
					{
						$sql_reserv_act = mysql_query("select ta.id as activity_id,ta.name,ta.program_year_id,py.name as program_name, ta.subject_id,su.subject_name,ta.session_id,s.name as session_name,ta.teacher_id,t.teacher_name,ta.group_id,ta.room_id,r.room_name,s.order_no
						from teacher_activity ta
						inner join session s on s.id = ta.session_id
						inner join program_years py on py.id = ta.program_year_id
						inner join subject su on su.id = ta.subject_id
						inner join teacher t on t.id = ta.teacher_id
						inner join room r on r.id = ta.room_id
						where timeslot_id = '".$result_slot['id']."' and reserved_flag = 1 order by rand()");
						$res = 0;
						while($result_reserv_act = mysql_fetch_array($sql_reserv_act))
						{

							if($result_reserv_act['order_no'] > 0){
								$subject_order = $result_reserv_act['subject_id']."-".($result_reserv_act['order_no']-1);
							}else{
								$subject_order = $result_reserv_act['subject_id']."-".$result_reserv_act['order_no'];
							}
							if(!search_array($result_reserv_act['name'],$reserved_array))
							{

								if($result_reserv_act['order_no'] == 0)
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
									$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['order_no'] = $result_reserv_act['order_no'];
									$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_order'] = $result_reserv_act['subject_id']."-".$result_reserv_act['order_no'];
									$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['date'] = $class_date;
									$number++;
									$res++;
									break;
								}elseif(search_array($subject_order,$reserved_array))
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
									$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['order_no'] = $result_reserv_act['order_no'];
									$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_order'] = $result_reserv_act['subject_id']."-".$result_reserv_act['order_no'];
									$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['date'] = $class_date;
									$number++;
									$res++;
									break;
								}
							}
						}
						if($res == 0)
						{
							$teachers = search_teachers($w,$result_slot['timeslot_range'],$shuffled_days);

							foreach($teachers as $teacher)
							{
								$sql_free_act = mysql_query("select ta.id as activity_id,ta.name,ta.program_year_id,py.name as program_name, ta.subject_id, su.subject_name, ta.session_id,s.name as session_name,ta.teacher_id,t.teacher_name,ta.group_id,s.order_no
								from teacher_activity ta
								inner join session s on s.id = ta.session_id
								inner join program_years py on py.id = ta.program_year_id
								inner join subject su on su.id = ta.subject_id
								inner join teacher t on t.id = ta.teacher_id
								where teacher_id = ".$teacher." and reserved_flag = 0 order by rand()");
								$flag = 0;
								while($result_free_act = mysql_fetch_array($sql_free_act))
								{
									$i = 0;
									$rooms = search_room($w,$result_slot['timeslot_range'],$shuffled_days);
									if($result_free_act['order_no'] > 0){
										$subject_order = $result_free_act['subject_id']."-".($result_free_act['order_no']-1);
									}else{
										$subject_order = $result_free_act['subject_id']."-".$result_free_act['order_no'];
									}
									if(!search_array($result_free_act['name'],$reserved_array) && !search_array($result_free_act['subject_id']."-".$result_free_act['order_no'],$reserved_array))
									{
										if($result_free_act['order_no'] == 0)
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
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['order_no'] = $result_free_act['order_no'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_order'] =  $result_free_act['subject_id']."-".$result_free_act['order_no'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['date'] = $class_date;
											$number++;
											$flag = 1;
											break;
										}elseif(search_array($subject_order,$reserved_array)){
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
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['order_no'] = $result_free_act['order_no'];
											$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_order'] =  $result_free_act['subject_id']."-".$result_free_act['order_no'];
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
print"<pre>";print_r($output_array);

$sql_delete = mysql_query("DELETE FROM timetable_detail");
$sql_delete_cal = mysql_query("DELETE FROM webcal_entry");
$sql_delete_cal_user = mysql_query("DELETE FROM webcal_entry_user");

foreach($output_array as $key=>$value)
{
	$week = $key;
	foreach($value as $k=>$v)
	{
		$day = $k;
		foreach($v as $newkey=>$val)
		{
			$timeslot = $newkey;
			$tt_id = '1';
			$activity_id = $val['activity_id'];
			$program_year_id = $val['program_year_id'];
			$teacher_id = $val['teacher_id'];
			$group_id = $val['group_id'];
			$room_id = $val['room_id'];
			$session_id = $val['session_id'];
			$room_name = $val['room_name'];
			$name = $val['name'];
			$program_name = $val['program_name'];
			$subject_name = $val['subject_name'];
			$session_name = $val['session_name'];
			$teacher_name = $val['teacher_name'];
			$subject_id = $val['subject_id'];
			$description = $program_name."-".$subject_name."-".$session_name."-".$teacher_name;
			$date = $val['date'];
			$date_add = date("Y-m-d H:i:s");
			$date_upd = date("Y-m-d H:i:s");

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
	mysql_query($sql_insert);

	$ts_array = explode("-", $timeslot);
	$entry_hour = $ts_array['0'];
	if($entry_hour == '1')
		$entry_hour = 13;
	if($entry_hour == '2')
		$entry_hour = 14;

	$date_array = explode("-", $date);
	$year = $date_array['0'];
	$month = $date_array['1'];
	$day = $date_array['2'];
	$zone=3600*+5;//India
	$eventstart = gmmktime ( $entry_hour, 0, 0, $month, $day, $year );
	$cal_time = gmdate('His', $eventstart + $zone);


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
	mysql_query($sql_insert_cal);
	$cal_id = mysql_insert_id();


	$sql_insert_cal_user = "insert into webcal_entry_user set
				   cal_id = '".$cal_id."',
				   cal_login = 'admin',
				   cal_status = 'A'";
	mysql_query($sql_insert_cal_user);

		}
	}
}
function search_array($needle, $haystack)
{
     if(in_array($needle, $haystack)) {
          return true;
     }
     foreach($haystack as $element) {
          if(is_array($element) && search_array($needle, $element))
               return true;
     }
   return false;
}
function search_room($week,$slot,$shuffled_days)
{
	$sql_room = mysql_query("select room_id, room.room_name
							from classroom_availability
							inner join classroom_availability_days on classroom_availability_days.classroom_availability_id = classroom_availability.id
							inner join room on room.id = classroom_availability.room_id
							where weeks like '%".$week."%' and timeslots like '%".$slot."%' and days=".$shuffled_days);
	$k = 0;
	while($result_room = mysql_fetch_array($sql_room))
	{
		$rooms[$k]['id'] = $result_room['room_id'];
		$rooms[$k]['room_name'] = $result_room['room_name'];
		$k++;
	}

	return $rooms;
}
function search_teachers($week,$slot,$shuffled_days)
{
	$teachers = array();
	$newteachers = array();

	$sql_teachers = mysql_query("select teacher_id
							from teacher_availability
							inner join teacher_availability_days on teacher_availability_days.teacher_availability_id = teacher_availability.id
							where teacher_availability_days.weeks like '%".$week."%' and timeslots like '%".$slot."%' and day=".$shuffled_days);
	while($result_teachers = mysql_fetch_array($sql_teachers))
	{
		$sql = mysql_query("select teacher_id from exception where teacher_id = '".$result_teachers['teacher_id']."' and weeks like '%".$week."%' and days=".$shuffled_days)or die(mysql_error());
		$data = mysql_fetch_array($sql);
		if(empty($data))
		{
			$newteachers[] = $result_teachers['teacher_id'];
		}
	}
	return $newteachers;
}


?>