<?php
class Teacher {
   	// database connection and table name
   	private $conn;
   	public function __construct(){
   	    global $db;
   		$this->conn = $db;
   	}
	/*function for add professor*/
	public function addProfessor() {

		$txtPname = trim($_POST['txtPname']);
		$txtAreaAddress = trim($_POST['txtAreaAddress']);
		$dob = date("Y-m-d h:i:s", strtotime($_POST['dob']));
		$doj = date("Y-m-d h:i:s", strtotime($_POST['doj']));
		$sex = trim($_POST['sex']);
		$txtDegination = trim($_POST['txtDegination']);
		$txtQualification = trim($_POST['txtQualification']);
		$years = $_POST['years'];
		$months = $_POST['months'];

		$totalmonthExp = $years*12+$months;

		$txtEmail = trim($_POST['txtEmail']);
		$txtUname = trim($_POST['txtUname']);

		$result =  $this->conn->query("select email from teacher where email='".$txtEmail."'");
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
			 $_SESSION['succ_msg'] = $message;
             return 1;
           }

        }

	}

	/*function for edit professor*/
	public function editProfessor() {

		$edit_id = base64_decode($_POST['form_edit_id']);
		$txtPname = trim($_POST['txtPname']);
		$txtAreaAddress = trim($_POST['txtAreaAddress']);
		$dob = date("Y-m-d h:i:s", strtotime($_POST['dob']));
		$doj = date("Y-m-d h:i:s", strtotime($_POST['doj']));
		$sex = trim($_POST['sex']);
		$txtDegination = trim($_POST['txtDegination']);
		$txtQualification = trim($_POST['txtQualification']);
		$years = $_POST['years'];
		$months = $_POST['months'];

		$totalmonthExp = $years*12+$months;


	   $sql = "UPDATE teacher SET
	   	                teacher_name='".$txtPname."',
	   	                address='".$txtAreaAddress."',
	   	                dob='".$dob."',
	   	                doj='".$doj."',
	   	                gender='".$sex."',
	   	                designation='".$txtDegination."',
	   	                qualification='".$txtQualification."',
	   	                experience='".$totalmonthExp."',
	   	                date_update=now() WHERE id=$edit_id";
	   $rel = $this->conn->query($sql);
	   if(!$rel){
		  printf("%s\n", $this->conn->error);
		  exit();
	   }else{
		 $this->conn->close();
		 $message="Record has been updated successfully.";
		 $_SESSION['succ_msg'] = $message;
		 return 1;
	   }



	}

    //funtion to formate teacher experiance
	public function printTeacherExp($experience){

	    $years= floor($experience/12);
		$months = $experience-$years*12;
	    $yearexp = ($years > 0) ? $years.' year':'';

	    return $yearexp.' '.$months.' month';

	}

}
