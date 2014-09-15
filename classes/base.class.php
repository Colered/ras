<?php
abstract class Base
{
	public $conn;
	public function __construct(){
		global $db;
		$this->conn = $db;
	}

	//formatDate function
	//reads the file contents
	//Input parameters : 1) date
	//Output parameters : 1) formated date string
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

	}//end of formatDate function

	//function to clean input text
	public function cleanText($txt){
	    $str = addslashes($txt);
		$str = strip_tags($str);
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


}