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
		    $qry = mysqli_query($db, $del_cycle_query);
		    //delete associated groups
			$del_pg_query="delete from program_group where program_year_id in(select id from program_years where program_id='".$id."')";
			$qry = mysqli_query($db, $del_pg_query);

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
	case "del_session":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$del_timeslot_query="delete from subject_session where id='".$id."'";
			$qry = mysqli_query($db, $del_timeslot_query);
			if(mysqli_affected_rows($db)>0)
				echo 1;
			else
				echo 0;
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

            //add teacher activity row in table if not exist
            $objT->insertActivityRow($program_year_id,$subject_id,$sessionid,$_POST['teachersArr']);
			//room dropdown
			$room_dropDwn = $objB->getRoomsDropDwn();
			//timeslot dropdown
			$tslot_dropDwn = $objTS->getTimeSlotDropDwn();
            echo '<table cellspacing="0" cellpadding="0" border="0">';
            echo '<tr>';
			echo '<th>Reserved</th>';
			echo '<th>Program</th>';
			echo '<th>Subject</th>';
			echo '<th>Session</th>';
			echo '<th>Teacher</th>';
			echo '<th>Room</th>';
			echo '<th>Timeslot</th>';
			echo '<th>Date</th>';
			echo '<th>&nbsp;</th>';
			echo '</tr>';
            $slqT="SELECT * FROM teacher_activity WHERE program_year_id='".$program_year_id."' AND subject_id='".$subject_id."' AND session_id='".$sessionid."' ORDER BY name";
			$relT = mysqli_query($db, $slqT);
			while($data= mysqli_fetch_array($relT)){
				echo '<tr>';
				echo '<td align="center"><input type="hidden" name="activitiesArr[]" value="'.$data['id'].'"><input type="radio" name="reserved_flag" value="'.$data['id'].'" onclick="roomTslotValidate(\''.$data['id'].'\');"></td>';
				echo '<td>'.$objS->getFielldVal("program_years","name","id",$program_year_id).'</td>';
				echo '<td>'.$objS->getSubjectByID($data['subject_id']).'</td>';
				echo '<td>'.$objS->getSessionByID($data['session_id']).'</td>';
				echo '<td>'.$objT->getTeacherByID($data['teacher_id']).'<input type="hidden" name="reserved_teacher_id_'.$data['id'].'" value="'.$data['teacher_id'].'"></td>';

				echo '<td><select name="room_id_'.$data['id'].'" id="room_id_'.$data['id'].'" class="activity_row_chk" disabled>';
				echo '<option value="">--Room--</option>';
				echo $room_dropDwn;
				echo '</select><br><span id="room_validate_'.$data['id'].'" class="rfv_error" style="display:none;color:#ff0000;">Choose room</span></td>';

				echo '<td><select name="tslot_id_'.$data['id'].'" id="tslot_id_'.$data['id'].'" class="activity_row_chk" disabled>';
				echo '<option value="">--Time Slot--</option>';
				echo $tslot_dropDwn;
				echo '</select><br><span id="tslot_validate_'.$data['id'].'" class="rfv_error" style="display:none;color:#ff0000;">Choose time slot</span></td>';
				echo '<td><input type="text" size="12" id="activityDateCal_'.$data['id'].'" class="activityDateCal" name="activityDateCal_'.$data['id'].'" readonly disabled/><br><span id="activityDate_validate_'.$data['id'].'" class="rfv_error" style="display:none;color:#ff0000;">Choose date</span></td>';
				echo '<td><input class="buttonsub btnTeacherCheckAbail" type="button" value="Check Availability" name="btnTeacherCheckAbail_'.$data['id'].'" id="btnTeacherCheckAbail_'.$data['id'].'" onclick="checkActAvailability(\''.$program_year_id.'\',\''.$subject_id.'\',\''.$sessionid.'\',\''.$data['teacher_id'].'\',\''.$data['id'].'\');" style="display:none;"/>
				<br><span class="rfv_error" id="room_tslot_availability_avail_'.$data['id'].'" style="color:#009900;display:none;">Available</span><span class="rfv_error" id="room_tslot_availability_not_avail_'.$data['id'].'" style="color:#ff0000;display:none;">Not Available</span></td>';
				echo '</tr>';
				//mysqli_data_seek($relR,0);
				//mysqli_data_seek($relTS,0);
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
	  if($_POST['program_year_id']<>"" && $_POST['subject_id']<>"" && $_POST['teacher_id']<>"")
	  {
			$program_year_id = $_POST['program_year_id'];
			$subject_id = $_POST['subject_id'];
			$sessionid = $_POST['sessionid'];
			$teacher_id = $_POST['teacher_id'];
			$room_id = $_POST['room_id'];
			$tslot_id = $_POST['tslot_id'];
			$act_date_val = $_POST['act_date_val'];

			$sqlA = "SELECT name FROM teacher_activity WHERE 1=1";
			if($program_year_id)
				$sqlA .= " and program_year_id='".$program_year_id."'";
			if($subject_id)
				$sqlA .= " and subject_id='".$subject_id."'";
			if($sessionid)
				$sqlA .= " and session_id='".$sessionid."'";
			if($teacher_id)
				$sqlA .= " and teacher_id='".$teacher_id."'";
			if($room_id)
				$sqlA .= " and room_id='".$room_id."'";
			if($tslot_id)
				$sqlA .= " and timeslot_id='".$tslot_id."'";
			if($act_date_val<>"")
			    $sqlA .= " and DATE_FORMAT(act_date, '%d-%m-%Y') = '".$act_date_val."'";
			//echo '<br>'.$sqlA;die;
			$result =  mysqli_query($db,$sqlA);
			if(mysqli_num_rows($result)){
               echo '1';
			}else{
			   echo '0';
			}
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
}
?>
