 <?php
include('config.php');

// file name for download
$filename = "academic_report_" . date('Ymd') . ".xls";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$fromTmDuratn = $_POST['postdata'][1];
$toTmDuratn = $_POST['postdata'][2];
$teacher_id = isset($_POST['postdata'][3])?$_POST['postdata'][3]:'';
$program_id = isset($_POST['postdata'][4])?$_POST['postdata'][4]:'';
$area_id = isset($_POST['postdata'][5])?$_POST['postdata'][5]:'';
$profesor_id = isset($_POST['postdata'][6])?$_POST['postdata'][6]:'';
$cycle_id = isset($_POST['postdata'][7])?$_POST['postdata'][7]:'';
$module = isset($_POST['postdata'][8])?$_POST['postdata'][8]:'';

$teacher_sql = "select t.id,td.date,td.timeslot,t.teacher_name,t.teacher_type,py.id as program_id,py.name,p.company,u.name as unit,t.payrate,s.session_name,a.area_name,su.subject_name,s.case_number,s.technical_notes,r.room_name from timetable_detail td inner join teacher t on t.id = td.teacher_id inner join subject su on su.id = td.subject_id inner join program_years py on py.id = td.program_year_id inner join program p on p.id = py.program_id inner join unit u on u.id = p.unit inner join subject_session s on s.id = td.session_id inner join area a on a.id = su.area_id inner join room r on r.id = td.room_id where date between '".$fromTmDuratn."' and '".$toTmDuratn."'";
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
	$data[] = array("Date" => $row['date'], "Timeslot" => $row['timeslot'], "Program" => $row['name'], "Company" => $row['company'], "Module" => $row['unit'], "Cycle" => $cycle_id, "Area" => $row['area_name'], "Subject" => $row['subject_name'], "Session" => $row['session_name'],  "Teacher Name" => $row['teacher_name'], "Teacher Type" => $row['teacher_type'], "Classroom" => $row['room_name'], "Case No" => $row['case_number'], "Technical Notes" => $row['technical_notes']);  
}  

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