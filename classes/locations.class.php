<?php
class Locations extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	/*function for adding Location*/
	public function addLocation() {
			if(Base::cleanText($_POST['txtLname']) !=""){
				//check if the Location name exists
				$area_query="select id, name from location where name='".Base::cleanText($_POST['txtLname'])."'";
				$q_res = mysqli_query($this->conn, $area_query);
				$dataAll = mysqli_fetch_assoc($q_res);
				if(count($dataAll)>0)
				{
					$message="Location Name already exists.";
					$_SESSION['error_msg'] = $message;
					return 0;
				}else{
					//add the new Location
					$currentDateTime = date("Y-m-d H:i:s");					
					//add the new value
					if ($result = mysqli_query($this->conn, "INSERT INTO location VALUES ('', '".Base::cleanText($_POST['txtLname'])."', '".$currentDateTime."', '".$currentDateTime."');")) {
						$message="New Location has been added successfully";
						$_SESSION['succ_msg'] = $message;
						return 1;
					}else{
						$message="Cannot add the Location";
						$_SESSION['error_msg'] = $message;
						return 0;
					}
				}
			}else{
					$message="Please enter a valid Location name";
					$_SESSION['error_msg'] = $message;
					return 0;
			}
	}
	/*function for listing Area*/
	public function viewLoc() {
			$area_query="select * from location order by id ASC";
			$q_res = mysqli_query($this->conn, $area_query);
			return $q_res;
	}

	/*function for fetch data using Location ID*/
	public function getDataByLocID($id) {
			$area_query="select * from location where id='".$id."' limit 1";
			$q_res = mysqli_query($this->conn, $area_query);
			if(mysqli_num_rows($q_res)<=0)
				return 0;
			else
				return $q_res;
	}
	/*function for Update Location*/
	public function updateLoc() {
			//check if the Location name exists
			$area_query="select id, name from location where name='".Base::cleanText($_POST['txtLname'])."' and id !='".$_POST['locId']."'";
			$q_res = mysqli_query($this->conn, $area_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			
			if(count($dataAll)>0) {
				$message="Location Name already exists.";
				$_SESSION['error_msg'] = $message;
				header('Location: locations.php?edit='.base64_encode($_POST['locId']));
				return 0;
			}elseif ($result = mysqli_query($this->conn, "Update location set name = '".Base::cleanText($_POST['txtLname'])."', date_update = '".date("Y-m-d H:i:s")."' where id='".$_POST['locId']."'")) {
				$message="Location has been updated successfully";
				$_SESSION['succ_msg'] = $message;
				return 1;
			}else{
				$message="Cannot update the Location";
				$_SESSION['error_msg'] = $message;
				header('Location: locations.php?edit='.base64_encode($_POST['locId']));
				return 0;
			}
    }    
}
