<?php
class Holidays extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	/*function for adding Building*/
	public function addHoliday() {
			if(isset($_POST['holiday_date']) && $_POST['holiday_date'] !=""){
				//check if the building name exists
				$area_query="select id, holiday_date from holidays where holiday_date='".$_POST['holiday_date']."'";
				$q_res = mysqli_query($this->conn, $area_query);
				$dataAll = mysqli_fetch_assoc($q_res);
				if(count($dataAll)>0)
				{
					$message="Holiday Date already exists.";
					$_SESSION['error_msg'] = $message;
					return 0;
				}else{
					//add the new building
					$currentDateTime = date("Y-m-d H:i:s");
					if ($result = mysqli_query($this->conn, "INSERT INTO holidays VALUES ('', '".$_POST['holiday_date']."', '".Base::cleanText($_POST['holiday_reason'])."', '".$currentDateTime."', '".$currentDateTime."');")) {
						$message="New Holiday has been added successfully";
						$_SESSION['succ_msg'] = $message;
						return 1;
					}else{
						$message="Cannot add the holiday";
						$_SESSION['error_msg'] = $message;
						return 0;
					}
				}
			}else{
					$message="Please enter a valid holiday date";
					$_SESSION['error_msg'] = $message;
					return 0;
			}
	}
	/*function for listing Area*/
	public function viewHoliday() {
			$area_query="select * from holidays order by date_update DESC";
			$q_res = mysqli_query($this->conn, $area_query);
			return $q_res;
	}

	/*function for fetch data using building ID*/
	public function getDataByHolidayID($id) {
			$area_query="select * from holidays where id='".$id."' limit 1";
			$q_res = mysqli_query($this->conn, $area_query);
			if(mysqli_num_rows($q_res)<=0)
				return 0;
			else
				return $q_res;
	}
	/*function for Update Building*/
	public function updateHoliday() {
			//check if the holidate date exists
			$holiday_query="select id, holiday_date from holidays where holiday_date='".$_POST['holiday_date']."' and id !='".$_POST['holidayId']."'";
			$q_res = mysqli_query($this->conn, $holiday_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			if(count($dataAll)>0) {
				$message="Holiday Date already exists.";
				$_SESSION['error_msg'] = $message;
				return 0;
			}elseif ($result = mysqli_query($this->conn, "Update holidays Set holiday_date = '".$_POST['holiday_date']."', holiday_reason = '".Base::cleanText($_POST['holiday_reason'])."', date_update = '".date("Y-m-d H:i:s")."' where id='".$_POST['holidayId']."'")) {
				$message="Holiday has been updated successfully";
				$_SESSION['succ_msg'] = $message;
				return 1;
			}else{
				$message="Cannot update the Holiday";
				$_SESSION['error_msg'] = $message;
				return 0;
			}
    }
}
