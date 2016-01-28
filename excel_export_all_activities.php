<?php
include('config.php');
$objTime = new Timetable();
$teacher_id = isset($_POST['teacher'])?$_POST['teacher']:'';
$program_id = isset($_POST['program'])?$_POST['program']:'';
$area_id = isset($_POST['area'])?$_POST['area']:'';
$profesor_id = isset($_POST['profesor'])?$_POST['profesor']:'';
$cycle_id = isset($_POST['cycle'])?$_POST['cycle']:'';
$module = isset($_POST['module'])?$_POST['module']:'';
$addSpecialAct = isset($_POST['addSpecialAct'])?$_POST['addSpecialAct']:'';
//$q_res= $objTime->getTeachersActivityInRange($teacher_id,$program_id,$area_id,$profesor_id,$cycle_id,$module,$addSpecialAct);
$teacher_sql = "select t.id,ta.id as act_id,ta.cycle_id,ta.name as act_name,ta.act_date,ta.timeslot_id,t.teacher_name,t.teacher_type,tt.teacher_type_name,py.id as program_id,py.name, p.company, u.name as unit,t.payrate, s.session_name, a.area_name, su.subject_name, su.subject_code, s.case_number, s.technical_notes, s.description, r.room_name, sam.special_activity_name, ta.program_year_id from teacher_activity ta 
		left join teacher t on t.id = ta.teacher_id 
		left join subject su on su.id = ta.subject_id 
		left join program_years py on py.id = ta.program_year_id 
		left join program p on p.id = py.program_id 
		left join unit u on u.id = p.unit 
		left join subject_session s on s.id = ta.session_id
		left join special_activity_mapping sam on sam.teacher_activity_id = ta.id 
		left join area a on a.id = su.area_id or  a.id = sam.area_id
		left join room r on r.id = ta.room_id 
		left join teacher_type tt on tt.id = t.teacher_type
		where 1";
		if($teacher_id != '')
		{
			 $teacher_sql .= " and ta.teacher_id IN($teacher_id)";
		}
		if($program_id != '')
		{
			$teacher_sql .= " and ta.program_year_id IN($program_id)";
		}
		if($area_id != '')
		{
			$teacher_sql .= " and su.area_id IN($area_id)";
		}
		if($profesor_id != '')
		{
			$teacher_sql .= " and t.teacher_type IN($profesor_id)";
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
			$teacher_sql .= " and p.unit IN($module)";
		}
		if($addSpecialAct == '')
		{
			$teacher_sql .= " and ta.reserved_flag IN(1, 5)";
		}

		$teacher_sql .= " order by ta.id";

$q_res = mysqli_query($db,$teacher_sql);

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
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$count, $row['name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$count, $cycle_id);
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$count, $row['subject_name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$count, $row['subject_code']);
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$count, $row['session_name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('F'.$count, $row['session_name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('G'.$count, $duration);
	$objPHPExcel->getActiveSheet()->SetCellValue('H'.$count, $row['teacher_name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('I'.$count, $row['room_name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('J'.$count, $row['act_date']);
	$objPHPExcel->getActiveSheet()->SetCellValue('K'.$count, isset($startTime['0'])? $startTime['0'] :'');
	$objPHPExcel->getActiveSheet()->SetCellValue('L'.$count, $row['case_number']);
	$objPHPExcel->getActiveSheet()->SetCellValue('M'.$count, $row['technical_notes']);
	$objPHPExcel->getActiveSheet()->SetCellValue('N'.$count, $row['description']);
	$objPHPExcel->getActiveSheet()->SetCellValue('O'.$count, $row['act_name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('P'.$count, $row['special_activity_name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$count, isset($timeslotVal['0'])? $timeslotVal['0'] :'');
	$objPHPExcel->getActiveSheet()->SetCellValue('R'.$count, isset($cycleDuration['0'])? $cycleDuration['0'] :'');
	$objPHPExcel->getActiveSheet()->SetCellValue('S'.$count, isset($cycleDuration['1'])? $cycleDuration['1'] :'');
	$objPHPExcel->getActiveSheet()->SetCellValue('T'.$count, $row['company']);
	$objPHPExcel->getActiveSheet()->SetCellValue('U'.$count, $row['unit']);
	$objPHPExcel->getActiveSheet()->SetCellValue('V'.$count, $row['area_name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('W'.$count, $row['teacher_type_name']);
	$count++;
} 
/*function str_convert($str){
	return iconv("UTF-8", "ISO-8859-1//IGNORE",$str);
}*/
function cleanData(&$str)
{
	$str = preg_replace("/\t/", "\\t", $str);
	$str = preg_replace("/\r?\n/", "\\n", $str);
	if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}
$filename = "activity_report.xlsx";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($filename); 
header('Content-Disposition: attachment; filename=' . $filename	 );
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Length: ' . filesize($filename));
header('Content-Transfer-Encoding: UTF-8');
header('Cache-Control: must-revalidate');
header('Pragma: public');
readfile('activity_report.xlsx');
?>