<?php
class Areas extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	/*function for adding Area*/
	public function addArea() {
			//check if the area code already exists
			$area_query="select area_name, area_code from area where area_code='".Base::cleanText($_POST['txtAreaCode'])."'";
			$q_res = mysqli_query($this->conn, $area_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			if(count($dataAll)>0)
			{
				$message="Area code already exists.";
				$_SESSION['error_msg'] = $message;
				return 0;
			}else{
				//add the new area
				$currentDateTime = date("Y-m-d H:i:s");
				if ($result = mysqli_query($this->conn, "INSERT INTO area VALUES ('', '".Base::cleanText($_POST['txtAreaName'])."', '".Base::cleanText($_POST['txtAreaCode'])."', '".$_POST['txtAColor']."', '".$currentDateTime."', '".$currentDateTime."');")) {
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
	public function viewArea() {
			$area_query="select * from area order by date_update DESC";
			$q_res = mysqli_query($this->conn, $area_query);
			/*if(mysqli_num_rows($q_res)<=0){
				$message="There is not any area exists.";
				$_SESSION['error_msg'] = $message;
			}*/
			return $q_res;
	}

	/*function for fetch data using area ID*/
	public function getDataByAreaID($id) {
			$area_query="select * from area where id='".$id."' limit 1";
			$q_res = mysqli_query($this->conn, $area_query);
			/*if(mysqli_num_rows($q_res)<=0)
				return 0;
			else*/
			return $q_res;
	}
	/*function for Update Area*/
	public function updateArea()
	{
		
		//check if the area code already exists
		$area_query="select area_name, area_code from area where area_code='".Base::cleanText($_POST['txtAreaCode'])."' and id !='".$_POST['areaId']."'";
		$q_res = mysqli_query($this->conn, $area_query);
		$dataAll = mysqli_fetch_assoc($q_res);
		if(count($dataAll)>0)
		{
			
			$message="Area code already exists.";
			$_SESSION['error_msg'] = $message;
			header('Location: areas.php?edit='.base64_encode($_POST['areaId']));
			return 0;
		}elseif ($result = mysqli_query($this->conn, "Update area  Set area_name = '".Base::cleanText($_POST['txtAreaName'])."', area_code = '".Base::cleanText($_POST['txtAreaCode'])."', area_color = '".$_POST['txtAColor']."' , date_update = '".date("Y-m-d H:i:s")."' where id='".$_POST['areaId']."'")) {
				$message="Area has been updated successfully";
				$_SESSION['succ_msg'] = $message;
				return 1;
			}else{
				$message="Cannot update the area";
				$_SESSION['error_msg'] = $message;
				header('Location: areas.php?edit='.base64_encode($_POST['areaId']));
				return 0;
			}
	}
		
	 public function detailArea() {
			$area_query="select * from area order by area_name";
			$q_res = mysqli_query($this->conn, $area_query);
			return $q_res;
	}
	public function getWebAreaDetail($area_id='')
	{   
	$row=$rowmainArr=$newArr=array();
	$result =  $this->conn->query("SELECT we.cal_name, we.cal_description, we.cal_date, we.cal_time, we.cal_id, we.cal_ext_for_id, we.cal_priority, we.cal_access, we.cal_duration, weu.cal_status, we.cal_create_by, weu.cal_login, we.cal_type, we.cal_location, we.cal_url, we.cal_due_date, we.cal_due_time, weu.cal_percent, we.cal_mod_date, we.cal_mod_time FROM webcal_entry we,webcal_entry_user weu WHERE we.cal_id = weu.cal_id and we.area_id='".$area_id."' ORDER BY we.cal_time, we.cal_name ");
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
