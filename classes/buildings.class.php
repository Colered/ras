<?php
class Buildings {
   	//Creating Db connection object
   	private $conn;
   	public function __construct(){
   	    global $db;
   		$this->conn = $db;
   	}
	/*function for adding Building*/
	public function addBuilding() {
			//check if the building name exists
			$area_query="select id, building_name from building where building_name='".$_POST['txtBname']."'";
			$q_res = mysqli_query($this->conn, $area_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			if(count($dataAll)>0)
			{
				$message="Building Name already exists.";
				$_SESSION['error_msg'] = $message;
				return 0;
			}else{
				//add the new building
				$currentDateTime = date("Y-m-d H:i:s");
				if ($result = mysqli_query($this->conn, "INSERT INTO building VALUES ('', '".$_POST['txtBname']."', '".$currentDateTime."', '".$currentDateTime."');")) {
   					$message="New building has been added successfully";
					$_SESSION['succ_msg'] = $message;
					return 1;
				}else{
					$message="Cannot add the building";
					$_SESSION['error_msg'] = $message;
					return 0;
				}
			}
	}
	/*function for listing Area*/
	public function viewBuld() {
			$area_query="select * from building order by date_update DESC";
			$q_res = mysqli_query($this->conn, $area_query);
			if(mysqli_num_rows($q_res)<=0){
				$message="There is not any building exists.";
				$_SESSION['error_msg'] = $message;
			}
			return $q_res;
	}
	
	/*function for fetch data using building ID*/
	public function getDataByBuldID($id) {
			$area_query="select * from building where id='".$id."' limit 1";
			$q_res = mysqli_query($this->conn, $area_query);
			if(mysqli_num_rows($q_res)<=0)
				return 0;
			else
				return $q_res;
	}
	/*function for Update Building*/
	public function updateBuld() {
			if ($result = mysqli_query($this->conn, "Update building  Set building_name = '".$_POST['txtBname']."', date_update = '".date("Y-m-d H:i:s")."' where id='".$_POST['buldId']."'")) {
   					$message="Building has been updated successfully";
					$_SESSION['succ_msg'] = $message;
					return 1;
				}else{
					$message="Cannot update the Building";
					$_SESSION['error_msg'] = $message;
					return 0;
				}
			}
}
