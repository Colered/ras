<?php
class SpecialActivity extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	/*function for add professor*/
	public function getRuleIdsForSpecialAct($ids)
	{
		$special_avail_query="select special_activity_rule_id from  special_activity_rule_teacher_map where teacher_id =".$ids;
		$q_res = mysqli_query($this->conn, $special_avail_query);
		$allIds = array();
		while($data = $q_res->fetch_assoc()){
			$allIds[] =  $data['special_activity_rule_id'];
		}
		return $allIds;
	}
	public function getSpecialAvailDay($id)
	{
		$area_query="select id, timeslot_id, day_name from special_activity_rule_day_map where special_activity_rule_id ='".$id."'";
		$q_res = mysqli_query($this->conn, $area_query);
		return $q_res;
	}
	public function getSpecialAvailRule()
	{
		$specia_act_query="select id, rule_name, start_date, end_date from special_activity_rule WHERE rule_name<>'Always Available' ORDER BY id DESC";
		$q_res = mysqli_query($this->conn, $specia_act_query);
		return $q_res;
	}
	public function ruleStartEndDate($rule_id){
		$query = mysqli_query ($this->conn, "SELECT start_date , end_date FROM  special_activity_rule WHERE  id='".$rule_id."' ");
		$data = $query->fetch_assoc();
		return $data;
	}
	public function activityLastReocrd(){
		$query = mysqli_query($this->conn, "SELECT id,name FROM teacher_activity ORDER BY id DESC LIMIT 1");
		$data=$query->fetch_assoc();
		return $data;
	}
	public function ruleTimeslotandDay($ruleId){
		$query = mysqli_query($this->conn, "SELECT id,actual_timeslot_id,day FROM  special_activity_rule_day_map  WHERE  special_activity_rule_id='".$ruleId."' ");
		while($data = $query->fetch_assoc()){
				$timeslot[$data['day']] =  $data['actual_timeslot_id'];
		}
		return $timeslot;
	}
	public function getExceptionDate($ruleId){
		//echo "hello";
		$exceptionDate=array();
		$query = mysqli_query($this->conn, "SELECT exception_date FROM special_activity_exception  WHERE  special_activity_rule_id='".$ruleId."' ");
		while($data = $query->fetch_assoc()){
				$exceptionDate[] =  $data['exception_date'];
		}
		//echo $ruleId;
		//print_r($exceptionDate);
		
		return $exceptionDate;
	}
}
