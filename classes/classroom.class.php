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
			if(mysqli_num_rows($q_res)<=0){
				$message="There is not any room exists.";
				$_SESSION['error_msg'] = $message;
			}
			return $q_res;
	}
	/*function for fetch data using room ID*/
	public function getDataByRoomID($id) {
			$area_query="select * from room where id='".$id."' limit 1";
			$q_res = mysqli_query($this->conn, $area_query);
			if(mysqli_num_rows($q_res)<=0)
				return 0;
			else
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
				return 0;
			}elseif ($result = mysqli_query($this->conn, "Update room  Set building_id = '".$_POST['slctBuilding']."', room_type_id = '".$_POST['slctRmType']."', room_name = '".Base::cleanText($_POST['txtRmName'])."' , date_update = '".date("Y-m-d H:i:s")."' where id='".$_POST['roomId']."'")) {
   					$message="Room has been updated successfully";
					$_SESSION['succ_msg'] = $message;
					return 1;
				}else{
					$message="Cannot update the Room";
					$_SESSION['error_msg'] = $message;
					return 0;
				}
			}

	/*function to get all room type*/
	public function getAllRoomType() {
			$query="select * from room_type order by id ASC";
			$q_res = mysqli_query($this->conn, $query);
			if(mysqli_num_rows($q_res)<=0)
				return 0;
			else
				return $q_res;
	}
}
