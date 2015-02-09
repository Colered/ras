<?php
if (isset($_POST['form_action']) && $_POST['form_action']!=""){
	$formPost = $_POST['form_action'];
	switch ($formPost) {
		case "uploadSession":
			require 'classes/PHPExcel.php';
			require_once 'classes/PHPExcel/IOFactory.php';
			$path = $_FILES['uploadSess']['tmp_name'];//"datafile.xlsx";
			$objPHPExcel = PHPExcel_IOFactory::load($path);
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
				$worksheetTitle     = $worksheet->getTitle();
				$highestRow         = $worksheet->getHighestRow(); // e.g. 10
				$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$nrColumns = ord($highestColumn) - 64;
			}
			$dataArr = array();
			for ($row = 1; $row <= $highestRow; ++ $row) 
			{
				$val=array();
				for ($col = 0; $col < $highestColumnIndex; ++ $col) 
				{
				   $cell = $worksheet->getCellByColumnAndRow($col, $row);
				   $val[] = (string)$cell->getValue();
				}
				$dataArr[] = $val;
			}
			$errorArr = array();
			if(count($dataArr)>1){
			$count = 1;
			require_once('config.php');
			//get all Teacher in the array
			$objT = new Teacher();								
			$respT = $objT->getTeachers();
			$teacNameArr = array(); $teacIdsArr = array();	
			while($row = mysqli_fetch_array($respT))
			{
				$teacNameArr[] = $row['teacher_name'];
				$teacIdsArr[] = $row['id'];
			}
			//get all subjects in the array
			$objS = new Subjects();								
			$respS = $objS->getSubjects();
			$subjNameArr = array(); $subjIdsArr = array(); $subjCodeArr = array();	
			while($row = mysqli_fetch_array($respS))
			{
				$subjNameArr[] = $row['subject_name'];
				$subjIdsArr[] = $row['id'];
				$subjCodeArr[] = $row['subject_code'];
			}
			//get all rooms in the array
			$objRoom = new Classroom();								
			$respRoom = $objRoom->getRoom();
			$roomNameArr = array(); $roomIdsArr = array(); 
			while($row = mysqli_fetch_array($respRoom))
			{
				$roomNameArr[] = $row['room_name'];
				$roomIdsArr[] = $row['id'];
			}
			//get all timeslot in the array
			$objTS = new Timeslot();								
			$respTS = $objTS->viewTimeslot();
			$TimeSlotArr = array(); $TimeSlotIDArr = array(); 
			while($row = mysqli_fetch_array($respTS))
			{
				$TimeSlotArr[] = $row['start_time'];
				$TimeSlotIDArr[] = $row['id'];
			}
			//get all program and cycle
			$objP = new Programs();								
			$respP = $objP->getProgramWithNoOfCycle();
			$progNameArr = array(); $progYrIdsArr = array(); $noOfCycleArr = array(); $cycleIdArr = array();	
			while($row = mysqli_fetch_array($respP))
			{
				$progNameArr[] = $row['name'];
				$progYrIdsArr[] = $row['program_year_id'];
				$noOfCycleArr[] = $row['no_of_cycle'];
				$cycleIdArr[] = $row['cycleId'];
			}
			foreach($dataArr as $values){
				//check if file headers are in expected format
				if($count == 1){
					if(strtolower(trim($values[0]))=="program" && strtolower(trim($values[1]))=="cycle" && strtolower(trim($values[2]))=="subject name" && strtolower(trim($values[3]))=="subject code" && strtolower(trim($values[4]))=="session name" && strtolower(trim($values[5]))=="order no" && strtolower(trim($values[6]))=="duration" && strtolower(trim($values[7]))=="teacher" && strtolower(trim($values[8]))=="room" && strtolower(trim($values[9]))=="date" && strtolower(trim($values[10]))=="start time" && strtolower(trim($values[11]))=="case no" && strtolower(trim($values[12]))=="technical notes" && strtolower(trim($values[13]))=="description"){
						//File format is correct
					}else{
						$errorArr[] = "File format is not same, one or more header names are not matching";
						$_SESSION['error_msgArr'] = $errorArr;
						header('Location: session_upload.php');
						exit;
					}
					$count++;
				}elseif(strtolower(trim($values[0]))!="" && strtolower(trim($values[1]))!="" && strtolower(trim($values[2]))!="" && strtolower(trim($values[3]))!="" && strtolower(trim($values[4]))!="" && strtolower(trim($values[5]))!="" && strtolower(trim($values[6]))!="" && strtolower(trim($values[7]))!=""){
					$timeTemp = array();
					$cell_value = PHPExcel_Style_NumberFormat::toFormattedString($values[6], 'hh:mm');
					$timeTemp = explode(':', $cell_value);
					$duration = ($timeTemp[0]*60) + $timeTemp[1];
					//check if teacher exist
					$teachkey =array_search(trim(strtolower($values[7])), array_map('strtolower', $teacNameArr));
					if(($teachkey === 0) || ($teachkey > 0)){
						$teacher_id = $teacIdsArr[$teachkey];
					}else{
						$errorArr[] = "Error in Row no:" .$count." Teacher name does not exist in the system";
					}
					//check if subject name exist 
					$subNamekey =array_search(trim(strtolower($values[2])), array_map('strtolower', $subjNameArr));
					if(($subNamekey === 0) || ($subNamekey > 0)){
						//$subject_id = $subjIdsArr[$subNamekey];
					}else{
						$errorArr[] = "Error in Row no:" .$count." Subject Name does not exist in the system";
					}
					//check if subject code exist
					$subCodekey =array_search(trim(strtolower($values[3])), array_map('strtolower', $subjCodeArr));
					if(($subCodekey === 0) || ($subCodekey > 0)){
						$subject_id = $subjIdsArr[$subCodekey];
					}else{
						$errorArr[] = "Error in Row no:" .$count." Subject Code does not exist in the system";
					}
					//check if room name exist
					$RoomNamekey =array_search(trim(strtolower($values[8])), array_map('strtolower', $roomNameArr));
					if(($RoomNamekey === 0) || ($RoomNamekey > 0)){
						//$room_id = $subjIdsArr[$RoomNamekey];
					}else{
						$errorArr[] = "Error in Row no:" .$count." Room name does not exist in the system";
					}
					//check if timeslot exist
					$TSkey =array_search(trim(strtolower($values[10])), array_map('strtolower', $TimeSlotArr));
					if(($TSkey === 0) || ($TSkey > 0)){
						//$room_id = $subjIdsArr[$RoomNamekey];
					}else{
						$errorArr[] = "Error in Row no:" .$count." Time Slot does not exist in the system";
					}
					//check if program  name exist
					//$progNamekey = array_search($values[0], $progNameArr);
					$progNamekey =array_search(trim(strtolower($values[0])), array_map('strtolower', $progNameArr)); 
					$no_of_cycle="";
					if(($progNamekey === 0) || ($progNamekey > 0)){
						$program_year_id = $progYrIdsArr[$progNamekey];
						$no_of_cycle  = $noOfCycleArr[$progNamekey];
						$cycle_id   = $cycleIdArr[$progNamekey];
					}else{
						$errorArr[] = "Error in Row no:" .$count." Program name does not exist in the system";
					}
					if(($values[1] <= 0) || ($values[1] > $no_of_cycle) || ($values[1] = ''))
					{
						$errorArr[] = "Error in Row no:" .$count." Program cycle does not exist in the system";
					}
					//check room date and start time needs to be blank
					if(((strtolower(trim($values[8]))!="floating") && (strtolower(trim($values[8]))!="")) && ((strtolower(trim($values[9]))!="floating") && (strtolower(trim($values[9]))!="")) && ((strtolower(trim($values[10]))!="floating") && (strtolower(trim($values[10]))!="")))
					{
						$errorArr[] = "Error in Row no:" .$count." Import can be done only for unreserved or semi-reserved activities please make either room or date or start time field as FLOATING or empty";
					}
					$count++;
				}
			}
			//if file have no errors create activity and sessions else return error messages array
			if(count($errorArr)==0){
				$total = 0;
				foreach($dataArr as $values){
						if($total > 0 && strtolower(trim($values[0]))!="" && strtolower(trim($values[1]))!="" && strtolower(trim($values[2]))!="" && strtolower(trim($values[3]))!="" && strtolower(trim($values[4]))!="" && strtolower(trim($values[5]))!="" && strtolower(trim($values[6]))!="" && strtolower(trim($values[7]))!=""){
								//convert duration into minutes
								$timeTempArr = array();
								$cell_value = PHPExcel_Style_NumberFormat::toFormattedString($values[6], 'hh:mm');
								$timeTempArr = explode(':', $cell_value);
								$duration = ($timeTempArr[0]*60) + ($timeTempArr[1]); 
								//$teachkey = array_search($values[7], $teacNameArr);
								$teachkey =array_search(trim(strtolower($values[7])), array_map('strtolower', $teacNameArr));
								if(($teachkey === 0) || ($teachkey > 0)){
									$teacher_id = $teacIdsArr[$teachkey];
								}
								//$subNamekey = array_search($values[2], $subjNameArr);
								$subCodekey =array_search(trim(strtolower($values[3])), array_map('strtolower', $subjCodeArr));
								if(($subCodekey === 0) || ($subCodekey > 0)){
									$subject_id = $subjIdsArr[$subCodekey];
								}
								//get the room ID
								$room_id = '';
								$RoomNamekey =array_search(trim(strtolower($values[8])), array_map('strtolower', $roomNameArr));
								if(($RoomNamekey === 0) || ($RoomNamekey > 0)){
									$room_id = $roomIdsArr[$RoomNamekey];
								}
								//$progNamekey = array_search($values[0], $progNameArr); 
								$progNamekey =array_search(trim(strtolower($values[0])), array_map('strtolower', $progNameArr));
								$noOfCycle="";
								if(($progNamekey === 0) || ($progNamekey > 0)){
									$program_year_id = $progYrIdsArr[$progNamekey];
									$cycle_id   = $cycleIdArr[$progNamekey];
								}
								//check if date has been provided
								if (isset($values[9]) && ($values[9]!='')){
									$originalDate = $values[9];
									$act_date = date("Y-m-d", strtotime($originalDate));
								}
								//check if start time has been provided
								$start_time = ''; $tsIdsAll = '';
								if (isset($values[10]) && ($values[10]!='')){
									$TSkey =array_search(trim(strtolower($values[10])), array_map('strtolower', $TimeSlotArr));
									if(($TSkey === 0) || ($TSkey > 0)){
										$start_time = $TimeSlotIDArr[$TSkey];
									}
									//calculate all TS ids for the activity if Start Time and duration is set
									$timeslotIdsArray = array();
									if (isset($values[6]) && ($values[6]!='')){
										if ($values[6] > 15) {
											$noOfslots = $values[6] / 15;
											$startTS = $start_time;
											$endTS = $startTS + $noOfslots;
											for ($i = $startTS; $i < $endTS; $i++) {
												$timeslotIdsArray[] = $i;
											}
										} else {
											$timeslotIdsArray[] = $start_time;
										}
										$tsIdsAll = implode(',', $timeslotIdsArray);
									}
								}
								
								
								//check if session already exist
								$resultQRY = mysqli_query($db, "SELECT id FROM subject_session WHERE subject_id='$subject_id' and cycle_no='$values[1]' and session_name='$values[4]' LIMIT 1");
								$dRowQ = mysqli_fetch_assoc($resultQRY);
								if (count($dRowQ) > 0) {
									$sessionId = $dRowQ['id'];
								}else{
									$result = mysqli_query($db, "INSERT INTO subject_session(id, subject_id, cycle_no, session_name, order_number, description, case_number, technical_notes, duration, date_add, date_update) VALUES ('', '" .$subject_id. "', '" .mysql_real_escape_string(trim($values[1])). "', '" .mysql_real_escape_string(trim($values[4])). "', '" .mysql_real_escape_string(trim($values[5])). "', '" .mysql_real_escape_string(trim($values[13])). "', '" .mysql_real_escape_string(trim($values[11])). "', '" .mysql_real_escape_string(trim($values[12])). "', '" .$duration. "', NOW(), NOW());");
									$sessionId = mysqli_insert_id($db);
								}
								if ($sessionId!="") {
									//check if activity already exists with same combination
									$resultAct = mysqli_query($db, "SELECT id FROM teacher_activity WHERE program_year_id='$program_year_id' and subject_id='$subject_id' and cycle_id='$cycle_id' and session_id='$sessionId ' and teacher_id='$teacher_id' LIMIT 1");
									$dRowAct = mysqli_fetch_row($resultAct); 
									if (count($dRowAct) == 0) {
										//get last created activity name
										$result3 = mysqli_query($db, "SELECT name FROM teacher_activity ORDER BY id DESC LIMIT 1");
										$dRow = mysqli_fetch_assoc($result3);
										$actCnt = substr($dRow['name'], 1);
										$actName = 'A' . ($actCnt + 1);
										//set the reserve flag variable
										$reserveFlag = 0;
										if(((strtolower(trim($values[8]))!="floating") && (strtolower(trim($values[8]))!="")) || ((strtolower(trim($values[9]))!="floating") && (strtolower(trim($values[9]))!="")) || ((strtolower(trim($values[10]))!="floating") && (strtolower(trim($values[10]))!="")))
										{
											$reserveFlag = 2;
										}
										//insert new activity
										$result2 = mysqli_query($db, "INSERT INTO teacher_activity (id, name, program_year_id, cycle_id, subject_id, session_id, teacher_id, group_id, room_id, start_time, timeslot_id, act_date, reserved_flag, date_add, date_update, forced_flag) VALUES ('', '".$actName."', '".$program_year_id."', '".$cycle_id."', '".$subject_id."', '".$sessionId."', '".$teacher_id."', '','".$room_id."', '".$start_time."', '".$tsIdsAll."', '".$act_date."', '".$reserveFlag."', NOW(), NOW(), 0);");
									}
								}
								
						} $total++ ; 
				}
				
				$_SESSION['succ_msg'] = "Data has been uploaded successfully.";
				header('Location: session_upload.php');
			}else{
				$_SESSION['error_msgArr'] = $errorArr;
				header('Location: session_upload.php');
			}
		}else{
				session_start();
				$errorArr[] = "File do not have any data to import.";
				$_SESSION['error_msgArr'] = $errorArr;
				header('Location: session_upload.php');
		}
		break;
		}
}
?>