<?php
class Classroom_Availability extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	/*function for adding Subject*/
	//public function addSubject() {}
	/*function for listing Subject*/
	//public function viewSubject(){}
	/*function for fetch data using area ID*/
	//public function getDataBySubjectID($id) {}
	//public function updateSubject() {}
	//public function getProgramId(){}
	//public function getAreaId(){}
	//public function formingArray($dataArr){}
 
 	/*function for all subjects for add form*/
 	//public function getSubjects(){}
	public function getTimeslot(){
	  $tmslot_query="select * from  timeslot";
	  $q_res = mysqli_query($this->conn, $tmslot_query);
		if(mysqli_num_rows($q_res)<=0)
			return 0;
		else
			return $q_res;
		}

}