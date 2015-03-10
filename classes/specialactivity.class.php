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
}
