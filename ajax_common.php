<?php
require_once('config.php');
$options = '';
$codeBlock = trim($_POST['codeBlock']);
switch ($codeBlock) {
    case "del_area":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$del_area_query="delete from area where id='".$id."'";
			$qry = mysqli_query($db, $del_area_query);
			if(mysqli_affected_rows($db)>0)
				echo 1;
			else
				echo 0;
		}
    break;
	case "del_teacher":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$del_query="delete from teacher where id='".$id."'";
			$qry = mysqli_query($db, $del_query);
			if(mysqli_affected_rows($db)>0)
				echo 1;
			else
				echo 0;
		}
	 break;
	 case "del_buld":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$del_area_query="delete from building where id='".$id."'";
			$qry = mysqli_query($db, $del_area_query);
			if(mysqli_affected_rows($db)>0)
				echo 1;
			else
				echo 0;
		}
	break;
	case "del_program":
	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$del_query="delete from program where id='".$id."'";
		$qry = mysqli_query($db, $del_query);
		if(mysqli_affected_rows($db)>0){
		    // delete all the cycles related to this program
		    $del_cycle_query="delete from cycle where program_id='".$id."'";
		    mysqli_query($db, $del_cycle_query);
			// delete all the program years related to this program
			$del_cycle_query="delete from program_years where program_id='".$id."'";
			$qry = mysqli_query($db, $del_cycle_query);
		    //delete associated groups
			$del_pg_query="delete from program_group where program_year_id in(select id from program_years where program_id='".$id."')";
			mysqli_query($db, $del_pg_query);

			echo 1;
		}else{
			echo 0;
	    }
	}
	break;
	case "del_subject":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$sclt_query="select * from subject_session where subject_id='".$id."'";
			$session_detail_qry = mysqli_query($db, $sclt_query);
			if(mysqli_affected_rows($db)>0){
			   $del_subject_query="DELETE subject,subject_session  FROM subject  INNER JOIN subject_session WHERE subject.id= subject_session.subject_id and subject.id = '".$id."'";
			   $qry = mysqli_query($db, $del_subject_query);
			   if(mysqli_affected_rows($db)>0)
				   echo 1;
			   else
				   echo 0;
		   	}else{
			$del_subject_query="delete from subject where id='".$id."'";
			$qry = mysqli_query($db, $del_subject_query);
				if(mysqli_affected_rows($db)>0)
					echo 1;
				else
					echo 0;
			}
		}
    break;
	case "getRooms":
		if(isset($_POST['roomTypeValue']) && $_POST['roomTypeValue']!=""){
			$room_type_val=explode(",",$_POST['roomTypeValue']);
			for($i=0;$i<count($room_type_val);$i++){
				$room_val=explode("#",$room_type_val[$i]);
				$room_type_id=$room_val['0'];
				$room_type_name=$room_val['1'];
				$options .='<option value="">--Select Room--</option>';
				$room_query="select id,room_name from  room where room_type_id='".trim($room_type_id)."'";
				$qry = mysqli_query($db, $room_query);
				while($room_data= mysqli_fetch_array($qry)){
				  $selected = ($_POST['roomId'] == $room_data['id']) ? ' selected="selected"' : '';

				  $options .='<option value="'.$room_data['id'].'" '.$selected.' >'.$room_data['room_name'].'</option>';
				 }
			}
		}
		echo $options;
	break;
	case "del_room":
	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$del_room_query="delete from room where id='".$id."'";
		$qry = mysqli_query($db, $del_room_query);
		if(mysqli_affected_rows($db)>0)
			echo 1;
		else
			echo 0;
	}
    break;
	case "del_group":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$del_area_query="delete from group_master where id='".$id."'";
			$qry = mysqli_query($db, $del_area_query);
			if(mysqli_affected_rows($db)>0)
				echo 1;
			else
				echo 0;
		}
	break;
	case "getGroups":
	    $options = '';
	    $dataArr = array();
		if(isset($_POST['program_id']) && $_POST['program_id']!=""){
		    //fetch all the groups related to a program
		    $query="SELECT * FROM program_group WHERE program_year_id='".$_POST['program_id']."'";
			$result = mysqli_query($db, $query);
			while($data= mysqli_fetch_array($result)){
				 $dataArr[] = $data['group_id'];
			}
	    }
		$query="select id,name from group_master";
		$result = mysqli_query($db, $query);
		while($data= mysqli_fetch_array($result)){
			 $selected = in_array($data['id'],$dataArr) ? "selected":"";
			 $options .='<option value="'.$data['id'].'" '.$selected.'>'.$data['name'].'</option>';
		}
		echo $options;
	break;
	case "del_associated_prog_group":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$del_query="delete from program_group where program_year_id='".$id."'";
			$qry = mysqli_query($db, $del_query);
			if(mysqli_affected_rows($db)>0)
				echo 1;
			else
				echo 0;
		}
    break;
	case "del_timeslot":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$del_timeslot_query="delete from timeslot where id='".$id."'";
			$qry = mysqli_query($db, $del_timeslot_query);
			if(mysqli_affected_rows($db)>0)
				echo 1;
			else
				echo 0;
		}
	break;
	case "del_activity":
		if(isset($_POST['activityId']) && isset($_POST['sessionID'])){
			$activityId = $_POST['activityId'];
			//check if activity id is o means there is no activity so simply delete the session
			if($activityId==0){
				$del_session="delete from subject_session where id='".$_POST['sessionID']."'";
				$qry = mysqli_query($db, $del_session);
				if(mysqli_affected_rows($db)>0){
					echo 1;
				}else{
					echo 0;
				}
			}else{
				//check if some other activities exists for the session
				$del_activity_query="select session_id from teacher_activity where session_id = '".$_POST['sessionID']."' and id!='".$_POST['activityId']."'";
				$qry = mysqli_query($db, $del_activity_query);
				if(mysqli_affected_rows($db)>0){
					//delete only activity not the session 
					$del_act_query="delete from teacher_activity where id='".$_POST['activityId']."'";
					$qry = mysqli_query($db, $del_act_query);
					if(mysqli_affected_rows($db)>0)
						echo 1;
					else
						echo 0;
				}else{
					//session also needs to be deleted as this is the last activity of the session
					 echo 2;
				}
			}
	}
    break;
	case "getSubjects":
		$options='<option value="">--Select Subject--</option>';
		if(isset($_POST['year_id']) && $_POST['year_id']!=""){
		    $year_id = $_POST['year_id'];
			$query="select id,subject_name from subject where program_year_id='".$year_id."'";
			$result = mysqli_query($db, $query);
			while($data= mysqli_fetch_array($result)){
				 $options .='<option value="'.$data['id'].'">'.$data['subject_name'].'</option>';
			}
		}
		echo $options;
	break;
	case "getSessions":
		$options='<option value="">--Select Session--</option>';
		if(isset($_POST['subject_id']) && $_POST['subject_id']!=""){
		    $subject_id = $_POST['subject_id'];
			$query="SELECT id,session_name FROM subject_session WHERE subject_id = '".$subject_id."' ORDER BY order_number";
			$result = mysqli_query($db, $query);
			while($data= mysqli_fetch_array($result)){
				 $options .='<option value="'.$data['id'].'">'.$data['session_name'].'</option>';
			}
		}
		echo $options;
	break;
	case "addTeacherAct":
	     $objS = new Subjects();
	     $objB = new Buildings();
		 $objTS = new Timeslot();
		 $objT = new Teacher();

         if($_POST['program_year_id']<>"" && $_POST['subject_id']<>"" && $_POST['session_id']<>"" && !empty($_POST['teachersArr'])){
            $program_year_id = $_POST['program_year_id'];
            $subject_id = $_POST['subject_id'];
            $sessionid = $_POST['session_id'];
            $cycle_id = $_POST['cycle_id'];
            //add teacher activity row in table if not exist
            $objT->insertActivityRow($program_year_id,$cycle_id,$subject_id,$sessionid,$_POST['teachersArr']);
			//room dropdown
			$preallocated_room = $objT->getAllocatedRoomBySubject($subject_id);
			$room_dropDwn = $objB->getRoomsDropDwn($preallocated_room);
			//timeslot dropdown
			$tslot_dropDwn = $objTS->getTimeSlotDropDwn();
            echo '<table cellspacing="0" cellpadding="0" border="0">';
            echo '<tr>';
			echo '<th>Reserved</th>';
			echo '<th>Name</th>';
			echo '<th>Program</th>';
			echo '<th>Subject</th>';
			echo '<th>Session</th>';
			echo '<th>Teacher</th>';
			echo '<th>Room</th>';
			echo '<th>Timeslot</th>';
			echo '<th>Date</th>';
			echo '<th>&nbsp;</th>';
			echo '</tr>';
            $slqT="SELECT * FROM teacher_activity WHERE program_year_id='".$program_year_id."' AND subject_id='".$subject_id."' AND session_id='".$sessionid."' ORDER BY id";
			$relT = mysqli_query($db, $slqT);
			while($data= mysqli_fetch_array($relT)){
			    $reserved_flag_checked = ($data['reserved_flag']==1) ? "checked" : '';
				echo '<tr>';
				echo '<td align="center"><input type="hidden" name="activitiesArr[]" value="'.$data['id'].'"><input type="radio" name="reserved_flag" value="'.$data['id'].'" '.$reserved_flag_checked.' onclick="roomTslotValidate(\''.$data['id'].'\');"></td>';
				echo '<td align="center">'.$data['name'].'</td>';
				echo '<td>'.$objS->getFielldVal("program_years","name","id",$program_year_id).'</td>';
				echo '<td>'.$objS->getSubjectByID($data['subject_id']).'</td>';
				echo '<td>'.$objS->getSessionByID($data['session_id']).'</td>';
				echo '<td>'.$objT->getTeacherByID($data['teacher_id']).'<input type="hidden" id="reserved_teacher_id_'.$data['id'].'" name="reserved_teacher_id_'.$data['id'].'" value="'.$data['teacher_id'].'"></td>';

				echo '<td><select name="room_id_'.$data['id'].'" id="room_id_'.$data['id'].'" class="activity_row_chk" disabled>';
				echo '<option value="">--Room--</option>';
				echo $room_dropDwn;
				echo '</select><br><span id="room_validate_'.$data['id'].'" class="rfv_error" style="display:none;color:#ff0000;">Choose room</span></td>';
				echo '<script type="text/javascript">jQuery("#room_id_'.$data['id'].'").val("'.$data['room_id'].'")</script>';

				echo '<td><select name="tslot_id_'.$data['id'].'" id="tslot_id_'.$data['id'].'" class="activity_row_chk" disabled>';
				echo '<option value="">--Time Slot--</option>';
				echo $tslot_dropDwn;
				echo '</select><br><span id="tslot_validate_'.$data['id'].'" class="rfv_error" style="display:none;color:#ff0000;">Choose time slot</span></td>';
				echo '<script type="text/javascript">jQuery("#tslot_id_'.$data['id'].'").val("'.$data['timeslot_id'].'")</script>';

				echo '<td><input type="text" size="12" id="activityDateCal_'.$data['id'].'" class="activityDateCal" name="activityDateCal_'.$data['id'].'" value="'.$objT->formatDate($data['act_date']).'" readonly disabled/><br><span id="activityDate_validate_'.$data['id'].'" class="rfv_error" style="display:none;color:#ff0000;">Choose date</span></td>';
				echo '<td><input class="buttonsub btnTeacherCheckAbail" type="button" value="Check Availability" name="btnTeacherCheckAbail_'.$data['id'].'" id="btnTeacherCheckAbail_'.$data['id'].'" onclick="checkActAvailability(\''.$program_year_id.'\',\''.$subject_id.'\',\''.$sessionid.'\',\''.$data['teacher_id'].'\',\''.$data['id'].'\');" style="display:none;"/>
				<br><span class="rfv_error" id="room_tslot_availability_avail_'.$data['id'].'" style="color:#009900;display:none;">Available</span><span class="rfv_error" id="room_tslot_availability_not_avail_'.$data['id'].'" style="color:#ff0000;display:none;">Not Available</span></td>';
				echo '</tr>';
				if($data['reserved_flag']==1){
					echo '<script type="text/javascript">roomTslotValidateEdit(\''.$data['id'].'\');</script>';
				}
			}
            echo '</table>';
	     }
	break;
	case "del_teacher_activity":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$del_query="delete from teacher_activity where id='".$id."'";
			$qry = mysqli_query($db, $del_query);
			if(mysqli_affected_rows($db)>0)
				echo 1;
			else
				echo 0;
		}
	case "deleteExcepTeachAvail":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$del_ExcepTeachAvail_query="delete from teacher_availability_exception where id='".$id."'";
			$qry = mysqli_query($db, $del_ExcepTeachAvail_query);
			if(mysqli_affected_rows($db)>0)
				echo 1;
			else
				echo 0;
		}
	break;
	case "deleteExcepProgCycle":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$del_ExcepTeachAvail_query="delete from program_cycle_exception where id='".$id."'";
			$qry = mysqli_query($db, $del_ExcepTeachAvail_query);
			if(mysqli_affected_rows($db)>0)
				echo 1;
			else
				echo 0;
		}
	break;
	case "createRules":
	 $data='';
	 if(isset($_POST['dateFrom']) && $_POST['dateFrom']!="" && isset($_POST['dateTo']) && $_POST['dateTo']!="" && $_POST['days']!=""){
	 $options .='<option value="" class="ruleOptDate" >'.$_POST['dateRange'].'</option>';
		 for($i=0;$i<count($_POST['days']);$i++){
		    $data=$_POST['days'][$i].' '.$_POST['timeSolteArr'][$i];
			$options .='<option value="" selected="selected">'.$data.'</option>';
	     }
	  }
	 echo $options;
	 break;
	case "createClassAvailabilityRules":
			$data='';
			$list='';
			$currentDateTime = date("Y-m-d H:i:s");
			$dateFrom=$_POST['dateFrom'];
			$dateTo=$_POST['dateTo'];
			$cnt=$_POST['countRule'];
			//check if the rule name exists
			$rule_query="select id, rule_name from classroom_availability_rule where rule_name='".$_POST['SchdName']."'";
			$q_res = mysqli_query($db, $rule_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			//echo "count=".count($dataAll);
			if(count($dataAll)>0){
				echo '0';
			}elseif(isset($_POST['dateFrom']) && $_POST['dateFrom']!="" && isset($_POST['dateTo']) && $_POST['dateTo']!="" && $_POST['days']!="" && $_POST['SchdName']!=""){

			 $rule_qry="INSERT INTO  classroom_availability_rule VALUES ('', '".$_POST['SchdName']."', '".$dateFrom."','".$dateTo."','".$currentDateTime."', '".$currentDateTime."')";
				 $result_qry=mysqli_query($db,$rule_qry);
				 $j=0;
				 if($result_qry){
					   $last_insert_id=mysqli_insert_id($db);
					   for($i=0;$i<count($_POST['days']);$i++){
							$rule_day_qry="INSERT INTO  classroom_availability_rule_day_map VALUES ('', '".$last_insert_id."', '".$_POST['timeSoltArr'][$i]."','".$_POST['days'][$i]."','".$currentDateTime."', '".$currentDateTime."')";
							$rule_day_qry_rslt=mysqli_query($db,$rule_day_qry);
							if($rule_day_qry_rslt){
						  $j++;
						  if($j==count($_POST['days'])){
							$message="Rules has been added successfully";
							$_SESSION['succ_msg'] = $message;
							echo '1';
						  }else{
							 $message="Rules cannot be add";
							 $_SESSION['succ_msg'] = $message;
							 echo '0';
						  }
						}
					   }
				 }else{
				   $message="Rules cannot be add";
				   $_SESSION['succ_msg'] = $message;
				   echo '0';
				  }
			}
	break;
	case "checkActAvailability":
	  $objT = new Teacher();
	  if($_POST['program_year_id']<>"" && $_POST['subject_id']<>"" && $_POST['teacher_id']<>"" && $_POST['sessionid']<>"")
	  {
			$program_year_id = $_POST['program_year_id'];
			$subject_id = $_POST['subject_id'];
			$sessionid = $_POST['sessionid'];
			$teacher_id = $_POST['teacher_id'];
			$room_id = $_POST['room_id'];
			$tslot_id = $_POST['tslot_id'];
			$act_date_val = $_POST['act_date_val'];
            //check if a reserved activity already exist
			$preReserved_Id = $objT->getReservedByProgSubjSess($program_year_id,$subject_id,$sessionid);
            //check activity availability
            $resp = $objT->checkActTeaRoomTimeDate($teacher_id,$room_id,$tslot_id,$act_date_val,$preReserved_Id);
            echo $resp;
	  }
    break;
	case "createTeachAvaRule":
		//check if the rule name exists
		$rule_query="select id, rule_name from teacher_availability_rule where rule_name='".$_POST['rule_name']."'";
		$q_res = mysqli_query($db, $rule_query);
		$dataAll = mysqli_fetch_assoc($q_res);
		if(count($dataAll)>0)
		{
			echo '0';
		}else{
			//Add the new rule
			$currentDateTime = date("Y-m-d H:i:s");
			$weeksDataVal = "";
			if((isset($_POST['start_date']) && $_POST['start_date']!="") && (isset($_POST['end_date']) && $_POST['end_date']!="")){
				$weeksData = array();
				$obj = new Teacher();
				$weeksData = $obj->getWeeksInDateRange($_POST['start_date'], $_POST['end_date']);
				$weeksDataVal = implode(",",$weeksData);
			}
			if ($result = mysqli_query($db, "INSERT INTO teacher_availability_rule VALUES ('', '".$_POST['rule_name']."', '".$_POST['start_date']."', '".$_POST['end_date']."', '".$weeksDataVal."', '".$currentDateTime."', '".$currentDateTime."');")){
				//insert the days and timeslots for created rule
				$teacher_availability_rule_id = $db->insert_id;
				if($teacher_availability_rule_id!=""){
						//insert values for monday
						if(isset($_POST['timeslotMon']) && ($_POST['timeslotMon'])!=""){
						$timeslotMon = substr($_POST['timeslotMon'], 1, -1);
						$result = mysqli_query($db, "INSERT INTO teacher_availability_rule_day_map VALUES ('', '".$teacher_availability_rule_id."', '".$timeslotMon."', 0, 'Mon', '".$currentDateTime."', '".$currentDateTime."');");
						}
						//insert values for Tuesday
						if(isset($_POST['timeslotTue'])  && ($_POST['timeslotTue'])!=""){
						$timeslotTue = substr($_POST['timeslotTue'], 1, -1);
						$result = mysqli_query($db, "INSERT INTO teacher_availability_rule_day_map VALUES ('', '".$teacher_availability_rule_id."', '".$timeslotTue."', 1, 'Tue', '".$currentDateTime."', '".$currentDateTime."');");
						}
						//insert values for Wednesday
						if(isset($_POST['timeslotWed']) && ($_POST['timeslotWed'])!=""){
						$timeslotWed = substr($_POST['timeslotWed'], 1, -1);
						$result = mysqli_query($db, "INSERT INTO teacher_availability_rule_day_map VALUES ('', '".$teacher_availability_rule_id."', '".$timeslotWed."', 2, 'Wed', '".$currentDateTime."', '".$currentDateTime."');");
						}
						//insert values for Thursday
						if(isset($_POST['timeslotThu']) && ($_POST['timeslotThu'])!=""){
						$timeslotThu = substr($_POST['timeslotThu'], 1, -1);
						$result = mysqli_query($db, "INSERT INTO teacher_availability_rule_day_map VALUES ('', '".$teacher_availability_rule_id."', '".$timeslotThu."', 3, 'Thu', '".$currentDateTime."', '".$currentDateTime."');");
						}
						//insert values for Friday
						if(isset($_POST['timeslotFri']) && ($_POST['timeslotFri'])!=""){
						$timeslotFri = substr($_POST['timeslotFri'], 1, -1);
						$result = mysqli_query($db, "INSERT INTO teacher_availability_rule_day_map VALUES ('', '".$teacher_availability_rule_id."', '".$timeslotFri."', 4, 'Fri', '".$currentDateTime."', '".$currentDateTime."');");
						}
						//insert values for Saturday
						if(isset($_POST['timeslotSat']) && ($_POST['timeslotSat'])!=""){
						$timeslotSat =  substr($_POST['timeslotSat'], 1, -1);
						$result = mysqli_query($db, "INSERT INTO teacher_availability_rule_day_map VALUES ('', '".$teacher_availability_rule_id."', '".$timeslotSat."', 5, 'Sat', '".$currentDateTime."', '".$currentDateTime."');");
						}
						echo '1';
				}else{
						echo '0';
				}
			}else{
				echo '0';
			}
		}
	break;
	case "del_teachAvailMap":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$del_TeachAvail_query="delete from teacher_availability_rule_teacher_map where teacher_id='".$id."'";
			$qry = mysqli_query($db, $del_TeachAvail_query);
			if(mysqli_affected_rows($db)>0){
				echo 1;
				//delete the related exception for the teacher
				$del_ExcepTeachAvail_query="delete from teacher_availability_exception where teacher_id='".$id."'";
				$qry = mysqli_query($db, $del_ExcepTeachAvail_query);
			}else
				echo 0;
			}
    break;
	case "del_cls_exception":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$del_class_excepton_query="delete from classroom_availability_exception where id='".$id."'";
			$qry = mysqli_query($db, $del_class_excepton_query);
			if(mysqli_affected_rows($db)>0)
				echo 1;
			else
				echo 0;
		}
    break;
	case "del_classroom_availabilty":
		if(isset($_POST['id'])){
		 $id = $_POST['id'];
		 $del_clsrmAvail_query="delete from classroom_availability_rule_room_map where room_id='".$id."'";
		 $qry = mysqli_query($db, $del_clsrmAvail_query);
		if(mysqli_affected_rows($db)>0){
			echo 1;
		 //delete the related exception for the teacher
		$del_ExcepclsrmAvail_query="delete from classroom_availability_exception where room_id='".$id."'";
		$qry = mysqli_query($db, $del_ExcepclsrmAvail_query);
		}else
		 echo 0;
		}
    break;
	case "del_holiday":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$del_holiday_query="delete from holidays where id='".$id."'";
			$qry = mysqli_query($db, $del_holiday_query);
			if(mysqli_affected_rows($db)>0)
				echo 1;
			else
				echo 0;
		}
	break;
	case "getCyclesByPyId":
		$options='<option value="">--Select Session--</option>';
		if(isset($_POST['py_id']) && $_POST['py_id']!=""){
			$py_id = $_POST['py_id'];
			$query="SELECT * FROM cycle WHERE program_year_id = '".$py_id."' ORDER BY id";
			$result = mysqli_query($db, $query);
			$i=0;
			while($data= mysqli_fetch_array($result)){
			     $i++;
				 $options .='<option value="'.$data['id'].'">'.$i.'</option>';
			}
		}
		echo $options;
	break;
	case "del_cycle":
	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$del_cycle_query="delete from cycle where program_year_id='".$id."'";
		$qry = mysqli_query($db, $del_cycle_query);
		$slct_qry = "select * from program_cycle_exception where program_year_id='".$id."'";
		$qry_slct = mysqli_query($db,$slct_qry);
		if(mysqli_num_rows($qry_slct)>0){
		$del_pgm_exp_query="delete from program_cycle_exception where program_year_id='".$id."'";
		$qry_pgm_exp = mysqli_query($db,$del_pgm_exp_query);
		}
		if(mysqli_affected_rows($db)>0)
			echo 1;
		else
			echo 0;
	}
	case "getCycles":
		if(isset($_POST['progId']) && $_POST['progId']!=""){
				$options .='<option value="">--Select Cycle--</option>';
				$cycle_query="select no_of_cycle from cycle where program_year_id='".$_POST['progId']."' limit 1";
				$qry = mysqli_query($db, $cycle_query);
				$data = mysqli_fetch_row($qry); 
				for($i=1; $i<=$data[0]; $i++){
					$options .='<option value="'.$i.'" >'.$i.'</option>';
				}
		}
		echo $options;
	break;
	case "add_sub_session":
		//check if same session name already created
		$rule_query="select id, session_name from subject_session where subject_id='".$_POST['subjectId']."' and session_name = '".$_POST['txtSessionName']."'";
		$q_res = mysqli_query($db, $rule_query);
		$dataAll = mysqli_fetch_assoc($q_res);
		if(count($dataAll)>0){
			echo '2';
		}else{
			//if only session name and order no is provide, just create a session and exit
			$currentDateTime = date("Y-m-d H:i:s");
			if((isset($_POST['txtSessionName']) && $_POST['txtSessionName']!="") && (isset($_POST['txtOrderNum']) && $_POST['txtOrderNum']!="") && (isset($_POST['slctTeacher']) && $_POST['slctTeacher']=="") && (isset($_POST['tslot_id']) && $_POST['tslot_id']=="") && (isset($_POST['room_id']) && $_POST['room_id']=="") && (isset($_POST['subSessDate']) && $_POST['subSessDate']=="") ){
					$result = mysqli_query($db, "INSERT INTO subject_session VALUES ('', '".$_POST['subjectId']."', '".$_POST['cycleId']."', '".$_POST['txtSessionName']."', '".$_POST['txtOrderNum']."', '".$_POST['txtareaSessionDesp']."', '".$_POST['txtCaseNo']."', '".$_POST['txtareatechnicalNotes']."', NOW(), NOW());");
				if(mysqli_affected_rows($db)>0){
					echo 1;
				}else{
					echo 0;
				} exit;
			}
			//if all fields are present then first add session and then create activities after checking the availability
			if((isset($_POST['txtSessionName']) && $_POST['txtSessionName']!="") && (isset($_POST['txtOrderNum']) && $_POST['txtOrderNum']!="") && (isset($_POST['slctTeacher']) && $_POST['slctTeacher']!="") && (isset($_POST['tslot_id']) && $_POST['tslot_id']!="") && (isset($_POST['room_id']) && $_POST['room_id']!="") && (isset($_POST['subSessDate']) && $_POST['subSessDate']!="")){
						$group_id = "";
						//check the availability of activity with different condition
						//check if the subject have some other reserved activities and the new room name is same as was in previously assigned room
						$valid=1;
						if(isset($_POST['subjectId']) && $_POST['subjectId']!=""){
							$query="select ss.*, ta.room_id, ta.act_date, ta.reserved_flag from subject_session as ss LEFT JOIN teacher_activity as ta ON ss.id=ta.session_id where ss.subject_id='".$_POST['subjectId']."' and ta.reserved_flag=1 limit 1";
							$q_res = mysqli_query($db, $query);
							$dataAll = mysqli_fetch_assoc($q_res);
								if($dataAll['room_id']!= $_POST['room_id']){
									echo 6;
									$valid=0;
									exit;
								}
						}
						//check if teacher is available on the given time and day and is  not engaged in some other reserved activity
						if($valid==1){ 
							$teachAvail_query="select ss.*, ta.room_id, ta.act_date, ta.timeslot_id, ta.teacher_id, ta.reserved_flag from subject_session as ss LEFT JOIN teacher_activity as ta ON ss.id=ta.session_id where ta.reserved_flag=1 and ta.timeslot_id='".$_POST['tslot_id']."' and ta.act_date='".$_POST['subSessDate']."' and ta.teacher_id='".$_POST['slctTeacher']."'";
							$q_res = mysqli_query($db, $teachAvail_query);
							if(mysqli_affected_rows($db)>0){
								echo 3;
								$valid=0;
								exit;
							}
						}
						//check if room is free at given time and day
						if($valid==1){ 
							$roomAvail_query="select ss.*, ta.room_id, ta.act_date, ta.timeslot_id, ta.teacher_id, ta.reserved_flag from subject_session as ss LEFT JOIN teacher_activity as ta ON ss.id=ta.session_id where ta.reserved_flag=1 and ta.room_id='".$_POST['room_id']."' and ta.timeslot_id='".$_POST['tslot_id']."' and ta.act_date='".$_POST['subSessDate']."'";
							$q_res = mysqli_query($db, $roomAvail_query);
							if(mysqli_affected_rows($db)>0){
								echo 4;
								$valid=0;
								exit;
							}
						}
						if($valid==1){
							$reserved_flag="1";
							$result = mysqli_query($db, "INSERT INTO subject_session VALUES ('', '".$_POST['subjectId']."', '".$_POST['cycleId']."', '".$_POST['txtSessionName']."', '".$_POST['txtOrderNum']."', '".$_POST['txtareaSessionDesp']."', '".$_POST['txtCaseNo']."', '".$_POST['txtareatechnicalNotes']."', NOW(), NOW());");
							if(mysqli_affected_rows($db)>0){
								$sessionId = mysqli_insert_id($db);
								//get last created activity name
								$result3 = mysqli_query($db, "SELECT name FROM teacher_activity ORDER BY id DESC LIMIT 1");
								$dRow = mysqli_fetch_assoc($result3);
								$actCnt = substr($dRow['name'],1);
								$actName = 'A'.($actCnt+1);
								//insert new activity
								$result2 = mysqli_query($db, "INSERT INTO teacher_activity VALUES ('', '".$actName."', '".$_POST['programId']."', '".$_POST['cycleId']."', '".$_POST['subjectId']."', '".$sessionId."', '".$_POST['slctTeacher']."', '".$group_id."','".$_POST['room_id']."', '".$_POST['tslot_id']."', '".$_POST['subSessDate']."', '".$reserved_flag."', NOW(), NOW());");
								if(mysqli_affected_rows($db)>0){
									echo 1;
								}else{
									echo 0;
								}
							}else{
									echo 0;
							}
					}else{
						echo 0;
					}
		}	
	}
	break;
	case "del_sub_activity_session":
		if(isset($_POST['activityId']) && isset($_POST['sessionID'])){
			$activityId = $_POST['activityId'];
			//delete activity
			$del_act_query="delete from teacher_activity where id='".$_POST['activityId']."'";
			$qry = mysqli_query($db, $del_act_query);
			if(mysqli_affected_rows($db)>0){
				$del_session="delete from subject_session where id='".$_POST['sessionID']."'";
				$qry = mysqli_query($db, $del_session);
				if(mysqli_affected_rows($db)>0){
					echo 1;
				}else{
					echo 0;
				}
			}else{
				echo 0;
			}
	}
    break;
	case "checkAvailabilitySession":
		//check if the subject have some other reserved activities and the new room name is same as was in previously assigned room
		$valid=1;
		if(isset($_POST['subjectId']) && $_POST['subjectId']!=""){
			$query="select ss.*, ta.room_id, ta.act_date, ta.reserved_flag from subject_session as ss LEFT JOIN teacher_activity as ta ON ss.id=ta.session_id where ss.subject_id='".$_POST['subjectId']."' and ta.reserved_flag=1 limit 1";
			$q_res = mysqli_query($db, $query);
			$dataAll = mysqli_fetch_assoc($q_res);
				if($dataAll['room_id']!= $_POST['room_id']){
					echo 2;
					$valid=0;
					exit;
				}
		}
		//check if teacher is available on the given time and day and is  not engaged in some other reserved activity
		if($valid==1){ 
			$teachAvail_query="select ss.*, ta.room_id, ta.act_date, ta.timeslot_id, ta.teacher_id, ta.reserved_flag from subject_session as ss LEFT JOIN teacher_activity as ta ON ss.id=ta.session_id where ta.reserved_flag=1 and ta.timeslot_id='".$_POST['tslot_id']."' and ta.act_date='".$_POST['subSessDate']."' and ta.teacher_id='".$_POST['slctTeacher']."'";
			$q_res = mysqli_query($db, $teachAvail_query);
			if(mysqli_affected_rows($db)>0){
				echo 3;
				$valid=0;
				exit;
			}
		}
		//check if room is free at given time and day
		if($valid==1){ 
			$roomAvail_query="select ss.*, ta.room_id, ta.act_date, ta.timeslot_id, ta.teacher_id, ta.reserved_flag from subject_session as ss LEFT JOIN teacher_activity as ta ON ss.id=ta.session_id where ta.reserved_flag=1 and ta.room_id='".$_POST['room_id']."' and ta.timeslot_id='".$_POST['tslot_id']."' and ta.act_date='".$_POST['subSessDate']."'";
			$q_res = mysqli_query($db, $roomAvail_query);
			if(mysqli_affected_rows($db)>0){
				echo 4;
				$valid=0;
				exit;
			}
		}
		echo $valid;
		break;
}
?>
