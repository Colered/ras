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
		case 'addEditLoc':
			if($_POST['txtLname']!="" ){
				$obj = new Locations();
				if(isset($_POST['locId']) && $_POST['locId']!=''){
					//update new building
					$resp = $obj->updateLoc();
				}else{
					//add new building
					$resp = $obj->addLocation();
				}
				if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					echo "<form name='formloc' method='post' action='locations.php'>";
					reset($_POST);
					while(list($iname,$ival) = each($_POST)) {
						echo "<input type='hidden' name='$iname' value='$ival'>";
					}
					echo "</form>";
					echo "</body></html>";
					echo"<script language='JavaScript'>function submit_back(){ window.document.formloc.submit();}submit_back();</script>";
					exit();
					//end return back
				}else{
					header('Location: locations_view.php');
					exit();
				}
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: locations.php');
			}
		break;
		case "add_edit_professor":
			//add and edit professor
		  if(trim($_POST['txtPname'])!="" ){
				$obj = new Teacher();
				if(isset($_POST['form_edit_id']) && $_POST['form_edit_id']!=''){
					$resp = $obj->editProfessor();
					$action = 'professor.php?edit='.$_POST['form_edit_id'];
				}else{
					$resp = $obj->addProfessor();
				}
				if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					echo "<form name='form55' method='post' action='$action'>";
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
			if($_POST['txtSubjName']!="" && $_POST['slctProgram']!="" && $_POST['slctCycle']!="" && $_POST['slctArea']!="" ){
				$obj = new Subjects();
				
				if(isset($_POST['cloneId']) && $_POST['cloneId']!=''){
					//update subject
					$resp = $obj->addSubject();
				}else if(isset($_POST['subjectId']) && $_POST['subjectId']!='' && !isset($_POST['cloneId']) && $_POST['cloneId']==''){
					//update subject
					$resp = $obj->updateSubject();
				}else{
					//add new subject
					$resp = $obj->addSubject();
				}
				if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					if(isset($_POST['cloneId']) && $_POST['cloneId']!=''){
						$urlPath = "subjects.php?clone=".$_POST['cloneId'];
						echo "<form name='formsubject' method='post' action='$urlPath'>";
					}else{
						echo "<form name='formsubject' method='post' action='subjects.php'>";
					}
					
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
			case 'addEditSession':
				print_r($_POST); die;
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
		case "forgotPwd":
		 if(isset($_POST['email']) && $_POST['email']!=""){
			 $obj = new Users();
			 $resp = $obj->forgotPwd();
			 header('Location: forgot.php');
		}

		break;
		case "changePwd":
		 if(isset($_POST['currentPassword']) && $_POST['currentPassword']!=""){
			 $obj = new Users();
			 $resp = $obj->changePwd();
			 if($resp){
			 	session_destroy();
				session_start();
				$message= "New password has been updated successfully";
				$_SESSION['succ_msg'] = $message;
			 	header('Location: index.php');
			 }else{
			 	header('Location: change_password.php');
			 }
		}
		break;
		case "acceptAllocation":
			if(isset($_POST['btnacceptallo']) && $_POST['btnacceptallo'] != '')
			{
				$objTime = new Timetable();
				$objT = new Teacher();								
				$resp = $objTime->checkTimetable();	
				while($row = mysqli_fetch_array($resp))
				{
					$all_ts = $objT -> getTimeslotId($row['timeslot']);
					$time = explode(",",$all_ts);
					$start_time = $time[0];
					$objTime->updateTeachAct($row['activity_id'],$row['room_id'],$row['date'],$all_ts,$start_time,$row['date_upd']);	
				}
				header('Location: teacher_activity_view.php');
			}
		break;
		case "uploadSession":
			print_r($_POST);
			print_r($_FILES);
			 die;
		require_once 'PHPExcel/IOFactory.php';
		$objPHPExcel = PHPExcel_IOFactory::load("MyExcel.xlsx");
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$worksheetTitle     = $worksheet->getTitle();
			$highestRow         = $worksheet->getHighestRow(); // e.g. 10
			$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			$nrColumns = ord($highestColumn) - 64;
			echo "<br>The worksheet ".$worksheetTitle." has ";
			echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
			echo ' and ' . $highestRow . ' row.';
			echo '<br>Data: <table border="1"><tr>';
			for ($row = 1; $row <= $highestRow; ++ $row) {
				echo '<tr>';
				for ($col = 0; $col < $highestColumnIndex; ++ $col) {
					$cell = $worksheet->getCellByColumnAndRow($col, $row);
					$val = $cell->getValue();
					$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
					echo '<td>' . $val . '<br>(Typ ' . $dataType . ')</td>';
				}
				echo '</tr>';
			}
			echo '</table>';
		}		
		break;
		case "addEditSpecialActivity":
			$obj=new SpecialActivity();
			if((isset($_POST['special_act_id']) && $_POST['special_act_id']!='') || (isset($_POST['special_sp_act_name']) && $_POST['special_sp_act_name']!='')){
				$resp = $obj->updateSpecialActivity();//update a SpecialActivity
			}else{
				$resp = $obj->addSpecialActivity();//add new SpecialActivity
			}
			if($resp){
				header('Location: special_activity_view.php');
			}else{
				header('Location: special_activity.php');
			}
		break;
		case 'addEditUser':
			//adding new user
			if($_POST['txtUserName']!="" && $_POST['txtUserPwd']!="" && $_POST['txtUserEmail']!="" && $_POST['slctUserType']!=""){
				$obj = new Users();
				if(isset($_POST['userId']) && $_POST['userId']!=''){
					//update user
					$resp = $obj->updateUser();
				}else{
					//add new user
					$resp = $obj->addUser();
				}
				if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					echo "<form name='formuser' method='post' action='user_add.php'>";
					reset($_POST);
					while(list($iname,$ival) = each($_POST)) {
						echo "<input type='hidden' name='$iname' value='$ival'>";
					}
					echo "</form>";
					echo "</body></html>";
					echo"<script language='JavaScript'>function submit_back(){ window.document.formuser.submit();}submit_back();</script>";
					exit();
					//end return back
				}else{
					header('Location: user_view.php');
					exit();
				}
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: user_add.php');
			}
		break;	
		case 'addEditRole':
			if($_POST['txtRname']!="" ){
				$obj = new Users();
				if(isset($_POST['role_id']) && $_POST['role_id']!=''){
					//update new building
					$resp = $obj->updateRole();
				}else{
					//add new building
					$resp = $obj->addRole();
				}
				if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					echo "<form name='formRole' method='post' action='role_add.php'>";
					reset($_POST);
					while(list($iname,$ival) = each($_POST)) {
						echo "<input type='hidden' name='$iname' value='$ival'>";
					}
					echo "</form>";
					echo "</body></html>";
					echo"<script language='JavaScript'>function submit_back(){ window.document.formRole.submit();}submit_back();</script>";
					exit();
					//end return back
				}else{
					header('Location: role_view.php');
					exit();
				}
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: role_add.php');
			}
		break;
		case "clone_program":
			//adding cloned programs
			//print"<pre>";print_r($_POST['programcycles'][5]['slctNumcycle']);DIE("here");
			//$week1 = '';$week2 = '';
			if(isset($_POST) && $_POST['form_action'] == 'clone_program'){
				$obj = new Programs();
				$result = $obj->addClonedProgram();
				$k=1;
				foreach($_POST['programcycles'] as $key=>$value)
				{
					//print"<pre>";print_r($value);
					//echo $value['slctNumcycle'];die;
					if($value['slctNumcycle'] != '')
					{
						for($i=1; $i<=$value['slctNumcycle']; $i++)
						{
							$start_date = date("Y-m-d", strtotime($value['startweek'.$i]));
							$end_date = date("Y-m-d", strtotime($value['endweek'.$i]));
							$chweek = $value['c1chWeek'.$i];
							if($chweek == '1w')
							{
								$obj->addCycles($result[$k],$value['slctNumcycle'],$start_date,$end_date,$chweek,$value['cycle'.$i]['week1'],'');
							}else{
								$obj->addCycles($result[$k],$value['slctNumcycle'],$start_date,$end_date,$chweek,$value['cycle'.$i]['week1'],$value['cycle'.$i]['week2']);
							}
							foreach($value['exceptionDate'.$i] as $exceptionDate)
							{
								$exceptionDate = date("Y-m-d",strtotime($exceptionDate));
								$currentDateTime = date("Y-m-d H:i:s");
								$obj->addException($result[$k],$i,$exceptionDate,$currentDateTime);								
							}
							for($j=0; $j<count($value['additionDate'.$i]); $j++)
							{
								$additionDate = date("Y-m-d",strtotime($value['additionDate'.$i][$j]));
								$timeslot_id = $value['time_slot'.$i][$j];
								$actual_timeslot_id = $value['actual_time_slot'.$i][$j];
								$currentDateTime = date("Y-m-d H:i:s");
								$obj->addAddition($result[$k],$i,$additionDate,$timeslot_id,$actual_timeslot_id,$currentDateTime);
							}
						}
					}
				$k++;
				}
				header('Location: program-clone2.php?clone='.$_POST['programId'].'&id='.base64_encode($result[0]));
			}
		break;
	}
}
?>