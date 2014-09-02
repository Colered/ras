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
				list($year,$month,$day) = split("-", $date);
				$date_mktime = mktime(0, 0, 0, $month, $day, $year);
				$date = date("d-m-Y",$date_mktime);
			}
			return $date;
		} else {
			return "N/A";
		}

	}//end of formatDate function

}