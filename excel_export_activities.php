<?php
include('config.php');
$fromTmDuratn = $_POST['fromTmDuratn'];
$toTmDuratn = $_POST['toTmDuratn'];
$teacher_id = isset($_POST['teacher'])?$_POST['teacher']:'';
$program_id = isset($_POST['program'])?$_POST['program']:'';
$area_id = isset($_POST['area'])?$_POST['area']:'';
$profesor_id = isset($_POST['profesor'])?$_POST['profesor']:'';
$cycle_id = isset($_POST['cycle'])?$_POST['cycle']:'';
$module = isset($_POST['module'])?$_POST['module']:'';
$addSpecialAct = isset($_POST['addSpecialAct'])?$_POST['addSpecialAct']:'';

$teacher_sql = "select t.id,td.date,td.timeslot,t.teacher_name,t.teacher_type,tt.teacher_type_name,py.id as program_id,py.name,p.company,u.name as unit,t.payrate,s.session_name,a.area_name,su.subject_name,s.case_number,s.technical_notes, s.description,r.room_name, sam.special_activity_name , teaAct.reserved_flag, td.teacher_id
from timetable_detail td 
left join teacher t on t.id = td.teacher_id 
left join subject su on su.id = td.subject_id 
left join program_years py on py.id = td.program_year_id 
left join program p on p.id = py.program_id 
left join unit u on u.id = p.unit 
left join subject_session s on s.id = td.session_id 
left join area a on a.id = su.area_id 
left join room r on r.id = td.room_id 
left join teacher_type tt on tt.id = t.teacher_type
left join special_activity_mapping sam on sam.teacher_activity_id = td.activity_id
left join teacher_activity teaAct on teaAct.id = td.activity_id
 
where date between '".$fromTmDuratn."' and '".$toTmDuratn."'";
if($teacher_id != '')
{
	 $teacher_sql .= " and td.teacher_id = '".$teacher_id."'";
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
if($addSpecialAct == '')
{
	$teacher_sql .= " and teaAct.reserved_flag = 1";
}
$teacher_sql .= " order by td.teacher_id";
$q_res = mysqli_query($db,$teacher_sql);
$data = array();
while($row = mysqli_fetch_array($q_res))
{
	$cyc_sql = "SELECT * FROM cycle WHERE program_year_id ='".$row['program_id']."' and start_week <= '".$row['date']."' and end_week >= '".$row['date']."'";
	$q_res_sql = mysqli_query($db, $cyc_sql);
	$cycdata = mysqli_fetch_array($q_res_sql);
	if($cycdata['no_of_cycle'] == 1)
	{
		$cycle_id = 1;
	}elseif($cycdata['no_of_cycle'] == 2){
		$cyc_sql_no = "SELECT min(id) as min_id,max(id) as max_id FROM cycle WHERE program_year_id ='".$row['program_id']."'";
		$q_res_no = mysqli_query($db, $cyc_sql_no);
		$row_res = mysqli_fetch_array($q_res_no);
		if($cycdata['id'] == $row_res['min_id'])
			$cycle_id = 1;
		else
			$cycle_id = 2;
	}elseif($cycdata['no_of_cycle'] == 3){
		$cyc_sql_no = "SELECT min(id) as min_id,max(id) as max_id FROM cycle WHERE program_year_id ='".$row['program_id']."'";
		$q_res_no = mysqli_query($db, $cyc_sql_no);
		$row_res = mysqli_fetch_array($q_res_no);
		if($cycdata['id'] == $row_res['min_id'])
			$cycle_id = 1;
		elseif($cycdata['id'] == $row_res['max_id'])
			$cycle_id = 3;
		else
			$cycle_id = 2;
	}
	$startTime = "";
	if($row['timeslot'] !=""){
		$startTime = explode('-', $row['timeslot']);
	}
	$data[] = array("Date" => $row['date'],
					"Start Time" => str_convert($startTime[0]),
					"Timeslot" => str_convert($row['timeslot']),
					"Program" => str_convert($row['name']),
					"Cycle" => str_convert($cycle_id),
					"Area" => str_convert($row['area_name']),
					"Subject" => str_convert($row['subject_name']),
					"Session" => str_convert($row['session_name']),
					"Special Activity Name" => str_convert($row['special_activity_name']),
					"Teacher Name" => str_convert($row['teacher_name']),
					"Classroom" => str_convert($row['room_name']),
					"Case No" => str_convert($row['case_number']),
					"Technical Notes" => str_convert($row['technical_notes']),
					"Description" => str_convert($row['description'])); 
} 
function str_convert($str){
	return iconv("UTF-8", "ISO-8859-1//IGNORE",$str);
}

$filename = "academic_report_" . date('Ymd') . ".xls";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }
  
  $flag = false;
  foreach($data as $row) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\n";
      $flag = true;
    }
    array_walk($row, 'cleanData');
    echo implode("\t", array_values($row)) . "\n";
  }
  exit;
?>