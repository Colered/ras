<?php
abstract class Base
{
	public $conn;
	public function __construct(){
		global $db;
		$this->conn = $db;
	}

	//function to date format by datetime
	public function formatDate($date)
	{
		if(trim($date) != "") {
			$tempdate=explode(" ",$date);
			$date=$tempdate[0];
			if($date=="0000-00-00") {
				$date="";
			} else  {
				$dateArr = explode("-", $date);
				$year=$dateArr[0];
				$month=$dateArr[1];
				$day=$dateArr[2];
				$date_mktime = mktime(0, 0, 0, $month, $day, $year);
				$date = date("d-m-Y",$date_mktime);
			}
			return $date;
		}

	}
    //function to date format by date
	public function formatDateByDate($date)
	{
		if(trim($date) != "") {
			if($date=="0000-00-00") {
				$date="";
			} else  {
				$dateArr = explode("-", $date);
				$year=$dateArr[0];
				$month=$dateArr[1];
				$day=$dateArr[2];
				$date_mktime = mktime(0, 0, 0, $month, $day, $year);
				$date = date("d-m-Y",$date_mktime);
			}
			return $date;
		}

	}//end of formatDate function

	//function to clean input text
	public function cleanText($txt){
		$str = strip_tags($txt);
		return trim($str);
	}
	//function to fetch a
	public function getFielldVal($table,$field,$k,$v)
	{
       if($v){
            $field = trim($field);
			$sql = "SELECT $field FROM $table WHERE $k='".$v."' LIMIT 1";
			$result = $this->conn->query($sql);
			$row = $result->fetch_assoc();
			return $row[$field];
	   }else{
			return '';
	   }
	}

	//function to find all weeks in a date range
	public function getWeeksInDateRange($start,$end)
	{
       	$dateOne = $start; $dateTwo = $end;
		$dateStart = $dateOne; $dateEnd = $dateTwo;
		if(strtotime($dateOne)>strtotime($dateTwo)){
			$dateStart = $dateTwo;
			$dateEnd = $dateOne;
		}
		//calculate start week
		while (date('w', strtotime($dateStart)) != 1) {
		  $tmp = strtotime('-1 day', strtotime($dateStart));
		  $dateStart = date('Y-m-d', $tmp);
		}
		$weekStart = intval(date('W', strtotime($dateStart)));
		//calculate end week
		while (date('w', strtotime($dateEnd)) != 1) {
		  $tmp = strtotime('-1 day', strtotime($dateEnd));
		  $dateEnd = date('Y-m-d', $tmp);
		}
		$weekEnd = intval(date('W', strtotime($dateEnd)));
		//prepare array for all weeks coming in the date range
		$allWeeks = array();
		for($i=$weekStart; $i<=$weekEnd; $i++){
			$allWeeks[] = $i;
		}
		return $allWeeks;
	}


}