<?php
include('config.php');
$objTime = new Timetable();
$q_res= $objTime->getTeachersActivityInRange();
$data = array();
while($row = mysqli_fetch_array($q_res))
{
	$cycle_id = $objTime->getCycleDetailsId($row['program_id'],$row['cycle_id']);
	$cycleDurationTemp = $objTime->getCycleDuration($row['program_id'],$cycle_id);
	$cycleDuration = explode("to", $cycleDurationTemp);
	$tsobj = new Timeslot();
	$timeslotVal = $tsobj->getTSbyIDs('('.$row['timeslot_id'].')');
	$startTime = array();
	$duration = "";
	if(isset($timeslotVal['0']) && $timeslotVal['0']!=""){
		$startTime = explode("-", $timeslotVal['0']);
		$duration = (strtotime($startTime['1'])- strtotime($startTime['0']))/60;
	}
	$data[] = array("Program" => str_convert($row['name']),
					"Cycle" => str_convert($cycle_id),
					"Subject Name" => str_convert($row['subject_name']),
					"Subject Code" => str_convert($row['subject_code']),
					"Session Name" => str_convert($row['session_name']),
					"Session Order" => str_convert($row['session_name']),
					"Duration" => $duration,
					"Teacher" => str_convert($row['teacher_name']),
					"Room" => str_convert($row['room_name']),
					"Date" => $row['act_date'],
					"Start Time" => str_convert(isset($startTime['0'])? $startTime['0'] :''),
					"Case No" => str_convert($row['case_number']),
					"Technical Notes" => str_convert($row['technical_notes']),
					"Description" => str_convert($row['description']),
					"ActIvity Name" => $row['act_name'],
					"Special Act Name" => $row['special_activity_name'],
					"Timeslot" => str_convert(isset($timeslotVal['0'])? $timeslotVal['0'] :''),
					"Cycle Start Time" => str_convert(isset($cycleDuration['0'])? $cycleDuration['0'] :''),
					"Cycle End Time" => str_convert(isset($cycleDuration['1'])? $cycleDuration['1'] :''),
					"Company" => str_convert($row['company']),
					"Module" => str_convert($row['unit']),
					"Area" => str_convert($row['area_name']),
					"Teacher Type" => str_convert($row['teacher_type_name']));
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