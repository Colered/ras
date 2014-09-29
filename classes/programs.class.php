<?php
class Programs extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
   	/*function for add program*/
	public function addProgram()
	{
     	$txtPrgmName = Base::cleanText($_POST['txtPrgmName']);
     	$txtCompanyName = Base::cleanText($_POST['txtCompanyName']);
		$slctPrgmType = $_POST['slctPrgmType'];
		$prog_from_date = date("Y-m-d h:i:s", strtotime($_POST['prog_from_date']));
		$prog_to_date = date("Y-m-d h:i:s", strtotime($_POST['prog_to_date']));
		$slctNumcycle = trim($_POST['slctNumcycle']);
		$slctUnit = implode(',',$_POST['slctUnit']);

		$result =  $this->conn->query("SELECT program_name FROM program WHERE program_name='".$txtPrgmName."'");
		$row_cnt = $result->num_rows;
		if($row_cnt > 0){
			$this->conn->close();
			$message="'".$txtPrgmName."' program already exist in database.";
			$_SESSION['error_msg'] = $message;
			return 0;
		}
		$sql = "INSERT INTO program (program_name,unit,company, program_type, start_date, end_date , date_add) VALUES ('".$txtPrgmName."','".$slctUnit."','".$txtCompanyName."', '".$slctPrgmType."', '".$prog_from_date."', '".$prog_to_date."', NOW())";
		$rel = $this->conn->query($sql);
		$last_ins_id = $this->conn->insert_id;
		if(!$rel){
			$_SESSION['error_msg'] = $this->conn->error;
			return 0;
		}else{
			//INSERT PROGRAM YEARS  DATA
			for($j=1; $j<=$slctPrgmType; $j++){
				$progName = $txtPrgmName.'-'.$j;
				$start_year = date("Y", strtotime($prog_from_date));
				$start_year = $start_year + ($j-1);
				$end_year = $start_year + 1;
				$sql = "INSERT INTO program_years (program_id, name, start_year, end_year) VALUES ('".$last_ins_id."', '".$progName."', '".$start_year."', '".$end_year."')";
				$rel = $this->conn->query($sql);
			}
			//END HERE
			$message="New program has been added successfully";
			$_SESSION['succ_msg'] = $message;
			return 1;
		}

	}

	/*function for add program*/
	public function editProgram()
	{
		$edit_id = base64_decode($_POST['programId']);
		$txtPrgmName = Base::cleanText($_POST['txtPrgmName']);
     	$txtCompanyName = Base::cleanText($_POST['txtCompanyName']);
		$slctPrgmType = $_POST['slctPrgmType'];
		$prog_from_date = date("Y-m-d h:i:s", strtotime($_POST['prog_from_date']));
		$prog_to_date = date("Y-m-d h:i:s", strtotime($_POST['prog_to_date']));
		$slctUnit = implode(',',$_POST['slctUnit']);

		$result =  $this->conn->query("SELECT program_name FROM program WHERE program_name='".$txtPrgmName."' AND id != '".$edit_id."'");
		$row_cnt = $result->num_rows;
		if($row_cnt > 0){
			$this->conn->close();
			$message="'".$txtPrgmName."' program already exist in database.";
			$_SESSION['error_msg'] = $message;
			return 0;
		}
		if($edit_id){
			$sql = "UPDATE program SET
						   program_name = '".$txtPrgmName."',
						   unit = '".$slctUnit."',
						   company = '".$txtCompanyName."',
						   program_type = '".$slctPrgmType."',
						   start_date = '".$prog_from_date."',
						   end_date = '".$prog_to_date."',
						   date_update = now() WHERE id=$edit_id";
			$rel = $this->conn->query($sql);
			if(!$rel){
				$_SESSION['error_msg'] = $this->conn->error;
				return 0;
			}
			$result =  $this->conn->query("SELECT id FROM program_years WHERE program_id='".$edit_id."'");
			$row_cnt = $result->num_rows;
			if($row_cnt > 0){
			  $z = 1;
			  while($row = $result->fetch_assoc()){
					$progName = $txtPrgmName.'-'.$z;
					$start_year = date("Y", strtotime($prog_from_date));
					$start_year = $start_year + ($z-1);
					$end_year = $start_year + 1;

                    $sql = "UPDATE program_years SET
				  						   name = '".$progName."',
				  						   start_year = '".$start_year."',
				  						   end_year = '".$end_year."' WHERE id='".$row['id']."'";

			        $rel = $this->conn->query($sql);
			        $z++;
			  }
			  if($slctPrgmType < ($z-1)){
			    for($j=($slctPrgmType+1); $j <= ($z-1); $j++){
					 $progName = $txtPrgmName.'-'.$j;
					 // delete all the program years which are not need
					 $py_rel =  $this->conn->query("SELECT id FROM program_years WHERE name='".$progName."' AND program_id='".$edit_id."'");
					 $py_row_cnt = $py_rel->num_rows;
					 if($py_row_cnt > 0){
					   while($row = $py_rel->fetch_assoc()){
						  $this->deleteProgFromYear($row['id']);
					   }
					 }
			    }

			  }else if($slctPrgmType > ($z-1)){
			     for($j=$z; $j<=$slctPrgmType; $j++){
					$progName = $txtPrgmName.'-'.$j;
					$start_year = date("Y", strtotime($prog_from_date));
					$start_year = $start_year + ($j-1);
					$end_year = $start_year + 1;

					$sql = "INSERT INTO program_years (program_id, name, start_year, end_year) VALUES ('".$edit_id."', '".$progName."', '".$start_year."', '".$end_year."')";
					$rel = $this->conn->query($sql);
				 }
			  }
			}
			$message="Record has been updated successfully";
			$_SESSION['succ_msg'] = $message;
			return 1;

		}else{
			$message="Record could not be updated. Try again.";
			$_SESSION['error_msg'] = $message;
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
		$result =  $this->conn->query("select * from cycle where program_year_id='".$prog_id."'");
		return $result;
    }
    //function to get no of cycle
    public function getCyclesInProgram($prog_id){
    	$result =  $this->conn->query("select no_of_cycle from cycle where program_year_id='".$prog_id."' limit 1");
		$row = $result->fetch_assoc();
		return $row['no_of_cycle'];
    }
    //function to get cycle info by program id
    public function getCyclesInfo($prog_id){
        $SQL = "select distinct start_week,end_week,days from cycle where program_year_id ='".$prog_id."'";
    	$result =  $this->conn->query($SQL);
    	$row_cnt = $result->num_rows;
        $data = '';
        $numSufArr = array('0'=>'1st','1'=>'2nd','2'=>'3rd');
        $daysDBArr = array('0'=>'Mon','1'=>'Tue','2'=>'Wed','3'=>'Thu','4'=>'Fri','5'=>'Sat','6'=>'Sun');
		if($row_cnt > 0){
		    $data .= '<table cellspacing="0" cellpadding="0" style="border:none;">';
			$data .= '<tr><td>Number of Cycle:'.$this->getCyclesInProgram($prog_id).'</td></tr>';
			$i=0;
			while($row = $result->fetch_assoc()){
			   $daysArr = explode(',',$row['days']);
			   $finalDays = array();
			   foreach($daysArr as $val){
                  $finalDays[] = $daysDBArr[$val];
			   }
			   $finalDays = implode(',',$finalDays);
			   $cycle = $numSufArr[$i];
			   $start_date = $this->formatDateByDate($row['start_week']);
			   $end_date = $this->formatDateByDate($row['end_week']);

               $data .= '<tr><td>'.$cycle.' cycle:'.$start_date.' - '.$end_date.' ('.$finalDays.')</td></tr>';
               $data .= $this->getProgCycleList($prog_id,$i);
               $i++;
			}
			$data .= '</table>';
		}
		return $data;
    }
    //function to get program cycle exceptions
    public function getProgCycleList($py_id,$cycle_num)
    {
        $query = "select exception_date from program_cycle_exception where program_year_id='".$py_id."' AND cycle_id='".$cycle_num."'";
	  	$result= $this->conn->query($query);
	  	$num_rows = $result->num_rows;
	  	$dt = '';
	  	if($num_rows){
	  	    $dt .= '<tr><td>Exceptions:</td></tr>';
			while($row = $result->fetch_assoc()){
               $dt .= '<tr><td style="padding-left:100px;">'.$row['exception_date'].'</td></tr>';
			}
			return $dt;
		}
    }

	/*function for add student group*/
	public function associateStudentGroup()
	{
		$slctProgram = trim($_POST['slctProgram']);
		$slctSgroups = $_POST['slctSgroups'];

		//delete all the previous program groups and insert again
		$del_query="DELETE FROM program_group WHERE program_year_id='".$slctProgram."'";
		$qry = mysqli_query($this->conn, $del_query);

		foreach($slctSgroups as $val){
			$sql = "INSERT INTO program_group (program_year_id, group_id) VALUES ('".$slctProgram."', '".$val."')";
			$rel = $this->conn->query($sql);
		}

		$message="Program has been associated successfully";
		$_SESSION['succ_msg'] = $message;
		return 1;
	}

	//Function to list all the available groups list
	public function getGroupsList(){
		$result =  $this->conn->query("select * from group_master");
		return $result;
	}
	//Function to list sub programs
	public function getSubPrograms($pid){
		$result =  $this->conn->query("SELECT name FROM program_years WHERE program_id='".$pid."'");
		$row_cnt = $result->num_rows;
		$data = '';
		if($row_cnt){
          $data .= '<ul>';
          while($rr = $result->fetch_assoc()){
              $data .= '<li>'.$rr['name'].'</li>';
          }
          $data .= '</ul>';
		}
		return $data;
	}
	//Function to list all groups of a program
	public function getAllGroupByProgId($prog_id){
	    $SQL = "select * from group_master where id in(select group_id FROM program_group WHERE program_year_id='".$prog_id."')";
		$result =  $this->conn->query($SQL);
		return $result;
	}
	//function to  get all programs according to years
	public function getProgramListYearWise(){
		$result =  $this->conn->query("select * from program_years");
		return $result;
	}
	//function to  get all programs according to years
	public function getAssociateProgramGroups(){
		$result =  $this->conn->query("select * from program_group pg group by program_year_id");
		return $result;
	}
	//function to  get all programs according to years
	public function getProgramYearName($year_id){
		$result =  $this->conn->query("select name,start_year,end_year from program_years where id='".$year_id."'");
		$row = $result->fetch_assoc();
		return $row['name'].' '.$row['start_year'].' '.$row['end_year'];
	}
    // function to delete programs from program year table
    //as well as associated to other tables
    public function deleteProgFromYear($py_id){
		 $sql = "DELETE FROM program_years WHERE id='".$py_id."'";
		 $rel = $this->conn->query($sql);
		 if($rel->affected_rows > 0){
			 $sql = "DELETE FROM cycle WHERE program_year_id='".$py_id."'";
			 $this->conn->query($sql);
		 }
    }
    // function to delete all cycles from cycle table
    //as well as associated to other tables
    public function deleteAssociateCycles($c_id){
		 $sql = "DELETE FROM cycle WHERE id='".$c_id."'";
		 $rel = $this->conn->query($sql);
		 if($rel->affected_rows > 0){
             //delete other associated cycles from other tables here
			 //$sql = "DELETE FROM cycle WHERE program_year_id='".$c_id."'";
			 //$this->conn->query($sql);
		 }
    }
    //function tto add program cycles
    public function addEditCycles()
    {
        $edit_id = base64_decode($_POST['programId']);
        $slctProgram_id = $_POST['slctProgram'];
        $slctNumcycle = $_POST['slctNumcycle'];
        $preNumCycle = ($_POST['preNumCycle'] > 0) ? $_POST['preNumCycle'] : 0;

        if($edit_id==$slctProgram_id)
        {
			if($slctNumcycle==$preNumCycle){
				for($i=1; $i<=$slctNumcycle; $i++){
				   $cycle_edit_id = $_POST['preCycleId'.$i];
				   $days = implode(',',$_POST['slctDays'.$i]);
				   $timeslots = implode(',',$_POST['slctTimeslot'.$i]);
				   $start_date = date("Y-m-d", strtotime($_POST['startweek'.$i]));
				   $end_date = date("Y-m-d", strtotime($_POST['endweek'.$i]));
				   $sql = "update cycle set
								 no_of_cycle='".$slctNumcycle."',
								 start_week='".$start_date."',
								 end_week='".$end_date."',
								 days='".$days."',
								 timeslot_id='".$timeslots."',
								 date_update=now() WHERE id='".$cycle_edit_id."'";
				   //echo '<br>'.$sql;
				   $rel = $this->conn->query($sql);
				   //add program exception
				   $this->addProgramException($slctProgram_id,$i);
				}
			  }else if($slctNumcycle < $preNumCycle){
				for($j=($slctNumcycle+1); $j<=$preNumCycle; $j++){
					 $cycle_edit_id = $_POST['preCycleId'.$j];
					 // delete all cycle which are not need
					 $py_rel =  $this->conn->query("SELECT id FROM cycle WHERE id='".$cycle_edit_id."'");
					 $py_row_cnt = $py_rel->num_rows;
					 if($py_row_cnt > 0){
					      $row = $py_rel->fetch_assoc();
						  $this->deleteAssociateCycles($row['id']);
					 }
					//delete program exception as well
					$query="delete from program_cycle_exception where program_year_id='".$slctProgram_id."' AND cycle_id='".$j."'";
					$qry = $this->conn->query($query);
				}

			  }else if($slctNumcycle > $preNumCycle){
				 for($i=$preNumCycle+1; $i<=$slctNumcycle; $i++){
					$days = implode(',',$_POST['slctDays'.$i]);
					$timeslots = implode(',',$_POST['slctTimeslot'.$i]);
					$start_date = date("Y-m-d", strtotime($_POST['startweek'.$i]));
					$end_date = date("Y-m-d", strtotime($_POST['endweek'.$i]));
					$sql = "INSERT INTO cycle (program_year_id, no_of_cycle, start_week, end_week, days, timeslot_id, date_add) VALUES ('".$slctProgram_id."', '".$slctNumcycle."', '".$start_date."', '".$end_date."', '".$days."','".$timeslots."', now())";
					$rel = $this->conn->query($sql);

				   //add program exception
				   $this->addProgramException($slctProgram_id,$i);

				 }
			  }
			  //finally set all the similar program with current selected number of cycles
			  $sql = "update cycle set no_of_cycle='".$slctNumcycle."' WHERE program_year_id='".$slctProgram_id."'";
			  $rel = $this->conn->query($sql);

			$message="Record has been saved successfully";
			$_SESSION['succ_msg'] = $message;
			return 0;

		}else{
			$message="Record could not be saved. Please Try again.";
			$_SESSION['error_msg'] = $message;
			return 1;
		}
    }

    //function to add row of the program exception
    public function getProgExceptions($py_id,$cycle_num)
    {
		$x=0;
		$html='';
		$query="select * from program_cycle_exception where program_year_id='".$py_id."' AND cycle_id='".$cycle_num."'";
		$result= $this->conn->query($query);
		while($data = $result->fetch_assoc()){
			$x++;
			if($x==1){
				$html .='<div class="exceptionList'.$cycle_num.'">
					<table id="datatables'.$cycle_num.'" class="exceptionTbl">
					  <thead>
					   <tr>
						<th>Sr. No.</th>
						<th>Exception Date</th>
						<th>Remove</th>
					   </tr>
					  </thead>
					  <tbody>';
			 }
			$html .='<tr>
					<td>'.$x.'</td>
					<td>'.$data['exception_date'].'</td>
					<td style="display:none"><input type="hidden" name="exceptionDate'.$cycle_num.'[]" id="exceptnDate'.$x.'" value="'.$data['exception_date'].'" />
					<input type="hidden" name="program_cycleRowId'.$cycle_num.'[]" id="program_cycleRowId'.$x.'"  value="'.$data['id'].'"/></td>
					<td id="'.$data['id'].'"><a class="remove_field" onclick="deleteExcepProgCycle('.$data['id'].', 0);">Remove</a></td></tr>';
		}
		$html .='<input type="hidden" name="maxSessionListVal'.$cycle_num.'" id="maxSessionListVal'.$cycle_num.'"  value="'.$x.'"/>';
		$html .='</tbody></table></div>';
		echo $html;
    }

    //function to add program exception
    public function addProgramException($py_id,$cycle_no)
    {
		//delete old exceptions
		$query="delete from program_cycle_exception where program_year_id='".$py_id."' AND cycle_id='".$cycle_no."'";
		$qry = $this->conn->query($query);
		//add new exceptions
		foreach($_POST['exceptionDate'.$cycle_no] as $exceptionDate){
		    $exceptionDate = date("Y-m-d",strtotime($exceptionDate));
			$currentDateTime = date("Y-m-d H:i:s");
			$result =$this->conn->query("INSERT INTO program_cycle_exception(program_year_id,cycle_id,exception_date,date_add,date_update) VALUES ('".$py_id."','".$cycle_no."', '".$exceptionDate."', '".$currentDateTime."', '".$currentDateTime."');");
		}
    }
}
