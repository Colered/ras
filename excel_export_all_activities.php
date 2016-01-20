<?php
include('config.php');
$objTime = new Timetable();
$q_res= $objTime->getTeachersActivityInRange();
include_once 'classes/PHPExcel.php';
include 'classes/PHPExcel/Writer/Excel2007.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Program');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Cycle');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Subject Name');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Subject Code');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Session Name');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Order No');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Duration');
$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Teacher');
$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Room');
$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Date');
$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Start Time');
$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Case No');
$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Technical Notes');
$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Description');
$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Activity Name');
$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Special Act Name');
$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Timeslot');
$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Cycle Start Time');
$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Cycle End Time');
$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Company');
$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Module');
$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Area');
$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Teacher Type');
//start writing the data from second row
$count = 2;
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
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$count, str_convert($row['name']));
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$count, str_convert($cycle_id));
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$count, str_convert($row['subject_name']));
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$count, str_convert($row['subject_code']));
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$count, str_convert($row['session_name']));
	$objPHPExcel->getActiveSheet()->SetCellValue('F'.$count, str_convert($row['session_name']));
	$objPHPExcel->getActiveSheet()->SetCellValue('G'.$count, $duration);
	$objPHPExcel->getActiveSheet()->SetCellValue('H'.$count, str_convert($row['teacher_name']));
	$objPHPExcel->getActiveSheet()->SetCellValue('I'.$count, str_convert($row['room_name']));
	$objPHPExcel->getActiveSheet()->SetCellValue('J'.$count, $row['act_date']);
	$objPHPExcel->getActiveSheet()->SetCellValue('K'.$count, str_convert(isset($startTime['0'])? $startTime['0'] :''));
	$objPHPExcel->getActiveSheet()->SetCellValue('L'.$count, str_convert($row['case_number']));
	$objPHPExcel->getActiveSheet()->SetCellValue('M'.$count, str_convert($row['technical_notes']));
	$objPHPExcel->getActiveSheet()->SetCellValue('N'.$count, str_convert($row['description']));
	$objPHPExcel->getActiveSheet()->SetCellValue('O'.$count, $row['act_name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('P'.$count, $row['special_activity_name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$count, str_convert(isset($timeslotVal['0'])? $timeslotVal['0'] :''));
	$objPHPExcel->getActiveSheet()->SetCellValue('R'.$count, str_convert(isset($cycleDuration['0'])? $cycleDuration['0'] :''));
	$objPHPExcel->getActiveSheet()->SetCellValue('S'.$count, str_convert(isset($cycleDuration['1'])? $cycleDuration['1'] :''));
	$objPHPExcel->getActiveSheet()->SetCellValue('T'.$count, str_convert($row['company']));
	$objPHPExcel->getActiveSheet()->SetCellValue('U'.$count, str_convert($row['unit']));
	$objPHPExcel->getActiveSheet()->SetCellValue('V'.$count, str_convert($row['area_name']));
	$objPHPExcel->getActiveSheet()->SetCellValue('W'.$count, str_convert($row['teacher_type_name']));
	$count++;
} 
function str_convert($str){
	return iconv("UTF-8", "ISO-8859-1//IGNORE",$str);
}
function cleanData(&$str)
{
	$str = preg_replace("/\t/", "\\t", $str);
	$str = preg_replace("/\r?\n/", "\\n", $str);
	if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

$filename = "all_activity_report.xlsx";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($filename); 

header("Content-Disposition: attachment; filename=\"$filename\"");
//header("Content-Disposition: attachment; filename="\D:/xampp/htdocs/ras/".$filename");

header("Content-Type:");
ob_clean();
flush();	
	


?>