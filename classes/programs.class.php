<?php
class Programs {
   	// database connection and table name
   	private $conn;
   	public function __construct(){
   	    global $db;
   		$this->conn = $db;
   	}

   	/*function for add program*/
	public function addProgram() {

     	$txtPrgmName = trim($_POST['txtPrgmName']);
		$slctPrgmType = trim($_POST['slctPrgmType']);
		$prog_from_date = date("Y-m-d h:i:s", strtotime($_POST['prog_from_date']));
		$prog_to_date = date("Y-m-d h:i:s", strtotime($_POST['prog_to_date']));
		$slctNumcycle = trim($_POST['slctNumcycle']);

		$result =  $this->conn->query("SELECT program_name FROM program WHERE program_name='".$txtPrgmName."'");
		$row_cnt = $result->num_rows;
		if($row_cnt > 0){
			$this->conn->close();
			$message="'".$txtPrgmName."' program already exist in database.";
			$_SESSION['error_msg'] = $message;
			return 0;
		}

		$sql = "INSERT INTO program (program_name, program_type, start_date, end_date , date_add) VALUES ('".$txtPrgmName."', '".$slctPrgmType."', '".$prog_from_date."', '".$prog_to_date."', now())";
		$rel = $this->conn->query($sql);
		$last_ins_id = $this->conn->insert_id;
		if(!$rel){
			$_SESSION['error_msg'] = $this->conn->error;
			return 0;
		}else{
			for($i=1; $i<=$slctNumcycle; $i++){
			   $days = implode(',',$_POST['slctDays'.$i]);
			   $sql = "INSERT INTO cycle (program_id, no_of_cycle, start_week, end_week, days, date_add) VALUES ('".$last_ins_id."', '".$slctNumcycle."', '".$_POST['startweek'.$i]."', '".$_POST['endweek'.$i]."', '".$days."', now())";
			   $rel = $this->conn->query($sql);
			   if(!$rel){
					$_SESSION['error_msg'] = $this->conn->error;
					return 0;
			   }
			}
			$message="New program has been added successfully";
			$_SESSION['succ_msg'] = $message;
			return 1;
		}
	}

	//function to  a program by id
	public function getProgramById($id){
		$result =  $this->conn->query("select * from program where id='".$id."'");
		return $result;
    }
	//function to  get all programs
	public function getProgramListData(){
		$result =  $this->conn->query("select * from program");
		return $result;
    }
	//function to  get all cycles data related to a program
	public function getProgramCycleList($prog_id){
		$result =  $this->conn->query("select * from cycle where program_id='".$prog_id."'");
		return $result;
    }
    //function to get no of cycle
    public function getCyclesInProgram($prog_id){
    	$result =  $this->conn->query("select no_of_cycle from cycle where program_id='".$prog_id."'");
		$row = $result->fetch_assoc();
		return $row['no_of_cycle'];
    }
}
