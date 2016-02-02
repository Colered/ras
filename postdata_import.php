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
				   if($col == 10){
				   		$val[] = (string)$cell->getFormattedValue();
				   }else{
				   		$val[] = (string)$cell->getValue();
					}
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
					$teachkey =array_search(trim(strtolower($values[7])), array_map('trim', array_map('strtolower', $teacNameArr)));
					if(($teachkey === 0) || ($teachkey > 0)){
						$teacher_id = $teacIdsArr[$teachkey];
					}else{
						$errorArr[] = "Error in Row no:" .$count." Teacher name does not exist in the system";
					}
					//check if subject name exist 
					$subNamekey =array_search(trim(strtolower($values[2])), array_map('trim', array_map('strtolower', $subjNameArr)));
					if(($subNamekey === 0) || ($subNamekey > 0)){
						//do nothing
					}else{
						$errorArr[] = "Error in Row no:" .$count." Subject Name does not exist in the system";
					}
					//check if subject code exist
					$subCodekey =array_search(trim(strtolower($values[3])), array_map('trim', array_map('strtolower', $subjCodeArr)));
					if(($subCodekey === 0) || ($subCodekey > 0)){
						$subject_id = $subjIdsArr[$subCodekey];
					}else{
						$errorArr[] = "Error in Row no:" .$count." Subject Code does not exist in the system";
					}
					//check if room name exist
					if((strtolower(trim($values[8]))!="floating") && (strtolower(trim($values[8]))!=""))
					{
						$RoomNamekey =array_search(trim(strtolower($values[8])), array_map('trim', array_map('strtolower', $roomNameArr)));
						if(($RoomNamekey === 0) || ($RoomNamekey > 0)){
							//do nothing
						}else{
							$errorArr[] = "Error in Row no:" .$count." Room name does not exist in the system";
						}
					}
					//check if timeslot exist
					$time = date('h:i A', strtotime($values[10]));
					if((strtolower(trim($time))!="floating") && (strtolower(trim($time))!=""))
					{
						$TSkey =array_search(trim(strtolower($time)), array_map('trim', array_map('strtolower', $TimeSlotArr)));
						if(($TSkey === 0) || ($TSkey > 0)){
							//do nothing
						}else{
							$errorArr[] = "Error in Row no:" .$count.'--'.$values[10]." Time Slot does not exist in the system";
						}
					}
					
					//check if program name exist
					$progNamekey =array_search(trim(strtolower($values[0])), array_map('trim', array_map('strtolower', $progNameArr))); 
					$no_of_cycle="";
					if(($progNamekey === 0) || ($progNamekey > 0)){
						$program_year_id = $progYrIdsArr[$progNamekey];
						$no_of_cycle  = $noOfCycleArr[$progNamekey];
						$cycleNo =  $values[1];
						$keyindex = $progNamekey + $cycleNo - 1;
						$cycle_id   = $cycleIdArr[$keyindex];
					}else{
						$errorArr[] = "Error in Row no:" .$count." Program name does not exist in the system";
					}
					if(($values[1] <= 0) || ($values[1] > $no_of_cycle) || ($values[1] = ''))
					{
						$errorArr[] = "Error in Row no:" .$count." Program cycle does not exist in the system";
					}
					//check if subject is associated to given program and cycle
					if ((isset($values[0]) && $values[0]!='') && (isset($values[2]) && $values[2]!='') && (isset($values[3]) && $values[3]!='')){
						$resultQRY = mysqli_query($db, "SELECT id FROM subject WHERE program_year_id='$program_year_id' and cycle_no='$cycle_id' and subject_code='".trim($values[3])."' LIMIT 1");
						$dRowQ = mysqli_fetch_assoc($resultQRY);
						if(count($dRowQ) > 0){
								//do nothing
						}else{
							$errorArr[] = "Error in Row no:" .$count." Subject code is not associated to given program and cycle";
						}
					}
					//check room date and start time needs to be blank
					if(((strtolower(trim($values[8]))!="floating") && (strtolower(trim($values[8]))!="")) && ((strtolower(trim($values[9]))!="floating") && (strtolower(trim($values[9]))!="")) && ((strtolower(trim($values[10]))!="floating") && (strtolower(trim($values[10]))!="")))
					{
						$errorArr[] = "Error in Row no:" .$count." Import can be done only for unreserved or semi-reserved activities please make either room or date or start time field as FLOATING or empty";
					}$count++;
				}else{
					$errorArr[] = "Error in Row no:" .$count." column  no 1 to 8 are mandatory fields";
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
								$teachkey =array_search(trim(strtolower($values[7])), array_map('trim', array_map('strtolower', $teacNameArr)));
								if(($teachkey === 0) || ($teachkey > 0)){
									$teacher_id = $teacIdsArr[$teachkey];
								}
								$subCodekey =array_search(trim(strtolower($values[3])), array_map('trim', array_map('strtolower', $subjCodeArr)));
								if(($subCodekey === 0) || ($subCodekey > 0)){
									$subject_id = $subjIdsArr[$subCodekey];
								}
								//get the room ID
								$room_id = '';
								$RoomNamekey =array_search(trim(strtolower($values[8])), array_map('trim', array_map('strtolower', $roomNameArr)));
								if(($RoomNamekey === 0) || ($RoomNamekey > 0)){
									$room_id = $roomIdsArr[$RoomNamekey];
								}
								$progNamekey =array_search(trim(strtolower($values[0])), array_map('trim', array_map('strtolower', $progNameArr)));
								$noOfCycle="";
								if(($progNamekey === 0) || ($progNamekey > 0)){
									$program_year_id = $progYrIdsArr[$progNamekey];
									$cycleNo = $values[1];
									$keyindex = $progNamekey + $cycleNo - 1;
									$cycle_id   = $cycleIdArr[$keyindex];
									//$cycle_id   = $cycleIdArr[$progNamekey];
								}
								//check if date has been provided
								$act_date='';
								if((strtolower(trim($values[9]))!="floating") && (strtolower(trim($values[9]))!="")){
									$UNIX_DATE = ($values[9] - 25569) * 86400;
									$act_date = gmdate("Y-m-d", $UNIX_DATE);
								}
								//check if start time has been provided
								$start_time = ''; $tsIdsAll = '';
								if((strtolower(trim($values[10]))!="floating") && (strtolower(trim($values[10]))!="")){
									$TSkey =array_search(trim(strtolower(date("h:i A" , strtotime($values[10])))), array_map('trim', array_map('strtolower', $TimeSlotArr))); 
									if(($TSkey === 0) || ($TSkey > 0)){
										$start_time = $TimeSlotIDArr[$TSkey];
									}
									//calculate all TS ids for the activity if Start Time and duration is set
									$timeslotIdsArray = array();
									if (isset($values[6]) && ($values[6]!='')){
										$timeTemp = array();
										$cell_value = PHPExcel_Style_NumberFormat::toFormattedString($values[6], 'hh:mm');
										$timeTemp = explode(':', $cell_value);
										$duration = ($timeTemp[0]*60) + $timeTemp[1];
										if ($duration > 15) {
											$noOfslots = $duration / 15;
											$startTS = $start_time;
											$endTS = $startTS + $noOfslots;
											for ($i = $startTS; $i < $endTS; $i++) {
												$timeslotIdsArray[] = $i;
											}
										} else {
											//$timeslotIdsArray[] = $start_time;
										}
										$tsIdsAll = implode(',', $timeslotIdsArray);
									}
								}
								//check if session already exist
								$resultQRY = mysqli_query($db, "SELECT id FROM subject_session WHERE subject_id='$subject_id' and cycle_no='$cycle_id' and session_name='$values[4]' LIMIT 1");
								$dRowQ = mysqli_fetch_assoc($resultQRY);
								if (count($dRowQ) > 0) {
									$sessionId = $dRowQ['id'];
								}else{
									$result = mysqli_query($db, "INSERT INTO subject_session(id, subject_id, cycle_no, session_name, order_number, description, case_number, technical_notes, duration, date_add, date_update) VALUES ('', '" .$subject_id. "', '" .$cycle_id. "', '" .mysql_real_escape_string(trim($values[4])). "', '" .mysql_real_escape_string(trim($values[5])). "', '" .mysql_real_escape_string(trim($values[13])). "', '" .mysql_real_escape_string(trim($values[11])). "', '" .mysql_real_escape_string(trim($values[12])). "', '" .$duration. "', NOW(), NOW());");
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
										if($start_time=='0' || $start_time==""){$start_time = 'NULL'; }
										$result2 = mysqli_query($db, "INSERT INTO teacher_activity (id, name, program_year_id, cycle_id, subject_id, session_id, teacher_id, group_id, room_id, start_time, timeslot_id, act_date, reserved_flag, date_add, date_update, forced_flag) VALUES ('', '".$actName."', '".$program_year_id."', '".$cycle_id."', '".$subject_id."', '".$sessionId."', '".$teacher_id."', '','".$room_id."', $start_time, '".$tsIdsAll."', '".$act_date."', '".$reserveFlag."', NOW(), NOW(), 0);");
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
		case "upldateSession":
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
				   if($col == 10){
				   		$val[] = (string)$cell->getFormattedValue();
				   }else{
				   		$val[] = (string)$cell->getValue();
					}
				}
				$dataArr[] = $val;
			}
			$errorArr = array();
			if(count($dataArr)>1){
			$count = 1;
			require_once('config.php');
			//get all Activity names in the array
			$objT = new Timetable();								
			$respT = $objT->getAllActivities();
			$actNameArr = array(); $actIdArr = array();
			while($row = mysqli_fetch_array($respT))
			{
				$actNameArr[] = $row['name'];
				$actIdArr[] = $row['id'];
			}
			foreach($dataArr as $values){
				//check if file headers are in expected format
				if($count == 1){
					if(strtolower(trim($values[0]))=="program" && strtolower(trim($values[1]))=="cycle" && strtolower(trim($values[2]))=="subject name" && strtolower(trim($values[3]))=="subject code" && strtolower(trim($values[4]))=="session name" && strtolower(trim($values[5]))=="order no" && strtolower(trim($values[6]))=="duration" && strtolower(trim($values[7]))=="teacher" && strtolower(trim($values[8]))=="room" && strtolower(trim($values[9]))=="date" && strtolower(trim($values[10]))=="start time" && strtolower(trim($values[11]))=="case no" && strtolower(trim($values[12]))=="technical notes" && strtolower(trim($values[13]))=="description" && strtolower(trim($values[14]))=="activity name"){
						//File format is correct
					}else{
						$errorArr[] = "File format is not same, one or more header names are not matching";
						$_SESSION['error_msgArr'] = $errorArr;
						header('Location: session_update.php');
						exit;
					}
					$count++;
				}elseif(strtolower(trim($values[14]))!=""){
					//check if activity exist
					$actNamekey =array_search(trim(strtolower($values[14])), array_map('trim', array_map('strtolower', $actNameArr)));
					if(($actNamekey === 0) || ($actNamekey > 0)){
						$activity_id = $actIdArr[$actNamekey];
					}else{
						$errorArr[] = "Error in Row no:" .$count." Activity name does not exist in the system";
					}
					$count++;
				}
			}
			//if file have no errors update three fields for related activities
			if(count($errorArr)==0){
				$total = 0;
				foreach($dataArr as $values){
						if($total > 0 && trim($values[14])!=""){
								$activityName = trim($values[14]);
								$caseNo = trim($values[11]);
								$technicalNotes = trim($values[12]);
								$description = trim($values[13]);
								//update the activity
								$result2 = mysqli_query($db, "UPDATE subject_session as ss LEFT JOIN teacher_activity as ta ON ss.id = ta.session_id
								SET ss.case_number = '".$caseNo."', ss.technical_notes='".$technicalNotes."', ss.description='".$description."', ss.date_update= NOW() WHERE ta.name ='".$activityName."' ");
								
						} $total++ ; 
				}
				
				$_SESSION['succ_msg'] = "Data has been updated successfully.";
				header('Location: session_update.php');
			}else{
				$_SESSION['error_msgArr'] = $errorArr;
				header('Location: session_update.php');
			}
		}else{
				session_start();
				$errorArr[] = "File do not have any data to import.";
				$_SESSION['error_msgArr'] = $errorArr;
				header('Location: session_update.php');
		}
		break;
		case "generateWeeklyReport":
			if(isset($_POST['fromGenrtWR']) && $_POST['toGenrtWR'] != '')
			{   
				require 'classes/PHPExcel.php';
				require_once 'classes/PHPExcel/IOFactory.php';
				$objPHPExcel = PHPExcel_IOFactory::load("week_report_cal.xlsx");
				$objPHPExcel->setActiveSheetIndex(0);
				//$HeightestRow = $objPHPExcel->getActiveSheet()->getHighestRow()+2;
				$HeightestRow=7;
				$from = date("Y-m-d",strtotime($_POST['fromGenrtWR']));
				$to = date("Y-m-d",strtotime($_POST['toGenrtWR']));
				require_once('config.php');
				$objTime = new Timetable();
				$rows =$newArr= $dateArray=$programArray=$rows_match=array();
				//getting the allocated activities details
				$result = $objTime->getTeachersInDateRange($from,$to);
				$date = $program_name = '';
				$i=0;
				$datePrgmArray=array();
				//preparing a array for the date wise and program wise
				while($row = $result->fetch_assoc()){
				    $reformRowArr=array();
					foreach($row as $k=>$v){
							$reformRowArr[]=$v;
					}
					if(in_array(trim($row['date']).'-'.trim($row['name']),$datePrgmArray) && ($i>0)){
						$j=0;
						$array_val=array();
						foreach($row as $key=>$val){
						 if(trim($rows[trim($row['date'])][trim($row['name'])][$j])!=trim($val)){
						   $array_val=explode(',',$rows[trim($row['date'])][trim($row['name'])][$j]);
						     if(!in_array(trim($val),$array_val)){
							  	$rows[trim($row['date'])][trim($row['name'])][trim($j)]=$rows[trim($row['date'])][trim($row['name'])][trim($j)].','.trim($val);
							    $j++;
						      }else{
								$rows[trim($row['date'])][trim($row['name'])][trim($j)]=$rows[trim($row['date'])][trim($row['name'])][trim($j)];
						   		$j++;
							  }
						 }else{
						   $rows[trim($row['date'])][trim($row['name'])][trim($j)]=$rows[trim($row['date'])][trim($row['name'])][trim($j)];
						   $j++;
						 }
						}
					}else{
						$datePrgmArray[] = trim($row['date']).'-'.trim($row['name']);
						$date=trim($row['date']);
						$program_name=trim($row['name']);
						$rows[$date][$program_name]= $reformRowArr;
					}
				  $i++;
				}
				//fectching the date week day and storing into the array
				$dates=$date_day_name=$rowsDayArr = $rowsSortArr=array();
				foreach($rows as $key1=>$value1){
					$dates[] = $key;
					$day=date('l', strtotime($key1));
					if($day=="Monday"){
						$day='0';
					}
					if($day=="Tuesday"){
						$day='1';
					}
					if($day=="Wednesday"){
						$day='2';
					}
					if($day=="Thursday"){
						$day='3';
					}
					if($day=="Friday"){
						$day='4';
					}
					if($day=="Saturday"){
						$day='5';
					}
					if($day=="Sunday"){
						$day='6';
					}
					$rowsDayArr[$day]=$value1;
				}
				//sorting of array according to week days
				$arr2=array('0','1','2','3','4','5');
				foreach($arr2 as $v){
						if(array_key_exists($v,$rowsDayArr)){
							$rowsSortArr[$v]=$rowsDayArr[$v]; 
						}
				}
				//making new array after the sorting for set the key in 0,1 format
				$mkNewArr=array();
				foreach($rowsSortArr as $key=>$val){
					$j=0;
				   foreach($val as $k=>$v){
				      $k=$j;
					  $mkNewArr[$key][$k]=$v;
					  	foreach($mkNewArr[$key][$k] as $ke=>$vl){
						    if($ke==2){
							     //$mkNewArr[$key][$k][$ke] = $objTime->sortingTimesSlots($vl);
								 $mkNewArr[$key][$k][$ke] = $objTime->timesSlotsMinMax($vl);
							}else{
								 $mkNewArr[$key][$k][$ke] = $vl;
							}
						}
					  $j++;
				   }
				}
				$maxArr=array();
				$mkNewArr = array_chunk($mkNewArr,1,true);
				//creating seperate array for data and storing array key count in max array 
				for($i=0;$i < count($mkNewArr);$i++){
					${'array' . $i}[] = $mkNewArr[$i];
					foreach($mkNewArr[$i] as $rowVal){
					  	$maxArr[] = count($rowVal);
					  }
				}
			if(!empty($maxArr)){
				$dateStr='Date Range:-'.$from.' to '.$to;
				
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(24);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', "Resumen Calendario Actividades");
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setName('Calibri');
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setItalic(true);
				$objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', $dateStr);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setItalic(true);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:E3');
				
				$cells=array('A','B','C','D','E','F','G','H','I','J','K','L','M');
				for($z=0;$z<max($maxArr);$z++){
				    for($x=0;$x<13;$x++){
					 if($x=='0'){
					 	$y='4';
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$HeightestRow, "EVENTO / PROGRAMA");
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setName('Calibri');
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setSize(6);
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true); 
					 }
					  if($x=='1'){
					 	$y='2';
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$HeightestRow, "HORA");
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setName('Calibri');
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setSize(6);
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);
					 }
					  if($x==2){
					 	$y='5';
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$HeightestRow, "PARTICIPANTES");
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setName('Calibri');
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setSize(6);
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);
					 }
					  if($x==3){
					 	$y='6';
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$HeightestRow, "AREA ASIGNADA");
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setName('Calibri');
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setSize(6);
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);
					 }
					  if($x=='4'){
					 	$y='3';
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$HeightestRow, "PROFESOR / RESPONSABLE");
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setName('Calibri');
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setSize(6);
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);
					 }
					  if($x=='5'){
					 	$y='';
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$HeightestRow, "CONSUMOS");
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setName('Calibri');
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setSize(6);
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);
					 }
					  if($x=='6'){
					 	$y='';
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$HeightestRow, "EQUIPOS INFORMATICOS");
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setName('Calibri');
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setSize(6);
						$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);
					 }
					 if($x=='7'){
					 	$y='7';
					 }
					 if($x=='8'){
					 	$y='8';
					 }
					 if($x=='9'){
					 	$y='9';
					 }
					 if($x=='10'){
					 	$y='10';
					 }
					 if($x=='11'){
					 	$y='11';
					 }
					 if($x=='12'){
					 	$y='12';
					 }
					  for($j=0;$j<13;$j++){
					   if($j%2==0){
					  	$objPHPExcel->getActiveSheet()->getStyle($cells[$j].$HeightestRow)->applyFromArray(
																										array(
																											'alignment' => array(
																												'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
																												'wrap' => true
																											),
																											'borders' => array(
																												'left'     => array(
																													'style' => PHPExcel_Style_Border::BORDER_MEDIUM
																												),
																												'right'  => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
																											),
																											'font' => array(
																														'name' => 'Calibri',
																														'size' => 8
																													)
																										    )
																								);
							}else{
							$objPHPExcel->getActiveSheet()->getStyle($cells[$j].$HeightestRow)->applyFromArray(
																										array(
																											'alignment' => array(
																												'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
																												'wrap' => true
																											),
																											'borders' => array(
																												'left'     => array(
																													'style' => PHPExcel_Style_Border::BORDER_MEDIUM
																												),
																												'right'  => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
																											),
																											'fill'  => array(
																												'type' => PHPExcel_Style_Fill::FILL_SOLID,
																												'color' => array('rgb' => 'D2D2D2')
																											  )
																										)
																								);
						}																	
						if(isset(${'array' . $j}) || !empty(${'array' . $j}) ){
							foreach(${'array' . $j} as $row){
								foreach($row as $k=>$v){
									if (array_key_exists($z, $v)) {
									 if($y!=''){
										if($k==0){
											if(($y==8) && ($mkNewArr[$j][$k][$z][$y]==5) ){
												$objPHPExcel->getActiveSheet()->SetCellValue('C'.($HeightestRow - 8), $mkNewArr[$j][$k][$z][10]);
												$objPHPExcel->getActiveSheet()->SetCellValue('C'.($HeightestRow - 6), $mkNewArr[$j][$k][$z][11]);
												$objPHPExcel->getActiveSheet()->SetCellValue('C'.($HeightestRow - 3), $mkNewArr[$j][$k][$z][12]);
											}else{
												$objPHPExcel->getActiveSheet()->SetCellValue('C'.$HeightestRow, $mkNewArr[$j][$k][$z][$y]);
											}
										}
									   if($k==1){
									   		if(($y==8) && ($mkNewArr[$j][$k][$z][$y]==5) ){
												$objPHPExcel->getActiveSheet()->SetCellValue('E'.($HeightestRow - 8), $mkNewArr[$j][$k][$z][10]);
												$objPHPExcel->getActiveSheet()->SetCellValue('E'.($HeightestRow - 6), $mkNewArr[$j][$k][$z][11]);
												$objPHPExcel->getActiveSheet()->SetCellValue('E'.($HeightestRow - 3), $mkNewArr[$j][$k][$z][12]);
											}else{
												$objPHPExcel->getActiveSheet()->SetCellValue('E'.$HeightestRow, $mkNewArr[$j][$k][$z][$y]);
											}
										}
									   if($k==2){
									   		if(($y==8) && ($mkNewArr[$j][$k][$z][$y]==5) ){
												$objPHPExcel->getActiveSheet()->SetCellValue('G'.($HeightestRow - 8), $mkNewArr[$j][$k][$z][10]);
												$objPHPExcel->getActiveSheet()->SetCellValue('G'.($HeightestRow - 6), $mkNewArr[$j][$k][$z][11]);
												$objPHPExcel->getActiveSheet()->SetCellValue('G'.($HeightestRow - 3), $mkNewArr[$j][$k][$z][12]);
											}else{
												$objPHPExcel->getActiveSheet()->SetCellValue('G'.$HeightestRow, $mkNewArr[$j][$k][$z][$y]);
											}
										}
									   if($k==3){
									   		if(($y==8) && ($mkNewArr[$j][$k][$z][$y]==5) ){
												$objPHPExcel->getActiveSheet()->SetCellValue('I'.($HeightestRow - 8), $mkNewArr[$j][$k][$z][10]);
												$objPHPExcel->getActiveSheet()->SetCellValue('I'.($HeightestRow - 6), $mkNewArr[$j][$k][$z][11]);
												$objPHPExcel->getActiveSheet()->SetCellValue('I'.($HeightestRow - 3), $mkNewArr[$j][$k][$z][12]);
											}else{
												$objPHPExcel->getActiveSheet()->SetCellValue('I'.$HeightestRow, $mkNewArr[$j][$k][$z][$y]);
											}
										}
									   if($k==4){
									   		if(($y==8) && ($mkNewArr[$j][$k][$z][$y]==5) ){
												$objPHPExcel->getActiveSheet()->SetCellValue('K'.($HeightestRow - 8), $mkNewArr[$j][$k][$z][10]);
												$objPHPExcel->getActiveSheet()->SetCellValue('K'.($HeightestRow - 6), $mkNewArr[$j][$k][$z][11]);
												$objPHPExcel->getActiveSheet()->SetCellValue('K'.($HeightestRow - 3), $mkNewArr[$j][$k][$z][12]);
											}else{
												$objPHPExcel->getActiveSheet()->SetCellValue('K'.$HeightestRow, $mkNewArr[$j][$k][$z][$y]);
											}
										}
									   if($k==5){
									   		if(($y==8) && ($mkNewArr[$j][$k][$z][$y]==5) ){
												$objPHPExcel->getActiveSheet()->SetCellValue('M'.($HeightestRow - 8), $mkNewArr[$j][$k][$z][10]);
												$objPHPExcel->getActiveSheet()->SetCellValue('M'.($HeightestRow - 6), $mkNewArr[$j][$k][$z][11]);
												$objPHPExcel->getActiveSheet()->SetCellValue('M'.($HeightestRow - 3), $mkNewArr[$j][$k][$z][12]);
											}else{
												$objPHPExcel->getActiveSheet()->SetCellValue('M'.$HeightestRow, $mkNewArr[$j][$k][$z][$y]);
											}
									    }
									  }
								    }	
							     }
							  }
					  		}
				     }
					   $HeightestRow++;
					}
					 //echo $HeightestRow; die;
					   $objPHPExcel->getActiveSheet()->removeRow(($HeightestRow -6), ($HeightestRow -1));
					   $HeightestRow = $HeightestRow -6;
					   for($i=0;$i<13;$i++){
					   if($i%2==0){
					   $objPHPExcel->getActiveSheet()->getStyle($cells[$i].$HeightestRow)->applyFromArray(
																										array(
																											'alignment' => array(
																												'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
																												'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
																											),
																											'borders' => array(
																												'left'     => array(
																													'style' => PHPExcel_Style_Border::BORDER_MEDIUM
																												),
																												'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                    																							'right'  => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
																												'top'  => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
																											)
																										)
																								);
						 }else{
						 $objPHPExcel->getActiveSheet()->getStyle($cells[$i].$HeightestRow)->applyFromArray(
																										array(
																											'alignment' => array(
																												'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
																												'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
																											),
																											'borders' => array(
																												'left'     => array(
																													'style' => PHPExcel_Style_Border::BORDER_MEDIUM
																												),
																												'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                    																							'right'  => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
																												'top'  => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
																											),
																											'fill'  => array(
																												'type' => PHPExcel_Style_Fill::FILL_SOLID,
																												'color' => array('rgb' => 'D2D2D2')
																											  ),
																										)
																								);
						  }		
						}																
					   $HeightestRow=$HeightestRow+1;
				}
			 }else{
			    $_SESSION['error_msg'] = "No data found.";
				$_SESSION['from']=$_POST['fromGenrtWR'];
				$_SESSION['to']=$_POST['toGenrtWR'];
				header('Location: weekly_report.php');
		    }
				$worksheet = $objPHPExcel->getActiveSheet();
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setPath('./images/barna_excel.png');
				$objDrawing->setResizeProportional(false);
				$objDrawing->setWidth(110);
				$objDrawing->setHeight(35);
				$objDrawing->setCoordinates('M2');
				$objDrawing->setWorksheet($worksheet);		
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment; filename="report_weekly.xls"');
				$objWriter->save('php://output');
	}
	break;
	case "generateWorkPlanReport":
			if(isset($_POST['fromGenrtWPR']) && $_POST['toGenrtWPR'] != '')
			{   
				require 'classes/PHPExcel.php';
				require_once 'classes/PHPExcel/IOFactory.php';
				$objPHPExcel = PHPExcel_IOFactory::load("work_plan_report.xlsx");
				$objPHPExcel->setActiveSheetIndex(0);
				$from = date("Y-m-d",strtotime($_POST['fromGenrtWPR']));
				$to = date("Y-m-d",strtotime($_POST['toGenrtWPR']));
				$dateStr='Desde '.$from.' hasta '.$to;
				$arraySessionNo = array(0 => 'Primera Sesión:',
										1 => 'Segunda Sesión:',
										2 => 'Tercera Sesión:',
										3 => 'Cuarta Sesión:',
										4 => 'Quinta Sesión:',
										5 => 'Sexta Sesión:',
										6 => 'Séptima Sesión:',
										7 => 'Octava Sesion:',
										8 => 'Novena Sesion:',
										9 => 'Decima Sesion:'
										);
				if(isset($_POST['slctProgram']) && $_POST['slctProgram'] !="" ){
					$programNameArr = explode('|', $_POST['slctProgram']);
					$programName  = $programNameArr[1];	
					$programId = $programNameArr[0];		
				}
				require_once('config.php');
				$objTime = new Timetable();
				//getting the allocated activities details
				$result = $objTime->getTeachersActivityInDateRange($from,$to,$programId);
				$i=0;
				$datePrgmArray=array();
				$reformRowArr = array();
				while($row = $result->fetch_assoc()){
						$reformRowArr[$row['date']][] = $row;
				}
				$rowNo = 8;
				//echo 'tot='.count($reformRowArr).'<br>';
				$totData = count($reformRowArr);
				$tot = 1;
				foreach($reformRowArr as $key=>$val){
						$valToMerge = $rowNo + count($val)-1;
						$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowNo, $key);
						$objPHPExcel->getActiveSheet()->mergeCells('B'.$rowNo.':B'.$valToMerge);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$rowNo.':B'.$valToMerge)->applyFromArray(	array(
																											'alignment' => array(
																												'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
																												'wrap' => true
																											),
																											'borders' => array(
																													'left'     => array(
																														'style' => PHPExcel_Style_Border::BORDER_THIN
																													),
																													'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN )
																												)
																										)
																								);
						$objPHPExcel->getActiveSheet()->getStyle('C'.$rowNo.':C'.$valToMerge)->applyFromArray(	array(
																											'borders' => array(
																													'left'     => array(
																														'style' => PHPExcel_Style_Border::BORDER_THIN
																													),
																													'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN )
																												)
																										)
																								);
						$objPHPExcel->getActiveSheet()->getStyle('D'.$rowNo.':D'.$valToMerge)->applyFromArray(	array(
																											'borders' => array(
																													'left'     => array(
																														'style' => PHPExcel_Style_Border::BORDER_THIN
																													),
																													'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN )
																												)
																										)
																								);
						$objPHPExcel->getActiveSheet()->getStyle('E'.$rowNo.':E'.$valToMerge)->applyFromArray(	array(
																											'borders' => array(
																													'left'     => array(
																														'style' => PHPExcel_Style_Border::BORDER_THIN
																													),
																													'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN )
																												)
																										)
																								);
						$objPHPExcel->getActiveSheet()->getStyle('F'.$rowNo.':F'.$valToMerge)->applyFromArray(	array(
																											'borders' => array(
																													'left'     => array(
																														'style' => PHPExcel_Style_Border::BORDER_THIN
																													),
																													'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN )
																												)
																										)
																								);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$rowNo.':G'.$valToMerge)->applyFromArray(	array(
																											'borders' => array(
																													'left'     => array(
																														'style' => PHPExcel_Style_Border::BORDER_THIN
																													),
																													'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN )
																												)
																										)
																								);
						$sesNo = 0;
						foreach($val as $dataArr){
							$timeslotArr = explode('-',$dataArr['timeslot']);
							
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowNo, trim($timeslotArr[0]));
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowNo, trim($timeslotArr[1]));
							//for recess activities 3 for recess, 4 for group activity and 5 for adhoc activity
							$specialActivityArr = array(3,4,5);
							if(in_array($dataArr['reserved_flag'], $specialActivityArr)){
								$objPHPExcel->getActiveSheet()->mergeCells('E'.$rowNo.':G'.$rowNo);
								$objPHPExcel->getActiveSheet()->getStyle('C'.$rowNo.':G'.$rowNo)->applyFromArray(	array(
																											'borders' => array(
																												   'left' => array('style' => PHPExcel_Style_Border::BORDER_NONE),
																												   'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																												   'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
																												)
																										)
																								);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowNo, $dataArr['special_activity_name']);
								$objPHPExcel->getActiveSheet()->getStyle('E'.$rowNo)->applyFromArray(array(
																											'alignment' => array(
																												'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
																												'wrap' => true
																											),
																										
																										'fill'  => array(
																												'type' => PHPExcel_Style_Fill::FILL_SOLID,
																												'color' => array('rgb' => 'D2D2D2')
																											  )
																										)
																								);
								$objPHPExcel->getActiveSheet()->getStyle('C'.$rowNo)->applyFromArray(array(
																										'fill'  => array(
																												'type' => PHPExcel_Style_Fill::FILL_SOLID,
																												'color' => array('rgb' => 'D2D2D2')
																											  )
																										)
																								);
								$objPHPExcel->getActiveSheet()->getStyle('D'.$rowNo)->applyFromArray(array(
																										'fill'  => array(
																												'type' => PHPExcel_Style_Fill::FILL_SOLID,
																												'color' => array('rgb' => 'D2D2D2')
																											  )
																										)
																								);
								$objPHPExcel->getActiveSheet()->getStyle('G'.$rowNo)->applyFromArray(array(
																										'fill'  => array(
																												'type' => PHPExcel_Style_Fill::FILL_SOLID,
																												'color' => array('rgb' => 'D2D2D2')
																											  )
																										)
																								);
							}else{
								//for normal activities
								$sessionNoText = utf8_encode('Sesión No: ');
								$textTechNote = utf8_encode('Nota Técnica: ');
								$textArea = utf8_encode('Área: ');
								$textSubName = utf8_encode('Módulo: ');
								$contentColumE = "Caso: ".$dataArr['case_number']."\n".$textTechNote.$dataArr['technical_notes'];
								$contentColumF = 'Prof: '.$dataArr['teacher_name']."\n".$textSubName.$dataArr['subject_name']."\n".$textArea.$dataArr['area_name']."\n".$sessionNoText.$dataArr['session_name']."\n".$dataArr['room_name'];
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowNo,utf8_encode($arraySessionNo[$sesNo]));
								$objPHPExcel->getActiveSheet()->getStyle('E'.$rowNo)->getFont()->setBold(true);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowNo, $contentColumE);
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowNo, $contentColumF);
								$sesNo++;
							}
							$objPHPExcel->getActiveSheet()->getStyle('B'.$rowNo)->applyFromArray(array(
																											'alignment' => array(
																												'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
																												'wrap' => true
																											)
																										)
																								);
							$objPHPExcel->getActiveSheet()->getStyle('C'.$rowNo)->applyFromArray(array(
																											'alignment' => array(
																												'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
																												'wrap' => true
																											)
																										)
																								);
							$objPHPExcel->getActiveSheet()->getStyle('D'.$rowNo)->applyFromArray(array(
																											'alignment' => array(
																												'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
																												'wrap' => true
																											)
																										)
																								);
							$objPHPExcel->getActiveSheet()->getStyle('E'.$rowNo)->applyFromArray(array(
																											'alignment' => array(
																												'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
																												'wrap' => true
																											)
																										)
																								);
							$objPHPExcel->getActiveSheet()->getStyle('F'.$rowNo)->applyFromArray(array(
																											'alignment' => array(
																												'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
																												'wrap' => true
																											)
																										)
																								);
							$objPHPExcel->getActiveSheet()->getStyle('G'.$rowNo)->applyFromArray(array(
																											'alignment' => array(
																												'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
																												'wrap' => true
																											)
																										)
																								);																																																																				
							$objPHPExcel->getActiveSheet()->getStyle('D8')->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle('E8')->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle('F8')->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle('G8')->getAlignment()->setWrapText(true);
							$rowNo = $rowNo+1;
						}
						$objPHPExcel->getActiveSheet()->mergeCells('B'.$rowNo.':G'.$rowNo);
						$nextRow = $rowNo+1;
						$objPHPExcel->getActiveSheet()->mergeCells('B'.$nextRow.':G'.$nextRow);
						$objPHPExcel->getActiveSheet()->mergeCells('B'.$rowNo.':B'.$nextRow);
						if($tot != $totData){
							$rowNo = $rowNo+2;
							$objPHPExcel->getActiveSheet()->getStyle('B'.$rowNo)->applyFromArray(array(	'fill'  => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'B8CCE4')),'alignment' => array(
																													'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
																													'wrap' => true
																												),'borders' => array(
																													'left'     => array(
																														'style' => PHPExcel_Style_Border::BORDER_THIN
																													),
																													'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN )
																												)));
							$objPHPExcel->getActiveSheet()->getStyle('C'.$rowNo)->applyFromArray(array(	'fill'  => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'B8CCE4')),'alignment' => array(
																													'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
																													'wrap' => true
																												),'borders' => array(
																													'left'     => array(
																														'style' => PHPExcel_Style_Border::BORDER_THIN
																													),
																													'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
																												)));
							$objPHPExcel->getActiveSheet()->getStyle('D'.$rowNo)->applyFromArray(array(	'fill'  => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'B8CCE4')),'alignment' => array(
																													'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
																													'wrap' => true
																												),'borders' => array(
																													'left'     => array(
																														'style' => PHPExcel_Style_Border::BORDER_THIN
																													),
																													'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
																												)));
							$objPHPExcel->getActiveSheet()->getStyle('E'.$rowNo)->applyFromArray(array(	'fill'  => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'B8CCE4')),'alignment' => array(
																													'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
																													'wrap' => true
																												),'borders' => array(
																													'left'     => array(
																														'style' => PHPExcel_Style_Border::BORDER_THIN
																													),
																													'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
																												)));
							$objPHPExcel->getActiveSheet()->getStyle('F'.$rowNo)->applyFromArray(array(	'fill'  => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'B8CCE4')),'alignment' => array(
																													'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
																													'wrap' => true
																												),'borders' => array(
																													'left'     => array(
																														'style' => PHPExcel_Style_Border::BORDER_THIN
																													),
																													'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
																												)));
							$objPHPExcel->getActiveSheet()->getStyle('G'.$rowNo)->applyFromArray(array(	'fill'  => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'B8CCE4')),'alignment' => array(
																													'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
																													'wrap' => true
																												),'borders' => array(
																													'left'     => array(
																														'style' => PHPExcel_Style_Border::BORDER_THIN
																													),
																													'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
																													'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
																												)));
							
							$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowNo, utf8_encode('Día'));
							$objPHPExcel->getActiveSheet()->getStyle('B'.$rowNo)->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowNo, utf8_encode('Comienzo'));
							$objPHPExcel->getActiveSheet()->getStyle('C'.$rowNo)->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowNo, utf8_encode('Final'));
							$objPHPExcel->getActiveSheet()->getStyle('D'.$rowNo)->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowNo, utf8_encode('Distribución'));
							$objPHPExcel->getActiveSheet()->getStyle('E'.$rowNo)->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowNo, utf8_encode('Materiales'));
							$objPHPExcel->getActiveSheet()->getStyle('F'.$rowNo)->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowNo, utf8_encode('Profesor/Área/Sesión'));
							$objPHPExcel->getActiveSheet()->getStyle('G'.$rowNo)->getFont()->setBold(true);
							$rowNo = $rowNo+1;
							$tot = $tot+1;
						}
				} 
				$objPHPExcel->getActiveSheet()->SetCellValue('E2', $programName);
				$objPHPExcel->getActiveSheet()->SetCellValue('E4', $dateStr);
				$worksheet = $objPHPExcel->getActiveSheet();
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setPath('./images/barna_excel.png');
				$objDrawing->setResizeProportional(false);
				$objDrawing->setWidth(110);
				$objDrawing->setHeight(35);
				$objDrawing->setCoordinates('M2');
				$objDrawing->setWorksheet($worksheet);		
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment; filename="work_plan_report.xls"');
				$objWriter->save('php://output');
	}
	break;
 }
}
?>