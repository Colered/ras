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
				if ($result = mysqli_query($this->conn, "INSERT INTO room VALUES ('', '".$_POST['slctBuilding']."', '".$_POST['slctRmType']."', '".Base::cleanText($_POST['txtRmName'])."', '".$_POST['slctPriority']."', '".$currentDateTime."', '".$currentDateTime."');")) {
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
			$room_query="select rm.id as listId, rt.id, bd.id, rm.building_id, rm.room_type_id, rm.room_name, rt.room_type, rm.order_priority, bd.building_name FROM room as rm LEFT JOIN room_type as rt ON rm.room_type_id = rt.id LEFT JOIN building as bd ON rm.building_id = bd.id";
			$q_res = mysqli_query($this->conn, $room_query);
			return $q_res;
	}
	/*function for fetch data using room ID*/
	public function getDataByRoomID($id) {
			$room_query="select * from room where id='".$id."' limit 1";
			$q_res = mysqli_query($this->conn, $room_query);
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
				$message="Room with same name already exists.";
				$_SESSION['error_msg'] = $message;
				header('Location: rooms.php?edit='.base64_encode($_POST['roomId']));
				return 0;
			}elseif ($result = mysqli_query($this->conn, "Update room  Set building_id = '".$_POST['slctBuilding']."', room_type_id = '".$_POST['slctRmType']."', room_name = '".Base::cleanText($_POST['txtRmName'])."' , order_priority = '".$_POST['slctPriority']."', date_update = '".date("Y-m-d H:i:s")."' where id='".$_POST['roomId']."'")) {
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
	public function getClassroomException()
	{
		$excep_query="select exception_date from  classroom_availability_exception";
		$q_excep = mysqli_query($this->conn, $excep_query);
		return $q_excep;
	
	}
	public function getClassroomAvailExceptionById($room_id='')
	{
		$excep_query="select exception_date from  classroom_availability_exception where room_id='".$room_id."'";
		$q_excep = mysqli_query($this->conn, $excep_query);
		return $q_excep;
	}
	public function addEditRoomPriority($program_id)
	{
		$roomnames = $roomorder = array();
		if(isset($_POST['roomorder']) && isset($_POST['roomnames'])){
			$roomnames = $_POST['roomnames'];
			$roomorder = $_POST['roomorder'];
			//check if priority data already exist
			//$total = 0;
			//get progrsm years id from program ID
			$objPGM = new Programs();
			$respPgm = $objPGM->getProgramYearsById($program_id);
			$pgmYrIds = array();
			while($pgmYrData = $respPgm->fetch_assoc()){
				$pgmYrIds[] = $pgmYrData['id'];
			}
			//echo $program_id.'<br/>'; 
			//print_r($pgmYrIds); die;
			if(count($pgmYrIds > 0)){
				foreach($pgmYrIds as $program_yr_id){
					$total = 0;
					foreach($roomnames as $key=>$value){
						$room_query="select id from room_priority where program_yr_id='".$program_yr_id."' and room_id ='".$key."' limit 1";
						$q_res = mysqli_query($this->conn, $room_query);
						$dataAll = mysqli_fetch_assoc($q_res);
						if(count($dataAll)>0)
						{
							//update the priority order
							mysqli_query($this->conn, "Update room_priority Set program_id = '".$program_id."', program_yr_id = '".$program_yr_id."', room_id = '".$key."', order_priority = '".$roomorder[$total]."' , date_update = '".date("Y-m-d H:i:s")."' where id='".$dataAll['id']."'");
						}else{
							//add a new row
							mysqli_query($this->conn, "INSERT INTO room_priority(program_id, program_yr_id, room_id, order_priority, date_add, date_update) VALUES ('".$program_id."','".$program_yr_id."', '".$key."', '".$roomorder[$total]."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')");
						}
						$total++;
					}
				}
			}
		}
	}
	public function getRoomsPriorityOrder($programId, $room_id)
	{
		if($programId!=""){
			$excep_query="select * from room_priority where program_id='".$programId."' AND room_id='".$room_id."' limit 1";
			$q_excep = mysqli_query($this->conn, $excep_query);
			return $q_excep;
		}
	}
}