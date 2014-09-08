<?php
$link = mysql_connect('localhost', 'root', '');
if($link) {
   mysql_select_db('cidot_ras' ,$link);
}
$flag = '';
$days = array('0','1','2','3','4','5');
$counter = array();
$cnt=0;
$daycnt=0;
$start_week = '1';
$end_week = '3';
$from_time = '2014';
$reserved_array = array();
For($w = $start_week; $w<=$end_week;$w++)
{
	foreach($days as $shuffled_days)
	{
		$sql_slot = mysql_query("select id,timeslot_range from timeslot");
		while($result_slot = mysql_fetch_array($sql_slot))
		{
			$sql_pgm = mysql_query("SELECT distinct program_id
									FROM cycle c
									INNER JOIN program_years py ON py.id = c.program_year_id
									WHERE start_year = '".$from_time."'
									AND c.days LIKE '%".$shuffled_days."%'
									AND c.start_week >= '".$start_week."'
									AND c.end_week <= '".$end_week."'");			
			while($result_pgm = mysql_fetch_array($sql_pgm))
			{			
				$subjects = get_subjects($result_pgm['program_id']);
				$sessions = get_sessions($result_pgm['program_id']);
				$sql_reserv_act = mysql_query("select ta.name,program_id,ta.subject_id,session_id,teacher_id,group_id,room_id,s.order_no
				from teacher_activity ta
				inner join session s on s.id = ta.session_id
				where timeslot_id = ".$result_slot['id']." and reserved_flag = 1");
				//$num_rows = mysql_num_rows($sql_reserv_act);				
				while($result_reserv_act = mysql_fetch_array($sql_reserv_act))
				{
					if($result_reserv_act['order_no'] > 0){
						$subject_order = $result_reserv_act['subject_id']."-".($result_reserv_act['order_no']-1);
					}else{
						$subject_order = $result_reserv_act['subject_id']."-".$result_reserv_act['order_no'];
					}
					if((!search_array($result_reserv_act['name'],$reserved_array) && $result_reserv_act['order_no'] == 0) || ($result_reserv_act['order_no'] >0 && search_array($subject_order,$reserved_array))) {	
						$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['name'] =  $result_reserv_act['name'];
						$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['program_id'] = $result_reserv_act['program_id'];
						$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['teacher_id'] = $result_reserv_act['teacher_id'];
						$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['group_id'] = $result_reserv_act['group_id'];
						$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['room_id'] = $result_reserv_act['room_id'];
						$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['session_id'] = $result_reserv_act['session_id'];
						$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_id'] = $result_reserv_act['subject_id'];
						$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['order_no'] = $result_reserv_act['order_no'];
						$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_order'] = $result_reserv_act['subject_id']."-".$result_reserv_act['order_no'];
						break;
					}else{
						
						$teachers = search_teachers($w,$result_slot['timeslot_range'],$shuffled_days);
						
						foreach($teachers as $teacher)
						{
							
							
							$sql_free_act = mysql_query("select ta.name,program_id,ta.subject_id,session_id,teacher_id,group_id,s.order_no from teacher_activity ta inner join session s on s.id = ta.session_id where teacher_id = ".$teacher." and reserved_flag = 0");
							$i = 0;
							
							while($result_free_act = mysql_fetch_array($sql_free_act))
							{
								
								$rooms = search_room($w,$result_slot['timeslot_range'],$shuffled_days); 
								
								if(!search_array($result_free_act['name'],$reserved_array)){
								
								$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['name'] =  $result_free_act['name'];
								$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['program_id'] = $result_free_act['program_id'];
								$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['teacher_id'] = $result_free_act['teacher_id'];
								$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['group_id'] = $result_free_act['group_id'];
								$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['room_id'] = $rooms[$i];
								$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['session_id'] = $result_free_act['session_id'];
								$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_id'] = $result_free_act['subject_id'];
								$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['order_no'] = $result_free_act['order_no'];	
								$reserved_array[$w][$shuffled_days][$result_slot['timeslot_range']]['subject_order'] = $result_free_act['subject_id']."-".$result_free_act['order_no'];
								
								break;
								}
								$i++;
								
							}
						}

					}

					
					
					}
				}
					
				
			
				
		}
	}
}
print"<pre>";print_r($reserved_array);	
	


function search_array($needle, $haystack) {
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
	$sql_room = mysql_query("select room_id 
							from classroom_availability
							inner join classroom_availability_days on classroom_availability_days.classroom_availability_id = classroom_availability.id
							where weeks like '%".$week."%' and timeslots like '%".$slot."%' and days=".$shuffled_days);
	while($result_room = mysql_fetch_array($sql_room))
	{
		$rooms[] = $result_room['room_id'];
	}
	return $rooms;
}
function search_teachers($week,$slot,$shuffled_days)
{
	
	$sql_teachers = mysql_query("select teacher_id 
							from teacher_availability
							inner join teacher_availability_days on teacher_availability_days.teacher_availability_id = teacher_availability.id
							where weeks like '%".$week."%' and timeslots like '%".$slot."%' and day=".$shuffled_days);
	while($result_teachers = mysql_fetch_array($sql_teachers))
	{
		$teachers[] = $result_teachers['teacher_id'];
	}
	return $teachers;
}
function get_subject_count($subject_id, $grp_id){
	$sql_subj_cnt = mysql_query("select count 
							from subject_weekly_count
							where subject_id = ".$subject_id." and group_id = ".$grp_id);
	$subject_cnt = mysql_fetch_array($sql_subj_cnt);
	return $subject_cnt;
}
function get_subjects($pgm_id){
	$sql_subjects = mysql_query("select id 
							from subject
							where program_id = '".$pgm_id."'");
	while($result_subjects = mysql_fetch_array($sql_subjects))
	{
		$subjects[] = $result_subjects['id'];
	}
	return $subjects;
}
function get_sessions($pgm_id){
	$sql_sessions = mysql_query("select session.id 
								from session
								inner join subject on subject.id = session.subject_id
								where subject.program_id = ".$pgm_id);
	while($result_sessions = mysql_fetch_array($sql_sessions))
	{
		$sessions[] = $result_sessions['id'];
	}
	return $sessions;
}

?>