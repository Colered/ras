<?php
class Timeslot extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	/*function for adding Area*/
	public function addTimeslot() {
			//check if the area code already exists
			$area_query="select area_name, area_code from area where area_code='".$_POST['txtAreaCode']."'";
			$q_res = mysqli_query($this->conn, $area_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			if(count($dataAll)>0)
			{
				$message="TIme Slot already exists.";
				$_SESSION['error_msg'] = $message;
				return 0;
			}else{
				//add the new area
				$currentDateTime = date("Y-m-d H:i:s");
				if ($result = mysqli_query($this->conn, "INSERT INTO area VALUES ('', '".$_POST['txtAreaName']."', '".$_POST['txtAreaCode']."', '".$_POST['txtAColor']."', '".$currentDateTime."', '".$currentDateTime."');")) {
   					$message="New area has been added successfully";
					$_SESSION['succ_msg'] = $message;
					return 1;
				}else{
					$message="Cannot add the area";
					$_SESSION['error_msg'] = $message;
					return 0;
				}
			}
	}
	/*function for listing Area*/
	public function viewTimeslot() {
			$area_query="select * from timeslot order by date_update DESC";
			$q_res = mysqli_query($this->conn, $area_query);
			if(mysqli_num_rows($q_res)<=0){
				$message="There is not any timeslot exists.";
				$_SESSION['error_msg'] = $message;
			}
			return $q_res;
	}

	/*function for fetch data using area ID*/
	public function getDataByAreaID($id) {
			$area_query="select * from area where id='".$id."' limit 1";
			$q_res = mysqli_query($this->conn, $area_query);
			if(mysqli_num_rows($q_res)<=0)
				return 0;
			else
				return $q_res;
	}
	/*function for Update Area*/
	public function updateArea() {
			//check if the area code already exists
			$area_query="select area_name, area_code from area where area_code='".$_POST['txtAreaCode']."' and id !='".$_POST['areaId']."'";
			$q_res = mysqli_query($this->conn, $area_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			if(count($dataAll)>0)
			{
				$message="Area code already exists.";
				$_SESSION['error_msg'] = $message;
				return 0;
			}elseif ($result = mysqli_query($this->conn, "Update area  Set area_name = '".$_POST['txtAreaName']."', area_code = '".$_POST['txtAreaCode']."', area_color = '".$_POST['txtAColor']."' , date_update = '".date("Y-m-d H:i:s")."' where id='".$_POST['areaId']."'")) {
   					$message="Area has been updated successfully";
					$_SESSION['succ_msg'] = $message;
					return 1;
				}else{
					$message="Cannot update the area";
					$_SESSION['error_msg'] = $message;
					return 0;
				}
			}
}
