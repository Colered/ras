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
			$options .='<option value="'.$room_type_name.'">'.'--'.$room_type_name.'--'.'</option>';
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
		if(isset($_POST['program_id']) && $_POST['program_id']!=""){
		    $program_id = $_POST['program_id'];
			$query="select id,subject_name from subject where program_id='".$program_id."'";
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
}

?>
