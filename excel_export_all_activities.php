<?php
include('config.php');
$fromTmDuratn = $_POST['postdata'][1];
$toTmDuratn = $_POST['postdata'][2];
$teacher_id = isset($_POST['postdata'][3])?$_POST['postdata'][3]:'';
$program_id = isset($_POST['postdata'][4])?$_POST['postdata'][4]:'';
$area_id = isset($_POST['postdata'][5])?$_POST['postdata'][5]:'';
$profesor_id = isset($_POST['postdata'][6])?$_POST['postdata'][6]:'';
$cycle_id = isset($_POST['postdata'][7])?$_POST['postdata'][7]:'';
$module = isset($_POST['postdata'][8])?$_POST['postdata'][8]:'';

$teacher_sql = "select t.id,ta.id as act_id,ta.cycle_id,ta.name as act_name,ta.act_date,ta.timeslot_id,t.teacher_name,t.teacher_type,tt.teacher_type_name,py.id as program_id,py.name,p.company,u.name as unit,t.payrate,s.session_name,a.area_name,su.subject_name,s.case_number,s.technical_notes,s.description,r.room_name,sam.special_activity_name from teacher_activity ta 
		left join teacher t on t.id = ta.teacher_id 
		left join subject su on su.id = ta.subject_id 
		left join program_years py on py.id = ta.program_year_id 
		left join program p on p.id = py.program_id 
		left join unit u on u.id = p.unit 
		left join subject_session s on s.id = ta.session_id
		left join  special_activity_mapping sam on sam.teacher_activity_id = ta.id 
		left join area a on a.id = su.area_id or  a.id = sam.area_id
		left join room r on r.id = ta.room_id 
		left join teacher_type tt on tt.id = t.teacher_type
		where act_date between '".$fromTmDuratn."' and '".$toTmDuratn."'";

if($teacher_id != '')
{
	 $teacher_sql .= " and teacher_id = '".$teacher_id."'";
}
if($program_id != '')
{
	$teacher_sql .= " and ta.program_year_id = '".$program_id."'";
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
			$teacher_sql .= "ta.cycle_id = '".$cyc_arr[$i]."'";
		}else{
			$teacher_sql .= "ta.cycle_id = '".$cyc_arr[$i]."' || ";
		}
	}
	$teacher_sql .= ")";
}
if($module != '')
{
	$teacher_sql .= " and p.unit = '".$module."'";
}
$teacher_sql .= " order by ta.teacher_id";
$q_res = mysqli_query($db,$teacher_sql);
$data = array();
$objTime=new Timetable();
while($row = mysqli_fetch_array($q_res))
{
	$cycle_id = $objTime->getCycleDetailsId($row['program_id'],$row['cycle_id']);
	$tsobj = new Timeslot();
	$timeslotVal = $tsobj->getTSbyIDs('('.$row['timeslot_id'].')');
	$data[] = array("ActIvity Name" => $row['act_name'],
					"Date" => $row['act_date'],
					"Timeslot" => str_convert($timeslotVal['0']),
					"Program" => str_convert($row['name']),
					"Company" => str_convert($row['company']),
					"Module" => str_convert($row['unit']),
					"Cycle" => str_convert($cycle_id),
					"Special Act Name" => $row['special_activity_name'],
					"Area" => str_convert($row['area_name']),
					"Subject" => str_convert($row['subject_name']),
					"Session" => str_convert($row['session_name']),
					"Teacher Name" => str_convert($row['teacher_name']),
					"Teacher Type" => str_convert($row['teacher_type_name']),
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