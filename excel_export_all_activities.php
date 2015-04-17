<?php
include('config.php');
$objTime = new Timetable();
$q_res= $objTime->getTeachersActivityInRange();
$data = array();
while($row = mysqli_fetch_array($q_res))
{
	$cycle_id = $objTime->getCycleDetailsId($row['program_id'],$row['cycle_id']);
	$tsobj = new Timeslot();
	$timeslotVal = $tsobj->getTSbyIDs('('.$row['timeslot_id'].')');
	$data[] = array("ActIvity Name" => $row['act_name'],
					"Date" => $row['act_date'],
					"Timeslot" => str_convert(isset($timeslotVal['0'])? $timeslotVal['0'] :''),
					"Program" => str_convert($row['name']),
					"Company" => str_convert($row['company']),
					"Module" => str_convert($row['unit']),
					"Cycle" => str_convert($cycle_id),
					"Special Act Name" => $row['special_activity_name'],
					"Area" => str_convert($row['area_name']),
					"Subject" => str_convert($row['subject_name']),
					"Subject Code" => str_convert($row['subject_code']),
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

$filename = "activity_report_" . date('Ymd') . ".xls";
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