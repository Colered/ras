<?php
class Teacher {
   	// database connection and table name
   	private $conn;
   	public function __construct(){
   	    global $db;
   		$this->conn = $db;
   	}
	/*function for user login*/
	public function addProfessor() {

		$txtPname = trim($_POST['txtPname']);
		$txtAreaAddress = trim($_POST['txtAreaAddress']);
		$dob = date("Y-m-d h:i:s", strtotime($_POST['dob']));
		$doj = date("Y-m-d h:i:s", strtotime($_POST['doj']));
		$sex = trim($_POST['sex']);
		$txtDegination = trim($_POST['txtDegination']);
		$txtQualification = trim($_POST['txtQualification']);
		$years = $_POST['years'];
		$month = $_POST['month'];

		$totalmonthExp = $years*12+$month;

		$txtEmail = trim($_POST['txtEmail']);
		$txtUname = trim($_POST['txtUname']);

		$result =  $this->conn->query("select email from teacher where username='".$txtEmail."'");
        $row_cnt_email = $result->num_rows;

        $result =  $this->conn->query("select username from teacher where username='".$txtUname."'");
		$row_cnt = $result->num_rows;


        if($row_cnt_email > 0){
            $this->conn->close();
            $message="'".$txtEmail."' email already exist in database.";
			$_SESSION['error_msg'] = $message;
			return 0;

        }elseif($row_cnt > 0){
            $this->conn->close();
            $message="'".$txtUname."' username already exist in database.";
			$_SESSION['error_msg'] = $message;
			return 0;

        }else{
           $sql = "INSERT INTO teacher (teacher_name, address, dob, doj, gender, designation, qualification, experience, email, username, date_add, date_update) VALUES ('".$txtPname."', '".$txtAreaAddress."', '".$dob."', '".$doj."', '".$sex."', '".$txtDegination."', '".$txtQualification."', '".$totalmonthExp."', '".$txtEmail."', '".$txtUname."', now(), '')";
           $rel = $this->conn->query($sql);
           if(!$rel){
              printf("%s\n", $this->conn->error);
   			  exit();
           }else{
             $this->conn->close();
             $message="Record has been added successfully.";
			 $_SESSION['error_msg'] = $message;
             return 1;
           }

        }

	}

	public function printTeacherExp($experience){

	    $year = floor($experience/12);
		$months = $experience-$year*12;
	    $yearexp = ($year > 0) ? $year.' year':'';

	    return $yearexp.' '.$months.' month';

	}

}
