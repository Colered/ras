 <?php
include('config.php');

// file name for download
$filename = "teacher_report_" . date('Ymd') . ".xls";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$fromTmDuratn = $_POST['postdata'][1];
$toTmDuratn = $_POST['postdata'][2];
$teacher_id = isset($_POST['postdata'][3])?$_POST['postdata'][3]:'';
$program_id = isset($_POST['postdata'][4])?$_POST['postdata'][4]:'';
$area_id = isset($_POST['postdata'][5])?$_POST['postdata'][5]:'';

$teacher_sql = "select t.id,td.date,t.teacher_name,t.teacher_type,py.name,p.company,u.name as unit,t.payrate,s.session_name from timetable_detail td inner join teacher t on t.id = td.teacher_id inner join subject su on su.id = td.subject_id inner join program_years py on py.id = td.program_year_id inner join program p on p.id = py.program_id inner join unit u on u.id = p.unit inner join subject_session s on s.id = td.session_id where date between '".$fromTmDuratn."' and '".$toTmDuratn."'";
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
$q_res = mysqli_query($db,$teacher_sql);
$data = array();
while($row = mysqli_fetch_array($q_res))
{
	$data[] = array("Date" => $row['date'], "Teacher Name" => $row['teacher_name'], "Teacher Type" => $row['teacher_type'],"Program" => $row['name'], "Company" => $row['company'], "Module" => $row['unit'], "Sessions" => $row['session_name'], "Payrate" => $row['payrate']);  
}  

$total_sql = "select distinct teacher_id,count(session_id) as session_id,t.teacher_name,t.payrate from timetable_detail td inner join teacher t on t.id = td.teacher_id inner join subject su on su.id = td.subject_id where date between '".$fromTmDuratn."' and '".$toTmDuratn."'";
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