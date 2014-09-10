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
			  $options .='<option value="'.$room_data['id'].'">'.$room_data['room_name'].'</option>';
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
		    $query="SELECT * FROM program_group WHERE program_year_id in(select id from program_years where program_id='".$_POST['program_id']."')";
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
			$del_query="delete from program_group where program_year_id in(select id from program_years where program_id='".$id."')";
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
         if($_POST['program_id']<>"" && $_POST['subject_id']<>"" && !empty($_POST['teachersArr'])){
            $program_id = $_POST['program_id'];
            $subject_id = $_POST['subject_id'];
            $sessionid = $_POST['session_id'];

			$slqR="SELECT r.id, r.room_name, rt.room_type, b.building_name FROM room r
					LEFT JOIN room_type rt ON ( rt.id = r.room_type_id )
					LEFT JOIN building b ON ( b.id = r.building_id ) ORDER BY room_type,building_name";
			$relR = mysqli_query($db, $slqR);

            $slqTS="SELECT id, timeslot_range FROM timeslot";
			$relTS = mysqli_query($db, $slqTS);

            echo '<table cellspacing="0" cellpadding="0" border="0">';
            echo '<tr>';
			echo '<th>Reserved</th>';
			echo '<th>Subject</th>';
			echo '<th>Session</th>';
			echo '<th>Teacher</th>';
			echo '<th>Room</th>';
			echo '<th>Timeslot</th>';
			echo '</tr>';
            $slqT="SELECT id,teacher_name,email FROM teacher WHERE id IN(".implode(',',$_POST['teachersArr']).") ORDER BY teacher_name";
			$relT = mysqli_query($db, $slqT);
			while($data= mysqli_fetch_array($relT)){
				echo '<tr>';
				echo '<td align="center"><input type="radio" name="reserved_flag_'.$data['id'].'" value="1"></td>';
				echo '<td>'.$objS->getSubjectByID($subject_id).'</td>';
				echo '<td>'.$objS->getSessionByID($sessionid).'</td>';
				echo '<td>'.$data['teacher_name'].' ('.$data['email'].')</td>';

				echo '<td><select name="room_id_'.$data['id'].'"><option value="">--Room--</option>';
				while($rdata= mysqli_fetch_array($relR)){
					echo  '<option value="'.$rdata['id'].'">'.$rdata['room_name'].'-'.$rdata['building_name'].'-'.$rdata['room_type'].'</option>';
				}
				echo '</select></td>';

				echo '<td><select name="tslot_id_'.$data['id'].'"><option value="">--Time Slot--</option>';
				while($tsdata= mysqli_fetch_array($relTS)){
					echo '<option value="'.$tsdata['id'].'">'.$tsdata['timeslot_range'].'</option>';
				}
				echo '</select></td>';
				echo '</tr>';

				mysqli_data_seek($relR,0);
				mysqli_data_seek($relTS,0);
			}
            echo '</table>';
	     }
	break;
	case "del_teacher_activity":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$del_query="delete from  teacher_activity where id='".$id."'";
			$qry = mysqli_query($db, $del_query);
			if(mysqli_affected_rows($db)>0)
				echo 1;
			else
				echo 0;
		}
	break;
	case "createRules":
	$data='';
	
	if(isset($_POST['dateFrom']) && $_POST['dateFrom']!="" && isset($_POST['dateTo']) && $_POST['dateTo']!="" && $_POST['days']!=""){
	/*$options .='<option value="" class="ruleOptName" >Rule:-'.$_POST['countRule'].'</option>';*/
	$options .='<option value="" class="ruleOptDate" >'.$_POST['dateRange'].'</option>';
		   for($i=0;$i<count($_POST['days']);$i++){
		   		$data=$_POST['days'][$i].' '.$_POST['timeSolteArr'][$i];
				$options .='<option value="" selected="selected">'.$data.'</option>';
			}
		}
	echo $options;
	break;
}

?>
