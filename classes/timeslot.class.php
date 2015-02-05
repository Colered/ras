<?php
class Timeslot extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	/*function for adding Area*/
	public function addTimeslot()
	{
			$start = $_POST['start_time'];
			$end = $_POST['end_time'];
			$timeslot = $start.' - '.$end;
			//check if the timeslot is clashed with some other time.
			$area_query="select id from timeslot where start_time = '".$start."' AND end_time = '".$end."'";
			$q_res = mysqli_query($this->conn, $area_query);
			$dataAll = mysqli_fetch_assoc($q_res);
			if(count($dataAll)>0)
			{
				$message="Timeslot <b>".$timeslot."</b> cannot be added as being clashed with some other time slot.";
				$_SESSION['error_msg'] = $message;
				return 0;
			}else{
				//add the new timeslot
				$start2 = $_POST['start_time'];
				$end2 =  $_POST['end_time'];
				$timeslot = $start2.'-'.$end2;
				$currentDateTime = date("Y-m-d H:i:s");
				if ($result = mysqli_query($this->conn, "INSERT INTO timeslot VALUES ('', '".$start."', '".$end."', '".$timeslot."', '".$currentDateTime."', '".$currentDateTime."');")) {
   					$message="New timeslot has been added successfully";
					$_SESSION['succ_msg'] = $message;
					return 1;
				}else{
					$message="Cannot add the timeslot, please try again";
					$_SESSION['error_msg'] = $message;
					return 0;
				}
			}
	}
	/*function for listing timeslot*/
	public function viewTimeslot() {
			$area_query="select * from timeslot order by id ASC";
			$q_res = mysqli_query($this->conn, $area_query);
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
	//function to get time slot dropdown
	public function getTimeSlotDropDwn(){
		$tslot_dropDwn = '';
		$slqTS="SELECT id, timeslot_range FROM timeslot";
		$relTS = mysqli_query($this->conn, $slqTS);
		while($tsdata= mysqli_fetch_array($relTS)){
			$tslot_dropDwn .= '<option value="'.$tsdata['id'].'">'.$tsdata['timeslot_range'].'</option>';
		}
		return $tslot_dropDwn;
	}
	//get ts by ts ids
	public function getTSbyIDs($tsids) {
			$tsbyids_query="select * from timeslot where id IN $tsids; ";
			$q_res = mysqli_query($this->conn, $tsbyids_query);
			$allTSVal = array();
			while($tsdata= mysqli_fetch_array($q_res)){
				//$allTSVal[] = $tsdata['start_time'].'-'.$tsdata['end_time'];
				$startArr[] = $tsdata['start_time'];
				$endArr[] = $tsdata['end_time'];
			}
			$startnewArr = array_diff($startArr,$endArr);
			$endnewArr = array_diff($endArr,$startArr);
			foreach($startnewArr as $val){
			   $startTmpArr[] = $val;
			}
			foreach($endnewArr as $val2){
			   $endTmpArr[] = $val2;
			}
			for($i=0;$i<count($startTmpArr);$i++){
               $allTSVal[] = $startTmpArr[$i].'-'.$endTmpArr[$i];
			}
			return $allTSVal;
	}
	//function to get time slot start date
	public function getTimeSlotStartDateDropDwn(){
		$tslot_dropDwn = '';
		$slqTS="SELECT id, start_time FROM timeslot";
		$relTS = mysqli_query($this->conn, $slqTS);
		while($tsdata= mysqli_fetch_array($relTS)){
			$tslot_dropDwn .= '<option value="'.$tsdata['id'].'">'.$tsdata['start_time'].'</option>';
		}
		return $tslot_dropDwn;
	}
	public function getTSbyIDsForProgramAvailbility($tsids) {
			$tsbyids_query="select * from timeslot where id IN $tsids; ";
			$q_res = mysqli_query($this->conn, $tsbyids_query);
			$allTSVal = array();
			while($tsdata= mysqli_fetch_array($q_res)){
				$allTSVal[] = $tsdata['start_time'].'-'.$tsdata['end_time'];
			}
			$ts_val=implode(',',$allTSVal);
			return $ts_val;
	}
	//get the allocated activities dates with timeslots
	public function getAllocatedDates($class_id='',$teacher_id='',$program_year_id='')
	{
		$allocatedDates = array();
		$objT = new Teacher();
		if(isset($class_id) && $class_id!=""){
			 $res_sql = "select date,group_concat(timeslot) as timeslot  from  timetable_detail td where room_id = '".$class_id."'  group by date";
		}else if(isset($teacher_id) && $teacher_id!=""){
			 $res_sql = "select date,group_concat(timeslot) as timeslot from  timetable_detail td where teacher_id = '".$teacher_id."'  group by date";
		}else{
			 $res_sql = "select date,group_concat(timeslot) as timeslot from  timetable_detail td where program_year_id = '".$program_year_id."'  group by date";
		}
		
		$res_query = mysqli_query($this->conn, $res_sql);
		while($data = $res_query->fetch_assoc()){
			$all_ts = $this -> getTimeslotIds($data['timeslot']);
			$activity_date = date("Ymd",strtotime($data['date']));
			$allocatedDates[$activity_date]['act_date'] =  $activity_date;
			$allocatedDates[$activity_date]['ts_id'] =  $all_ts;
		}
		/*echo '<pre>';
		print_r($allocatedDates);die;*/
		return $allocatedDates;		
	}
	//get the timetable ids
	public function getTimeslotIds($dateRange)
	{		
			//echo '<pre>';
	        //print_r($dateRange);
			$timeRangeArr=explode(',',$dateRange);
			foreach($timeRangeArr as $value){
				$time = explode("-",$value);
				$start_time  = trim($time['0']);
				$end_time = trim($time['1']);
				$sql_time_slct = "select id from timeslot where start_time = '".$start_time."' OR end_time = '".$end_time."'";
				//get all the ids between two nos
				$q_res= mysqli_query($this->conn, $sql_time_slct);
				$tempIdRange= array();
				while($data = $q_res->fetch_assoc()){
					$tempIdRange[] =  $data['id'];
				}
				for($i=min($tempIdRange); $i<=max($tempIdRange); $i++){
					$timeslots[] = $i;
				}				
				$timeslotIds = implode(',',$timeslots);	
		   }	
		   //echo '<br>'.'===========================';
		   //print_r($timeslotIds);
		   return $timeslotIds;
	}
	//getting timeslote date range to show the allocated timeslot on view calender
	public function getAllocatedTSRangeForView($teacher_id,$class_room_id,$program_year_id,$date)
	{
		$ts_rangeArr=array();
	    $allocated_date=date("Y-m-d", strtotime($date));
		if(isset($class_room_id) && $class_room_id!=""){
			$res_sql = "select date,group_concat(timeslot) as timeslot from  timetable_detail td where room_id = '".$class_room_id."' and date='".$allocated_date."' group by date";
		}else if(isset($teacher_id) && $teacher_id!=""){
			$res_sql = "select date,group_concat(timeslot) as timeslot from  timetable_detail td where teacher_id = '".$teacher_id."' and date='".$allocated_date."' group by date";
		}else{
			$res_sql = "select date,group_concat(timeslot) as timeslot from  timetable_detail td where program_year_id = '".$program_year_id."' and date='".$allocated_date."' group by date";
		}
		$res_query = mysqli_query($this->conn, $res_sql);
		$data = $res_query->fetch_assoc();
		$ts_rangeArr=explode(',',$data['timeslot']);
		return $ts_rangeArr;		
	}
	//getting all allocated date
	public function getAllAllocatedDate($teacher_id,$class_id,$program_year_id){
		$allocated_date_Arr=array();
		if($program_year_id!=""){
			$sql_query="SELECT date FROM timetable_detail WHERE program_year_id ='".$program_year_id."' GROUP BY date";
		}elseif($teacher_id!=""){
			$sql_query="SELECT date FROM timetable_detail WHERE teacher_id ='".$teacher_id."' GROUP BY date";
		}else{
			$sql_query="SELECT date FROM timetable_detail WHERE room_id  ='".$class_id."' GROUP BY date";
		}
		$res_query = mysqli_query($this->conn, $sql_query);
		while($data = mysqli_fetch_array($res_query)){
				$allocated_date_Arr[]=date("Ymd", strtotime($data['date']));
		}
		return $allocated_date_Arr;
	}

}
