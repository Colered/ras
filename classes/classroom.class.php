<?php
class Classroom extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	/*function for adding room*/
	public function addRoom() {
			//check if the room already exists
			$area_query="select room_name, id from room where room_name='".Base::cleanText($_POST['txtRmName'])."'";
			$q_res = mysqli_query($this->conn, $area_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			if(count($dataAll)>0)
			{
				$message="Room with same name already exists.";
				$_SESSION['error_msg'] = $message;
				return 0;
			}else{
				//add the new Room
				$currentDateTime = date("Y-m-d H:i:s");
				if ($result = mysqli_query($this->conn, "INSERT INTO room VALUES ('', '".$_POST['slctBuilding']."', '".$_POST['slctRmType']."', '".Base::cleanText($_POST['txtRmName'])."', '".$currentDateTime."', '".$currentDateTime."');")) {
   					$message="New room has been added successfully";
					$_SESSION['succ_msg'] = $message;
					return 1;
				}else{
					$message="Cannot add the room";
					$_SESSION['error_msg'] = $message;
					return 0;
				}
			}
	}
	/*function for listing Room*/
	public function viewRoom() {
			$area_query="select rm.id as listId, rt.id, bd.id, rm.building_id, rm.room_type_id, rm.room_name, rt.room_type, bd.building_name FROM room as rm LEFT JOIN room_type as rt ON rm.room_type_id = rt.id LEFT JOIN building as bd ON rm.building_id = bd.id";
			$q_res = mysqli_query($this->conn, $area_query);
			/*if(mysqli_num_rows($q_res)<=0){
				$message="There is not any room exists.";
				$_SESSION['error_msg'] = $message;
			}*/
			return $q_res;
	}
	/*function for fetch data using room ID*/
	public function getDataByRoomID($id) {
			$area_query="select * from room where id='".$id."' limit 1";
			$q_res = mysqli_query($this->conn, $area_query);
			/*if(mysqli_num_rows($q_res)<=0)
				return 0;
			else*/
				return $q_res;
	}
	/*function for Update Rooms*/
	public function updateRoom() {
			//check if the room name already exists
			$room_query="select room_name from room where room_name='".Base::cleanText($_POST['txtRmName'])."' and id !='".$_POST['roomId']."'";
			$q_res = mysqli_query($this->conn, $room_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			if(count($dataAll)>0)
			{
				$message="Room with same neam already exists.";
				$_SESSION['error_msg'] = $message;
				header('Location: rooms.php?edit='.base64_encode($_POST['roomId']));
				return 0;
			}elseif ($result = mysqli_query($this->conn, "Update room  Set building_id = '".$_POST['slctBuilding']."', room_type_id = '".$_POST['slctRmType']."', room_name = '".Base::cleanText($_POST['txtRmName'])."' , date_update = '".date("Y-m-d H:i:s")."' where id='".$_POST['roomId']."'")) {
   					$message="Room has been updated successfully";
					$_SESSION['succ_msg'] = $message;
					return 1;
				}else{
					$message="Cannot update the Room";
					$_SESSION['error_msg'] = $message;
					header('Location: rooms.php?edit='.base64_encode($_POST['roomId']));
					return 0;
				}
			}

	/*function to get all room type*/
	public function getAllRoomType() {
			$query="select * from room_type order by id ASC";
			$q_res = mysqli_query($this->conn, $query);
			/*if(mysqli_num_rows($q_res)<=0)
				return 0;
			else*/
			return $q_res;
	}
	public function getRoom(){
	  $room_type_qry="select id,room_name from room ORDER BY room_name";
	  $q_res= mysqli_query($this->conn, $room_type_qry);
	  return $q_res;
	}
	public function getWebRoomDetail($room_id='')
	{   
	$row=$rowmainArr=$newArr=array();
	$result =  $this->conn->query("SELECT we.cal_name, we.cal_description, we.cal_date, we.cal_time, we.cal_id, we.cal_ext_for_id, we.cal_priority, we.cal_access, we.cal_duration, weu.cal_status, we.cal_create_by, weu.cal_login, we.cal_type, we.cal_location, we.cal_url, we.cal_due_date, we.cal_due_time, weu.cal_percent, we.cal_mod_date, we.cal_mod_time FROM webcal_entry we,webcal_entry_user weu WHERE we.cal_id = weu.cal_id and we.room_id='".$room_id."' ORDER BY we.cal_time, we.cal_name ");
		if($result->num_rows){
			while ($rows =$result->fetch_assoc()){
					$row[]=$rows;
			}
		}
		if(count($row)>0){
		   $rowNewArr=array(array());
		   for($i=0;$i<count($row);$i++){
		    $j=0;
		    foreach($row[$i] as $key=>$val){
			  $rowNewArr[$i][$j]=$val;
			  $j++;
		   	}
		  }
		  return $rowNewArr;
		}			
	}
}
