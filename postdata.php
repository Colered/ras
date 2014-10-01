<?php
require_once('config.php');
if (isset($_POST['form_action']) && $_POST['form_action']!=""){
	$formPost = $_POST['form_action'];
	switch ($formPost) {
		case 'Login':
			//conditions for user login
			if($_POST['txtUName']!="" && $_POST['txtPwd']!="" ){
				$obj = new Users();
				$resp = $obj->userLogin();
				$location = ($resp == 1) ? "timetable_dashboard.php" : "index.php";
				header('Location: '.$location);
			}else{
				$message="Please enter username and password";
				$_SESSION['error_msg'] = $message;
				header('Location: index.php');
			}
		break;
		case 'addEditArea':
			//adding new areas
			if($_POST['txtAreaName']!="" && $_POST['txtAreaCode']!="" ){
				$obj = new Areas();
				if(isset($_POST['areaId']) && $_POST['areaId']!=''){
					//update area
					$resp = $obj->updateArea();
				}else{
					//add new area
					$resp = $obj->addArea();
				}
				if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					echo "<form name='formarea' method='post' action='areas.php'>";
					reset($_POST);
					while(list($iname,$ival) = each($_POST)) {
						echo "<input type='hidden' name='$iname' value='$ival'>";
					}
					echo "</form>";
					echo "</body></html>";
					echo"<script language='JavaScript'>function submit_back(){ window.document.formarea.submit();}submit_back();</script>";
					exit();
					//end return back
				}else{
					header('Location: areas_view.php');
					exit();
				}
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: areas.php');
			}
		break;
		case 'addEditBuild':
			if($_POST['txtBname']!="" ){
				$obj = new Buildings();
				if(isset($_POST['buldId']) && $_POST['buldId']!=''){
					//update new building
					$resp = $obj->updateBuld();
				}else{
					//add new building
					$resp = $obj->addBuilding();
				}
				if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					echo "<form name='formbuild' method='post' action='buildings.php'>";
					reset($_POST);
					while(list($iname,$ival) = each($_POST)) {
						echo "<input type='hidden' name='$iname' value='$ival'>";
					}
					echo "</form>";
					echo "</body></html>";
					echo"<script language='JavaScript'>function submit_back(){ window.document.formbuild.submit();}submit_back();</script>";
					exit();
					//end return back
				}else{
					header('Location: buildings_view.php');
					exit();
				}
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: buildings.php');
			}
		break;
		case "add_edit_professor":
			//add and edit professor
		  if(trim($_POST['txtPname'])!="" ){
				$obj = new Teacher();
				if(isset($_POST['form_edit_id']) && $_POST['form_edit_id']!=''){
					$resp = $obj->editProfessor();
					header('Location: teacher_view.php');
					exit();
				}else{
					$resp = $obj->addProfessor();
					if($resp==0){
						//return back data to the form
						echo "<html><head></head><body>";
						echo "<form name='form55' method='post' action='professor.php'>";
						reset($_POST);
						while(list($iname,$ival) = each($_POST)) {
							echo "<input type='hidden' name='$iname' value='$ival'>";
						}
						echo "</form>";
						echo "</body></html>";
						echo"<script language='JavaScript'>function submit_back(){ window.document.form55.submit();}submit_back();</script>";
						exit();
					//end return back
					}else{
						header('Location: teacher_view.php');
						exit();
					}
				}
		   }else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: buildings.php');
		   }
		break;
		case "add_program":
			//adding new areas
			if(trim($_POST['txtPrgmName'])!="" && !empty($_POST['slctUnit']) && $_POST['slctPrgmType']<>''){
				$obj = new Programs();
				$resp = $obj->addProgram();

				if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					echo "<form name='form55' method='post' action='programs.php'>";
					reset($_POST);
					while(list($iname,$ival) = each($_POST)) {
					    if($iname=='slctDays1' || $iname=='slctDays2' || $iname=='slctDays3' || $iname=='slctUnit'){
					        foreach($_POST[$iname] as $value){
							  echo '<input type="hidden" name="'.$iname.'[]" value="'. $value. '">';
							}
					    }else{
							echo "<input type='hidden' name='$iname' value='$ival'>";
						}
					}
					echo "</form>";
					echo "</body></html>";
					echo"<script language='JavaScript'>function submit_back(){ window.document.form55.submit();}submit_back();</script>";
					exit();
				//end return back
				}else{
					header('Location: programs_view.php');
					exit();
				}

			}else{
				$message="Please fill all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: programs.php');
			}
		break;
		case "edit_program":
			//adding new areas
			if(isset($_POST['programId']) && $_POST['programId']<>'' && !empty($_POST['slctUnit']) && $_POST['slctPrgmType']<>''){
				$obj = new Programs();
				$resp = $obj->editProgram();
				if($resp==0){
					header('Location: programs.php?edit='.$_POST['programId']);
					exit();
				}else{
					header('Location: programs_view.php');
					exit();
				}
			}else{
				$message="Please fill all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: programs.php');
			}
		break;
		case 'addEditClassroom':
			//adding new areas
			if(isset($_POST['txtRmName']) && $_POST['txtRmName']!="" ){
				$obj = new Classroom();
				if(isset($_POST['roomId']) && $_POST['roomId']!=''){
					//update area
					$resp = $obj->updateRoom();
				}else{
					//add new area
					$resp = $obj->addRoom();
				}
				if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					echo "<form name='formroom' method='post' action='rooms.php'>";
					reset($_POST);
					while(list($iname,$ival) = each($_POST)) {
						echo "<input type='hidden' name='$iname' value='$ival'>";
					}
					echo "</form>";
					echo "</body></html>";
					echo"<script language='JavaScript'>function submit_back(){ window.document.formroom.submit();}submit_back();</script>";
					exit();
					//end return back
				}else{
					header('Location: rooms_view.php');
					exit();
				}
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: rooms.php');
			}
		break;
		case 'addEditSubject':
		//adding new subject
			if($_POST['txtSubjName']!="" && $_POST['txtSubjCode']!="" ){
				$obj = new Subjects();
				if(isset($_POST['subjectId']) && $_POST['subjectId']!=''){
					//update subject
					$resp = $obj->updateSubject();
				}else{
					//add new subject
					$resp = $obj->addSubject();
				}
				if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					echo "<form name='formsubject' method='post' action='subjects.php'>";
					reset($_POST);
					while(list($iname,$ival) = each($_REQUEST)) {
						echo "<input type='hidden' name='$iname' value='$ival'>";
					}
					echo "</form>";
					echo "</body></html>";
					echo"<script language='JavaScript'>function submit_back(){ window.document.formsubject.submit();}submit_back();</script>";
					exit();
					//end return back
				}else{
					header('Location: subject_view.php');
					exit();
				}
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: subjects.php');
			}
		break;
		case "add_edit_program_group":
			//add and edit program groups
			$obj = new Programs();
			$resp = $obj->associateStudentGroup();
			header('Location: program_group_view.php');
			exit();
		break;
		//add edit master group
		case 'addEditGroup':
			if($_POST['txtGname']!="" ){
				$obj = new Groups();
				if(isset($_POST['groupId']) && $_POST['groupId']!=''){
					//update group
					$resp = $obj->updateGroup();
				}else{
					//add new group
					$resp = $obj->addGroup();
				}
				if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					echo "<form name='formbuild' method='post' action='group.php'>";
					reset($_POST);
					while(list($iname,$ival) = each($_POST)) {
						echo "<input type='hidden' name='$iname' value='$ival'>";
					}
					echo "</form>";
					echo "</body></html>";
					echo"<script language='JavaScript'>function submit_back(){ window.document.formbuild.submit();}submit_back();</script>";
					exit();
					//end return back
				}else{
					header('Location: group_view.php');
					exit();
				}
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: group.php');
			}
		break;
		//add timeslot
		case 'addTimeslot':
			if($_POST['start_time']!="" && $_POST['end_time']!="" ){
				$obj = new Timeslot();
				//add new timeslot
				$resp = $obj->addTimeslot();
				if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					echo "<form name='formbuild' method='post' action='timeslots.php'>";
					reset($_POST);
					while(list($iname,$ival) = each($_POST)) {
						echo "<input type='hidden' name='$iname' value='$ival'>";
					}
					echo "</form>";
					echo "</body></html>";
					echo"<script language='JavaScript'>function submit_back(){ window.document.formbuild.submit();}submit_back();</script>";
					exit();
					//end return back
				}else{
					header('Location: timeslots.php');
					exit();
				}
			}else{
				$message="Please enter a valid timeslot";
				$_SESSION['error_msg'] = $message;
				header('Location: timeslots.php');
			}
		break;
		case "add_teacher_activity":
		     $objT = new Teacher();
             if($_POST['slctProgram']<>"" && $_POST['slctSubject']<>"" && !empty($_POST['slctTeacher'])){
                   //add activities in DB
                   $resp = $objT->addActivities();
                   if($resp==1){
					  header('Location: teacher_activity_view.php');
					  exit();
                   }else{
                      header('Location: teacher_activity.php');
					  exit();
                   }
             }
		break;
		case "edit_teacher_activity":
			 $objT = new Teacher();
			 if($_POST['form_edit_id']<>"" && $_POST['program_year_id']<>"" && $_POST['subject_id']<>"" && $_POST['sessionid']<>""){
					//edit activities in DB
					$resp = $objT->editActivities();
					header('Location: teacher_activity_view.php');
					exit();
			 }
		break;
		case "addEditClassAvailability":
		if($_POST['slctRmName']!="" && $_POST['slctRmType']!="" ){
				$obj = new Classroom_Availability();
				//add new clasroom availability
				$resp = $obj->addClassroomAvail();
				if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					echo "<form name='formsubject' method='post' action='classroom_availability.php'>";
					reset($_POST);
					while(list($iname,$ival) = each($_REQUEST)) {
						echo "<input type='hidden' name='$iname' value='$ival'>";
					}
					echo "</form>";
					echo "</body></html>";
					echo"<script language='JavaScript'>function submit_back(){ window.document.formsubject.submit();}submit_back();</script>";
					exit();
					//end return back
				}else{
					header('Location: classroom_availability_view.php');
					exit();
				}
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: classroom_availability_view.php');
			}
		break;
		//add-edit teacher availability
		case 'addEditTeacherAvailability':
			if(($_POST['slctTeacher']!="") && ( isset($_POST['ruleval']) || isset($_POST['exceptionDate']))){
					$obj = new Teacher();
					$resp = $obj->addUpdateTeacAvail();
					if($resp==0){
						//return back data to the form
						echo "<html><head></head><body>";
						echo "<form name='formbuild' method='post' action='teacher_availability.php'>";
						reset($_POST);
						while(list($iname,$ival) = each($_POST)) {
							echo "<input type='hidden' name='$iname' value='$ival'>";
						}
						echo "</form>";
						echo "</body></html>";
						echo"<script language='JavaScript'>function submit_back(){ window.document.formbuild.submit();}submit_back();</script>";
						exit();
						//end return back
					}else{
						header('Location: teacher_availability_view.php');
						exit();
				}
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: teacher_availability.php');
			}
		break;
		//Generate timetable
		case 'generateTimetable':
			if($_POST['txtAName'] != "" && $_POST['fromGenrtTmtbl'] != "" &&  $_POST['toGenrtTmtbl'] != "")
			{
				$obj = new Timetable();
				$fromGenrtTmtbl = $_POST['fromGenrtTmtbl'];
				$toGenrtTmtbl = $_POST['toGenrtTmtbl'];
				$name = $_POST['txtAName'];
				$start_date = date('Y-m-d', strtotime($_POST['fromGenrtTmtbl']));
				$end_date = date('Y-m-d', strtotime($_POST['toGenrtTmtbl']));
				if(!$obj->checkName($_POST['txtAName']))
				{

					$from_time = date('Y', strtotime($_POST['fromGenrtTmtbl']));
					$output_array = $obj->generateTimetable($start_date, $end_date, $from_time);
					//print"<pre>";print_r($output_array);die;


					if(isset($output_array['program_not_found'])){
						$_SESSION['error_msg'] = $output_array['program_not_found'];
					}elseif(isset($output_array['teacher_not_found'])){
						$_SESSION['error_msg'] = $output_array['teacher_not_found'];
					}elseif(isset($output_array['timeslot_not_found'])){
						$_SESSION['error_msg'] = $output_array['timeslot_not_found'];
					}else{
						$_SESSION['error_msg'] = $output_array['system_error'];
					}

					if(isset($_SESSION['error_msg']))
					{
						header('Location: generate_timetable.php?fromGenrtTmtbl='.$fromGenrtTmtbl.'&toGenrtTmtbl='.$toGenrtTmtbl.'&name='.$name);
					}
					if($output_array)
					{
						$obj->deleteData();
						$res = $obj->addTimetable($_POST['txtAName'], $start_date, $end_date);
						if($res)
						{
							foreach($output_array as $key=>$value)
							{
								foreach($value as $newkey=>$val)
								{
									$timeslot = $newkey;
									for($cnt=0;$cnt<count($val);$cnt++)
									{
										$tt_id = $res;
										$activity_id = $val[$cnt]['activity_id'];
										$program_year_id = $val[$cnt]['program_year_id'];
										$teacher_id = $val[$cnt]['teacher_id'];
										$group_id = $val[$cnt]['group_id'];
										$room_id = $val[$cnt]['room_id'];
										$session_id = $val[$cnt]['session_id'];
										$room_name = $val[$cnt]['room_name'];
										$name = $val[$cnt]['name'];
										$program_name = $val[$cnt]['program_name'];
										$subject_name = $val[$cnt]['subject_name'];
										$session_name = $val[$cnt]['session_name'];
										$teacher_name = $val[$cnt]['teacher_name'];
										$subject_id = $val[$cnt]['subject_id'];
										$description = $program_name."-".$subject_name."-".$session_name."-".$teacher_name;
										$date = $val[$cnt]['date'];
										$date_add = date("Y-m-d H:i:s");
										$date_upd = date("Y-m-d H:i:s");

										$resp = $obj->addTimetableDetail($timeslot, $tt_id, $activity_id, $program_year_id, $teacher_id, $group_id, $room_id, $session_id, $subject_id, $date, $date_add, $date_upd);
										if($resp)
										{
											$ts_array = explode("-", $timeslot);
											$entry_time = $ts_array['0'];
											$duration = ($ts_array['1']-$ts_array['0'])*60;
											$entry_array = explode(":", $entry_time);
											$entry_hour = $entry_array['0'];
											$entry_minute = $entry_array['1'];

											if($entry_hour == '1')
												$entry_hour = 13;
											if($entry_hour == '2')
												$entry_hour = 14;

											$date_array = explode("-", $date);
											$year = $date_array['0'];
											$month = $date_array['1'];
											$day = $date_array['2'];
											$zone=3600*+5;//India
											$eventstart = gmmktime ( $entry_hour, $entry_minute, 0, $month, $day, $year );
											$cal_time = gmdate('His', $eventstart + $zone);
											$cal_id = $obj->addWebCalEntry($date, $cal_time, $name, $room_name, $description,$duration, $teacher_id, $subject_id, $room_id, $program_year_id);
											if($cal_id){
												$obj->addWebCalEntryUser($cal_id);

											}
										}
									}
								}
							}
							header('Location: timetable_view.php');
						}
					}
				}else{
					$message="Timetable with this name already exist in database. Please choose a new one.";
					$_SESSION['error_msg'] = $message;
					header('Location: generate_timetable.php?fromGenrtTmtbl='.$fromGenrtTmtbl.'&toGenrtTmtbl='.$toGenrtTmtbl.'&name='.$name);
				}
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: generate_timetable.php');
			}
			break;
			//add edit holiday
			case 'addEditHoliday':
			if($_POST['holiday_date']!="" ){
				$obj = new Holidays();
				if(isset($_POST['holidayId']) && $_POST['holidayId']!=''){
					//update a holiday
					$resp = $obj->updateholiday();
				}else{
					//add new holiday
					$resp = $obj->addHoliday();
				}
				if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					echo "<form name='formbuild' method='post' action='holidays.php'>";
					reset($_POST);
					while(list($iname,$ival) = each($_POST)) {
						echo "<input type='hidden' name='$iname' value='$ival'>";
					}
					echo "</form>";
					echo "</body></html>";
					echo"<script language='JavaScript'>function submit_back(){ window.document.formbuild.submit();}submit_back();</script>";
					exit();
					//end return back
				}else{
					header('Location: holidays_view.php');
					exit();
				}
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: holidays.php');
			}
		break;

		case "add_edit_cycles":
		 if(isset($_POST['programId'])){

		 	 $objP = new Programs();

			 $resp = $objP->addEditCycles();
			 if(!$resp){
				header('Location: program_cycles_view.php');
			 }

		 }

		break;

	}
}
?>