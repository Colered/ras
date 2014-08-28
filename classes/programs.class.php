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

		foreach($_POST as $i=>$k){
		    echo "<br>"."$i=$k";
		}
		die;

		$txtPrgmName = trim($_POST['txtPrgmName']);
		$slctPrgmType = trim($_POST['slctPrgmType']);
		$prog_from_date = trim($_POST['prog_from_date']);
		$prog_to_date = trim($_POST['prog_to_date']);

		$slctNumcycle = trim($_POST['slctNumcycle']);


		for($i=1; $i<=$slctNumcycle; $i++){

		   $sql = "INSERT INTO cycle (program_id, no_of_cycle, start_week, end_week, days, date_add) VALUES ('1', '".$slctNumcycle."', '".$_POST['startweek'.$i]."', '".$_POST['endweek1'.$i]."', '324324', now())";
		   $rel = $this->conn->query($sql);
		   if(!$rel){
			  printf("%s\n", $this->conn->error);
			  exit();
		   }
		}

		$txtPrgmName = trim($_POST['txtPrgmName']);
		$txtPrgmName = trim($_POST['txtPrgmName']);
		$txtPrgmName = trim($_POST['txtPrgmName']);
		$txtPrgmName = trim($_POST['txtPrgmName']);
		$txtPrgmName = trim($_POST['txtPrgmName']);

	}

	//function to  a program by id
	public function getProgramById($id){
		$result =  $this->conn->query("select * from teacher where id='".$id."'");
		return $result;
    }
}
