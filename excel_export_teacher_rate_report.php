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

$teacher_sql = "select t.id,td.date,td.timeslot,t.teacher_name,t.teacher_type,tt.teacher_type_name,py.id as program_id,py.name,p.company,u.name as unit,t.payrate,s.session_name,a.area_name,su.subject_name,s.case_number,s.technical_notes,r.room_name from timetable_detail td inner join teacher t on t.id = td.teacher_id inner join subject su on su.id = td.subject_id inner join program_years py on py.id = td.program_year_id inner join program p on p.id = py.program_id inner join unit u on u.id = p.unit inner join subject_session s on s.id = td.session_id inner join area a on a.id = su.area_id inner join room r on r.id = td.room_id left join teacher_type tt on tt.id = t.teacher_type where date between '".$fromTmDuratn."' and '".$toTmDuratn."'";
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
	$data[] = array("Date" => $row['date'], "Teacher Name" => mb_convert_encoding($row['teacher_name'],'UTF-16LE', 'UTF-8'), "Teacher Type" => mb_convert_encoding($row['teacher_type_name'],'UTF-16LE', 'UTF-8'),"Program" => mb_convert_encoding($row['name'],'UTF-16LE', 'UTF-8'), "Company" => mb_convert_encoding($row['company'],'UTF-16LE', 'UTF-8'), "Module" => mb_convert_encoding($row['unit'],'UTF-16LE', 'UTF-8'), "Sessions" => mb_convert_encoding($row['session_name'],'UTF-16LE', 'UTF-8'), "Payrate" => mb_convert_encoding($row['payrate'],'UTF-16LE', 'UTF-8'));  
}  

$total_sql = "select distinct teacher_id,count(session_id) as session_id,t.teacher_name,t.payrate from timetable_detail td inner join teacher t on t.id = td.teacher_id inner join subject su on su.id = td.subject_id inner join program_years py on py.id = td.program_year_id inner join program p on p.id = py.program_id inner join unit u on u.id = p.unit where date between '".$fromTmDuratn."' and '".$toTmDuratn."'";
if($teacher_id != '')
{
	 $total_sql .= " and teacher_id = '".$teacher_id."'";
}
if($program_id != '')
{
	$total_sql .= " and td.program_year_id = '".$program_id."'";
}
if($area_id != '')
{
	$total_sql .= " and su.area_id = '".$area_id."'";
}
if($profesor_id != '')
{
	$total_sql .= " and t.teacher_type = '".$profesor_id."'";
}
if($cycle_id != '')
{
	$cyc_arr = explode(",",$cycle_id);
	$total_sql .= " and (";			
	for($i=0;$i<count($cyc_arr);$i++)
	{
		if($i == count($cyc_arr)-1)
		{
			$total_sql .= "td.cycle_id = '".$cyc_arr[$i]."'";
		}else{
			$total_sql .= "td.cycle_id = '".$cyc_arr[$i]."' || ";
		}
	}
	$total_sql .= ")";
}
if($module != '')
{
	$total_sql .= " and p.unit = '".$module."'";
}
$total_sql .= " group by td.teacher_id order by td.teacher_id";
$result = mysqli_query($db,$total_sql);
$total = '';$sum = '';
while($result_row = mysqli_fetch_array($result))
{
	$total += $result_row['payrate']*$result_row['session_id'];
	$sum += $result_row['session_id'];
}
if($total == '')
	$total = '0';
if($sum == '')
	$sum = '0';

$data[] = array("Date" => "Total", "Teacher Name" => "", "Teacher Type" => "","Program" => "", "Company" => "", "Module" => "", "Sessions" => $sum, "Payrate" => $total);

$filename = "teacher_report_" . date('Ymd') . ".xls";
header("Content-Disposition: attachment; filename=\"$filename\""); 
header("Content-type: application/vnd.ms-excel; charset=utf-8");

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