<?php
class Classroom_Availability extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	/*function for adding class room availability*/
	public function addClassroomAvail() {
		    $roomId = (isset($_POST['slctRmName'])) ? ($_POST['slctRmName']) : '';
			$ruleId = (isset($_POST['ckbruleVal'])) ? ($_POST['ckbruleVal']) : '';
			$ruleIdArr=$this->formingArray($ruleId);
			//echo '<pre>';
			//print($ruleIdArr);
			$exceptionDate = (isset($_POST['exceptionDate'])) ? ($_POST['exceptionDate']) : '';
			$exceptionDateArr=$this->formingArray($exceptionDate);
			$currentDateTime = date("Y-m-d H:i:s");
			$i=0;
			foreach($ruleIdArr as $key=>$value){
				$ruleIdVal=$value;
			 	$rule_room_qry="INSERT INTO  classroom_availability_rule_room_map VALUES ('', '".$ruleIdVal."', '".$roomId."','".$currentDateTime."', '".$currentDateTime."')";
				$rule_room_qry_rslt=mysqli_query($this->conn,$rule_room_qry);
				if($rule_room_qry_rslt){
				 	$i++;
					 if($i==count($ruleIdArr)){
					 	  if($exceptionDate!=""){
						  	 $j=0;
						     foreach($exceptionDateArr as $k=>$v){
							 	//$exceptnDateVal=$v;
							 	$dateObj = new DateTime($v);
								$exceptnDateVal=$dateObj->format("Y-m-d H:i:s");
							 	
			 					$exception_qry="INSERT INTO classroom_availability_exception VALUES ('', '".$roomId."', '".$exceptnDateVal."','".$currentDateTime."', '".$currentDateTime."')";
								$exception_qry_rslt=mysqli_query($this->conn,$exception_qry);
								if($exception_qry_rslt){
								  	$j++;
								 		if($j==count($exceptionDateArr)){
											$message="Rules has been added successfully with exception";
						  					$_SESSION['succ_msg'] = $message;
						  					return 1;
										}
								}
							 
							 }
						  }
					   	  $message="Rules has been added successfully";
						  $_SESSION['succ_msg'] = $message;
						  return 1;
					  }
				}else{
					$message="Rules cannot added successfully2";
					$_SESSION['succ_msg'] = $message;
				    return 0;
				}
			}
	}
	
	/*function for updating class room availability*/
	public function updateClassroomAvail() {}
	/*function for get the timesolt */
	public function getTimeslot(){
	  $tmslot_query="select * from  timeslot";
	  $q_res = mysqli_query($this->conn, $tmslot_query);
		if(mysqli_num_rows($q_res)<=0)
			return 0;
		else
			return $q_res;
	}
	/*function for fectching class room type */
	public function getRoomType(){
	  $room_type_qry="select * from  room_type";
	  $q_res= mysqli_query($this->conn, $room_type_qry);
		if(mysqli_num_rows($q_res)<=0)
			return 0;
		else
			return $q_res;
	}
	public function formingArray($dataArr){
		 $newArr = array();
			foreach ($dataArr as $key => $val) {
					if (trim($val) <> "") {
					 $newArr[] = trim($val);
					}
			}
  		return $newArr;
	}
	public function getClassroomAvailRule()
	{
		$class_query="select id, rule_name, start_date, end_date from classroom_availability_rule ORDER BY id DESC"; 
		$q_res = mysqli_query($this->conn, $class_query);
		if(mysqli_num_rows($q_res)<=0){
			$message="No class availability rule exist.";
			$_SESSION['error_msg'] = $message;
		}
		return $q_res;
	}
	public function getClassroomAvailDay($id)
	{
		$classromm_avail_query="select id, timeslot_id, day from classroom_availability_rule_day_map where classroom_availability_rule_id ='".$id."'"; 
		$q_res = mysqli_query($this->conn, $classromm_avail_query);
		return $q_res;
	}
	public function getClassroomAvailTimeslot($ids)
	{
		$tmslot_query="select id, timeslot_range from timeslot where id IN(".$ids.")"; 
		$q_res = mysqli_query($this->conn, $tmslot_query);
		return $q_res;
	}
	public function getRuleIdsForRoom($ids)
	{   
	    $ruleid_room_query="select classroom_availability_rule_id from classroom_availability_rule_room_map where room_id =".$ids; 
		$q_res = mysqli_query($this->conn, $ruleid_room_query);
		$allIds = array();
		while($data = $q_res->fetch_assoc()){
			$allIds[] =  $data['classroom_availability_rule_id'];
		}
		return $allIds;
	}
	public function viewClassAvail(){
		$classAvail_query="select tartm.id, tar.rule_name, tr.room_name, tartm.classroom_availability_rule_id, tartm.room_id  from classroom_availability_rule_room_map as tartm LEFT JOIN classroom_availability_rule as tar ON tartm.classroom_availability_rule_id = tar.id LEFT JOIN room as tr ON tartm.room_id = tr.id"; 
		$q_res = mysqli_query($this->conn, $classAvail_query);
		//print_r($q_res);die;
		return $q_res;
	}
	
	public function getRoomTypeById($id){
	  $room_type_qry="select room_type_id,room_name from  room where id='".$id."'";
	  $q_res= mysqli_query($this->conn, $room_type_qry);
	  return $q_res;
	}
}