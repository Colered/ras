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
		$sql = "INSERT INTO program (program_name,unit,company, program_type, date_add) VALUES ('".$txtPrgmName."','".$slctUnit."','".$txtCompanyName."', '".$slctPrgmType."', NOW())";
		$rel = $this->conn->query($sql);
		$last_ins_id = $this->conn->insert_id;
		if(!$rel){
			$_SESSION['error_msg'] = $this->conn->error;
			return 0;
		}else{
			//INSERT PROGRAM YEARS  DATA
			for($j=1; $j<=$slctPrgmType; $j++){
				$progName = $txtPrgmName.'-'.$j;
				$sql = "INSERT INTO program_years (program_id, name) VALUES ('".$last_ins_id."', '".$progName."')";
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
					$sql = "UPDATE program_years SET
				  						   name = '".$progName."'
				  						   WHERE id='".$row['id']."'";

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
					$sql = "INSERT INTO program_years (program_id, name) VALUES ('".$edit_id."', '".$progName."')";
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
	//function to  a program by year id
	public function getProgramByYearId($id){
		$result =  $this->conn->query("SELECT * FROM `program` INNER JOIN program_years on program_years.program_id = program.id WHERE program_years.id = '".$id."'");
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
	public function getCyclesInfo($prog_id)
	{
		$SQL = "select start_week, end_week, week1, week2, occurrence from cycle where program_year_id ='".$prog_id."'";
		$result = $this->conn->query($SQL);
		$row_cnt = $result->num_rows;
		$data = '';
		$numSufArr = array('0'=>'1st','1'=>'2nd','2'=>'3rd');
		$daysDBArr = array('0'=>'Mon','1'=>'Tue','2'=>'Wed','3'=>'Thu','4'=>'Fri','5'=>'Sat','6'=>'Sun');
		if($row_cnt > 0){
		$data .= '<table cellspacing="0" cellpadding="0" style="border:none;">';
		$data .= '<tr><td>Number of Cycles:'.$this->getCyclesInProgram($prog_id).'</td></tr>';
		$i=0;
		//get the timeslot from TS ids
		$tsobj = new Timeslot();
		while($row = $result->fetch_assoc())
		{
			$week1 = '';
			$week2 = '';
			if(count(unserialize($row['week1']))>0){
				foreach(unserialize($row['week1']) as $key=> $value)
				{
					$timeslotVal = $tsobj->getTSbyIDs('('.implode(',',$value).')');
					$week1 = $week1." ".'<span style="text-decoration: underline;">'.$daysDBArr[$key].'</span>'.":&nbsp;".implode(',',$timeslotVal)."<br/>";
				}
			}
			if(count(unserialize($row['week2']))>0)
			{
				if($row['occurrence'] == '2w'){
					foreach(unserialize($row['week2']) as $key=> $value)
					{
						$tsobj = new Timeslot();
						$timeslotVal = $tsobj->getTSbyIDs('('.implode(',',$value).')');
						$week2 = $week2." ".'<span style="text-decoration: underline;">'.$daysDBArr[$key].'</span>'.":&nbsp;".implode(',',$timeslotVal)."<br/>";
					}
				}
			}
			$cycle = $numSufArr[$i];
			$start_date = $this->formatDateByDate($row['start_week']);
			$end_date = $this->formatDateByDate($row['end_week']);
			$data .= '<tr><td style="font-size: 13px;"><strong>'.$cycle.' cycle : '.$start_date.' - '.$end_date.'</strong> </td></tr>';
			$data .= '<tr><td> <b>Week1</b><br/> '.$week1.'</td></tr>';
			if($row['occurrence'] == '2w'){
			$data .= '<tr><td> <b>Week2</b><br/> '.$week2.' </td></tr>';
			}
			$i++;
			$data .= $this->getProgCycExceptions($prog_id,$i);
			$data .= $this->getProgCycAdditionalDayTS($prog_id,$i);
		}
		$data .= '</table>';
		}
		return $data;
	}
    //function to get program cycle Additional Days
    public function getProgCycAdditionalDayTS($py_id,$cycle_num)
    {
        $query="select * from program_cycle_additional_day_time where program_year_id='".$py_id."' AND cycle_id='".$cycle_num."'";
		$result= $this->conn->query($query);
	  	$num_rows = $result->num_rows;
		$tsobj = new Timeslot();
		
	  	$dt = '';
	  	$i=0;
	  	if($num_rows > 0){
			$dt .= '<tr><td><div style="float:left;"><strong>Additional Days And Timeslots:</strong></div><br/>';
			while($row = $result->fetch_assoc()){
			   $timeslotVal = $tsobj->getTSbyIDs('('.$row['actual_timeslot_id'].')');
			   $i++;
               $dt .= '<div><span style="text-decoration: underline;">'.date('d-m-Y',strtotime($row['additional_date'])).'</span>: '.implode(',',$timeslotVal).'</div>';
               if(!($i%4))
               $dt .= '<div style="width:90px;float:left;">&nbsp;</div>';

			}
			$dt .= '</td></tr>';
			return $dt;
		}
    }
	//function to get program cycle exceptions
    public function getProgCycExceptions($py_id,$cycle_num)
    {
        $query = "select exception_date from program_cycle_exception where program_year_id='".$py_id."' AND cycle_id='".$cycle_num."'";
	  	$result= $this->conn->query($query);
	  	$num_rows = $result->num_rows;
	  	$dt = '';
	  	$i=0;
	  	if($num_rows > 0){
	  	    $dt .= '<tr><td><div style="width:90px;float:left;">Exceptions:</div>';
			while($row = $result->fetch_assoc()){
			   $i++;
               $dt .= '<div style="width:90px;float:left;">'.$row['exception_date'].'</div>';
               if(!($i%4))
               $dt .= '<div style="width:90px;float:left;">&nbsp;</div>';

			}
			$dt .= '</td></tr>';
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
		//return $row['name'].' '.$row['start_year'].' '.$row['end_year'];
		return $row['name'];
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
			//echo $slctNumcycle;print"<pre>";print_r($_POST);print"</pre>";die("1");
			if($slctNumcycle==$preNumCycle){//echo $slctNumcycle;print"<pre>";print_r($_POST);print"</pre>";die("1");
				for($i=1; $i<=$slctNumcycle; $i++){
				   $cycle_edit_id = $_POST['preCycleId'.$i];
				   $start_date = date("Y-m-d", strtotime($_POST['startweek'.$i]));
				   $end_date = date("Y-m-d", strtotime($_POST['endweek'.$i]));
				   $chweek = $_POST['c1chWeek'.$i];
					 if($chweek == '1w')
					 {
						$sql = "update cycle set
								 no_of_cycle='".$slctNumcycle."',
								 start_week='".$start_date."',
								 end_week='".$end_date."',
								 occurrence = '".$chweek."',
								 week1='".serialize($_POST['cycle'.$i]['week1'])."',
								 week2='',
								 date_update=now() WHERE id='".$cycle_edit_id."'";
						$rel = $this->conn->query($sql);
					   //add program exception
					   $this->addProgramException($slctProgram_id,$i);
					    $this->addProgramAddition($slctProgram_id,$i);
					 }else{
						 $sql = "update cycle set
								 no_of_cycle='".$slctNumcycle."',
								 start_week='".$start_date."',
								 end_week='".$end_date."',
								 occurrence = '".$chweek."',
								 week1='".serialize($_POST['cycle'.$i]['week1'])."',
								 week2='".serialize($_POST['cycle'.$i]['week2'])."',
								 date_update=now() WHERE id='".$cycle_edit_id."'";
						$rel = $this->conn->query($sql);
					   //add program exception
					   $this->addProgramException($slctProgram_id,$i);
					   $this->addProgramAddition($slctProgram_id,$i);
					 }

				}
			  }else if($slctNumcycle < $preNumCycle){//echo $slctNumcycle;echo "--"; echo $preNumCycle;die("2");
				for($j=1; $j<=$preNumCycle; $j++){
					if($j <= $slctNumcycle)
					{
					   $cycle_edit_id = $_POST['preCycleId'.$j];
					   $start_date = date("Y-m-d", strtotime($_POST['startweek'.$j]));
					   $end_date = date("Y-m-d", strtotime($_POST['endweek'.$j]));
					   $chweek = $_POST['c1chWeek'.$j];
					   if($chweek == '1w')
					   {
							$sql = "update cycle set
									 no_of_cycle='".$slctNumcycle."',
									 start_week='".$start_date."',
									 end_week='".$end_date."',
									 occurrence = '".$chweek."',
									 week1='".serialize($_POST['cycle'.$j]['week1'])."',
									 week2='',
									 date_update=now() WHERE id='".$cycle_edit_id."'";
							$rel = $this->conn->query($sql);
						   //add program exception
						   $this->addProgramException($slctProgram_id,$j);
						   $this->addProgramAddition($slctProgram_id,$j);
						 }else{
							 $sql = "update cycle set
									 no_of_cycle='".$slctNumcycle."',
									 start_week='".$start_date."',
									 end_week='".$end_date."',
									 occurrence = '".$chweek."',
									 week1='".serialize($_POST['cycle'.$j]['week1'])."',
									 week2='".serialize($_POST['cycle'.$j]['week2'])."',
									 date_update=now() WHERE id='".$cycle_edit_id."'";
							$rel = $this->conn->query($sql);
						   //add program exception
						   $this->addProgramException($slctProgram_id,$j);
						   $this->addProgramAddition($slctProgram_id,$j);
						 }
					}else{
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
				}

			  }else if($slctNumcycle > $preNumCycle){//echo $slctNumcycle;echo "--"; echo $preNumCycle;die("3");
				 // print"<pre>";print_r($_POST);
				 for($i=1; $i<=$slctNumcycle; $i++){
					 if($i<=$preNumCycle)
					 {
						   $cycle_edit_id = $_POST['preCycleId'.$i];
						   $start_date = date("Y-m-d", strtotime($_POST['startweek'.$i]));
						   $end_date = date("Y-m-d", strtotime($_POST['endweek'.$i]));
						   $chweek = $_POST['c1chWeek'.$i];
						   if($chweek == '1w')
						   {
								$sql = "update cycle set
										 no_of_cycle='".$slctNumcycle."',
										 start_week='".$start_date."',
										 end_week='".$end_date."',
										 occurrence = '".$chweek."',
										 week1='".serialize($_POST['cycle'.$i]['week1'])."',
										 week2='',
										 date_update=now() WHERE id='".$cycle_edit_id."'";
								$rel = $this->conn->query($sql);
							   //add program exception
							   $this->addProgramException($slctProgram_id,$i);
							   $this->addProgramAddition($slctProgram_id,$i);
							 }else{
								 $sql = "update cycle set
										 no_of_cycle='".$slctNumcycle."',
										 start_week='".$start_date."',
										 end_week='".$end_date."',
										 occurrence = '".$chweek."',
										 week1='".serialize($_POST['cycle'.$i]['week1'])."',
										 week2='".serialize($_POST['cycle'.$i]['week2'])."',
										 date_update=now() WHERE id='".$cycle_edit_id."'";
								$rel = $this->conn->query($sql);
							   //add program exception
							   $this->addProgramException($slctProgram_id,$i);
							   $this->addProgramAddition($slctProgram_id,$i);
							 }
					 }else{
						$start_date = date("Y-m-d", strtotime($_POST['startweek'.$i]));
						$end_date = date("Y-m-d", strtotime($_POST['endweek'.$i]));
						$chweek = $_POST['c1chWeek'.$i];
						if($chweek == '1w')
						 {
							$sql = "INSERT INTO cycle (program_year_id, start_week, end_week, occurrence, week1, week2, date_add, date_update) VALUES ('".$slctProgram_id."', '".$start_date."', '".$end_date."', '".$chweek."', '".serialize($_POST['cycle'.$i]['week1'])."','', now(), now())";
							//echo $sql;echo "<br/>";
							$rel = $this->conn->query($sql);
						 }else{
								$sql = "INSERT INTO cycle (program_year_id, start_week, end_week, occurrence, week1, week2, date_add, date_update) VALUES ('".$slctProgram_id."', '".$start_date."', '".$end_date."', '".$chweek."', '".serialize($_POST['cycle'.$i]['week1'])."','".serialize($_POST['cycle'.$i]['week2'])."', now(), now())";
								//echo $sql;echo "<br/>";
								$rel = $this->conn->query($sql);
						 }
						 //add program exception
						 $this->addProgramException($slctProgram_id,$i);
						 $this->addProgramAddition($slctProgram_id,$i);
					 }

				 }//die;
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
					<td>'.date('d-m-Y',strtotime($data['exception_date'])).'</td>
					<td style="display:none"><input type="hidden" name="exceptionDate'.$cycle_num.'[]" id="exceptnDate'.$x.'" value="'.$data['exception_date'].'" />
					<input type="hidden" name="program_cycleRowId'.$cycle_num.'[]" id="program_cycleRowId'.$x.'"  value="'.$data['id'].'"/></td>
					<td id="'.$data['id'].'"><a class="remove_field" onclick="deleteExcepProgCycle('.$data['id'].', 0);">Remove</a></td></tr>';
		}
		$html .='<input type="hidden" name="maxSessionListVal'.$cycle_num.'" id="maxSessionListVal'.$cycle_num.'"  value="'.$x.'"/>';
		$html .='</tbody></table></div>';
		echo $html;
    }
	//function to add row of the program additional date
    public function getProgAddition($py_id,$cycle_num)
    {
		$x=0;
		$html='';
		$query="select * from program_cycle_additional_day_time where program_year_id='".$py_id."' AND cycle_id='".$cycle_num."'";
		$result= $this->conn->query($query);
		while($data = $result->fetch_assoc()){
			$x++;
			if($x==1){
				$html .='<div class="additionList'.$cycle_num.'">
					<table id="dataaddtables'.$cycle_num.'" class="additionTbl">
					  <thead>
					   <tr>
						<th>Sr. No.</th>
						<th>Additional Date</th>
						<th>Timeslots</th>
						<th>Remove</th>
					   </tr>
					  </thead>
					  <tbody>';
			 }
			$html .='<tr>
					<td>'.$x.'</td>
					<td>'.date('d-m-Y',strtotime($data['additional_date'])).'</td>
					<td style="display:none"><input type="hidden" name="additionDate'.$cycle_num.'[]" id="additionDate'.$x.'" value="'.$data['additional_date'].'" />
					<input type="hidden" name="program_cycleRowId'.$cycle_num.'[]" id="program_cycleRowId'.$x.'"  value="'.$data['id'].'"/></td>
					<td>'.$data['timeslot_id'].'</td>
					<td style="display:none"><input type="hidden" name="time_slot'.$cycle_num.'[]" id="time_slot'.$x.'" value="'.$data['timeslot_id'].'" />
					<input type="hidden" name="actual_time_slot'.$cycle_num.'[]" id="actual_time_slot'.$x.'" value="'.$data['actual_timeslot_id'].'" /></td>
					<td id="'.$data['id'].'"><a class="remove_field" onclick="deleteAddProgCycle('.$data['id'].', 0);">Remove</a></td></tr>';
		}
		$html .='<input type="hidden" name="maxSessListVal'.$cycle_num.'" id="maxSessListVal'.$cycle_num.'"  value="'.$x.'"/>';
		$html .='</tbody></table></div>';
		echo $html;
    }

    //function to add program exception
    public function addProgramException($py_id,$cycle_no)
    {
		//delete old exceptions
		$query="delete from program_cycle_exception where program_year_id='".$py_id."' AND cycle_id='".$cycle_no."'";
		$qry = $this->conn->query($query);
		//print"<pre>";print_r($_POST['exceptionDate'.$cycle_no]);
		//add new exceptions
		foreach($_POST['exceptionDate'.$cycle_no] as $exceptionDate){
		    $exceptionDate = date("Y-m-d",strtotime($exceptionDate));
			$currentDateTime = date("Y-m-d H:i:s");
			$result =$this->conn->query("INSERT INTO program_cycle_exception(program_year_id,cycle_id,exception_date,date_add,date_update) VALUES ('".$py_id."','".$cycle_no."', '".$exceptionDate."', '".$currentDateTime."', '".$currentDateTime."');");			
		}
    }
	//function to add program additional dates
    public function addProgramAddition($py_id,$cycle_no)
    {
		//delete old exceptions
		$query="delete from program_cycle_additional_day_time where program_year_id='".$py_id."' AND cycle_id='".$cycle_no."'";
		$qry = $this->conn->query($query);
		//add new exceptions
		for($k=0; $k<count($_POST['additionDate'.$cycle_no]); $k++){
		    //$additionDate = date("Y-m-d",strtotime($additionDate));
			$additionDate = date("Y-m-d",strtotime($_POST['additionDate'.$cycle_no][$k]));
			$timeslot_id = $_POST['time_slot'.$cycle_no][$k];
			$actual_timeslot_id = $_POST['actual_time_slot'.$cycle_no][$k];
			$currentDateTime = date("Y-m-d H:i:s");
			$result =$this->conn->query("INSERT INTO program_cycle_additional_day_time(program_year_id,cycle_id,additional_date,timeslot_id,actual_timeslot_id,date_add,date_update) VALUES ('".$py_id."','".$cycle_no."', '".$additionDate."', '".$timeslot_id."','".$actual_timeslot_id."','".$currentDateTime."', '".$currentDateTime."');");
		}
    }
    //function to get program activity cycle number
    public function getProgramCycleDuration($py_id,$act_cycle_id)
    {
		$result =  $this->conn->query("SELECT id FROM cycle WHERE program_year_id='".$py_id."'");
		$row_cnt = $result->num_rows;
		if($row_cnt){
		    $i=0;
			while($rr = $result->fetch_assoc()){
			    $i++;
				if($rr['id']==$act_cycle_id){
				  return $i;
				}
			}
		}else{
		   return '';
		}
	}
	public function getWebProgramsDetail($program_year_id='')
	{
	$row=$rowmainArr=$newArr=array();
	$result =  $this->conn->query("SELECT we.cal_name, we.cal_description, we.cal_date, we.cal_time, we.cal_id, we.cal_ext_for_id, we.cal_priority, we.cal_access, we.cal_duration, weu.cal_status, we.cal_create_by, weu.cal_login, we.cal_type, we.cal_location, we.cal_url, we.cal_due_date, we.cal_due_time, weu.cal_percent, we.cal_mod_date, we.cal_mod_time FROM webcal_entry we,webcal_entry_user weu WHERE we.cal_id = weu.cal_id and we.program_year_id='".$program_year_id."' ORDER BY we.cal_time, we.cal_name ");
		if($result->num_rows){
			while ($rows =$result->fetch_assoc()){
					$row[]=$rows;
			}
		}
		if(count($row)>0){
		   $rowNewArr=array(array());
		   for($i=0;$i<count($row);$i++){
		    $j=0;
		    foreach($row[$i] as $key=>$val){
			  $rowNewArr[$i][$j]=$val;
			  $j++;
		   	}
		  }
		  return $rowNewArr;
		}
	}
	//function to create week and timeslot
	public function createWeekTimeSlot($cId,$w){

	   $objTS = new Timeslot();
	   //get the list of all available timeslots
	   $timeslotData = $objTS->viewTimeslot();
	   $options = "";
	   while($data = $timeslotData->fetch_assoc()){
	   	$options .= '<option value="'.$data['id'].'">'.$data['timeslot_range'].'</option>';
	  }

	  	echo '<div class="tmSlot">
			  <input type="checkbox" id="'.$cId.'Mon'.$w.'" name="'.$cId.'day'.$w.'[]" value="'.$cId.'Mon'.$w.'" class="days"/><span class="dayName"> Mon </span>
			<select id="'.$cId.'ts-avail-mon'.$w.'" name="'.$cId.'Mon'.$w.'[]" class="slctTs" multiple="multiple">
				'.$options.'
			 </select>
			</div>
			<div class="tmSlot">
			  <input type="checkbox" id="'.$cId.'Tue'.$w.'" name="'.$cId.'day'.$w.'[]" value="'.$cId.'Tue'.$w.'" class="days"/><span class="dayName"> Tue </span>
			<select id="'.$cId.'ts-avail-tue'.$w.'" name="'.$cId.'Tue'.$w.'[]" class="slctTs" multiple="multiple">
				 '.$options.'
			  </select>
			</div>
			<div class="tmSlot">
			  <input type="checkbox" id="'.$cId.'Wed'.$w.'" name="'.$cId.'day'.$w.'[]"  value="'.$cId.'Wed'.$w.'" class="days"/><span class="dayName"> Wed </span>
			 <select id="'.$cId.'ts-avail-wed'.$w.'" name="'.$cId.'Wed'.$w.'[]" class="slctTs" multiple="multiple">
				 '.$options.'
			  </select>
			</div>
			<div class="tmSlot">
			  <input type="checkbox" id="'.$cId.'Thu'.$w.'" name="'.$cId.'day'.$w.'[]"  value="'.$cId.'Thu'.$w.'" class="days"/><span class="dayName"> Thu </span>
			 <select id="'.$cId.'ts-avail-thu'.$w.'" name="'.$cId.'Thu'.$w.'[]" class="slctTs" multiple="multiple">
				 '.$options.'
			  </select>
			</div>
			<div class="tmSlot">
			  <input type="checkbox" id="'.$cId.'Fri'.$w.'" name="'.$cId.'day'.$w.'[]"  value="'.$cId.'Fri'.$w.'" class="days"/><span class="dayName"> Fri </span>
			 <select id="'.$cId.'ts-avail-fri'.$w.'" name="'.$cId.'Fri'.$w.'[]" class="slctTs" multiple="multiple">
				  '.$options.'
			  </select>
			</div>
			<div class="tmSlot">
			  <input type="checkbox" id="'.$cId.'Sat'.$w.'" name="'.$cId.'day'.$w.'[]"  value="'.$cId.'Sat'.$w.'" class="days"/><span class="dayName"> Sat </span>
			 <select id="'.$cId.'ts-avail-sat'.$w.'" name="'.$cId.'Sat'.$w.'[]" class="slctTs" multiple="multiple">
				'.$options.'
			  </select>
			</div>';
	}
	public function getTimeslotOptions($params = array())
	{
	  	//echo $params;
	   $objTS = new Timeslot();
	   $timeslotData = $objTS->viewTimeslot();
	   $options = "";
	   while($data = $timeslotData->fetch_assoc()){
	   		if(in_array($data['id'], $params))
		   {
			   $options .= '<option value="'.$data['id'].'" selected="selected">'.$data['start_time'].'-'.$data['end_time'].'</option>';
		   }else{
			   $options .= '<option value="'.$data['id'].'">'.$data['start_time'].'-'.$data['end_time'].'</option>';
		   }
		}
		return $options;
	}
	//function to  get all programs according to years
	public function getProgramWithCycle(){
		//echo "select py.*, py.id as progid, cy.* from cycle as cy LEFT JOIN program_years as py ON cy.program_year_id = py.id GROUP BY cy.program_year_id"; die;
		$result =  $this->conn->query("select py.*, py.id as progid, cy.* from cycle as cy LEFT JOIN program_years as py ON cy.program_year_id = py.id GROUP BY cy.program_year_id");
		return $result;
	}
	public function getUnit(){
		$result =  $this->conn->query("select * from unit");
		return $result;
	}
	//Getting the cycle ids into the option dropdown menu in cycle filetration
	public function getCycle(){
		 $row_program_ids=$array1=$array2=$array3=array();
		 $result=$this->conn->query("select DISTINCT program_year_id FROM  cycle");
		 $i=1;
		 while($data=$result->fetch_assoc()){
		 	$sql="SELECT * FROM cycle WHERE program_year_id ='".$data['program_year_id']."' GROUP BY id HAVING COUNT( * ) >=1 ORDER BY id ASC ";
			$cycle_ids=$this->conn->query($sql);
			$group="$"."group".$i;
			$group=array();
			while($data1=$cycle_ids->fetch_assoc()){
			   $group[]=$data1['id'];
			}
			$i++;
			$array1[]=(isset($group['0'])) ? ($group['0']) : '';
			$array2[]=(isset($group['1'])) ? ($group['1']) : '';
			$array3[]=(isset($group['2'])) ? ($group['2']) : '';
		 }
		 $strArray1=implode(",",$array1);
		 $strArray2=implode(",",$array2);
		 $strArray3=implode(",",$array3);
		 return array($strArray1,$strArray2,$strArray3);
	}
	//This function use for program availability to show value in the calander menu
	public function getCyclesInfoforAvailability($prog_id=''){
		$SQL = "select start_week, end_week, week1, week2, occurrence from cycle where program_year_id ='".$prog_id."'";
		$result = $this->conn->query($SQL);
		$row_cnt = $result->num_rows;
		$mk_event_arr = $mk_event_new_arr = array();
		$mk_event_arr['cycle_num']=$mk_event_arr['particular_date']= $mk_event_arr['day']=$mk_event_arr['timeslot']=$mk_event_arr['blank']='';
		$numSufArr = array('0'=>'1st cycle','1'=>'2nd cycle','2'=>'3rd cycle');
		$z=0;
		$last_day = 5;
		$tsobj = new Timeslot();
		$ttobj=new Timetable();
		if($row_cnt > 0)
		{
			while($row = $result->fetch_assoc())
			{
				//print"<pre>";print_r($row);die;
				$end_week=$row['end_week'];
				if($row['occurrence'] == '1w')
				{	
					$week1 = unserialize($row['week1']);
					foreach($week1 as $key=> $value)
					{
						$day = $key + 1;
						$dateArr = $ttobj->getDateForSpecificDayBetweenDates($row['start_week'],$end_week,$day,'',$prog_id);
						$timeslotVal = $tsobj->getTSbyIDsForProgramAvailbility('('.implode(',',$value).')');
						for($j=0;$j<count($dateArr);$j++){
							$mk_event_arr['blank']='';
							$mk_event_arr['timeslot']=$timeslotVal;
							$mk_event_arr['actual_timeslot_id']=implode(',',$value);
							$mk_event_arr['day']=$key;
							$mk_event_arr['particular_date']=$dateArr[$j];
							$mk_event_arr['cycle_num']=$numSufArr[$z];
							$mk_event_new_arr[]= $mk_event_arr;
						}
					}											
				}else if($row['occurrence'] == '2w'){
				    $weeks = $ttobj->countWeeksBetweenDates($row['start_week'],$end_week);
					$start_week = $row['start_week'];
					for($i=0; $i < $weeks; $i++)
					{
						if($i%2 == 0)
						{
						    $day = date("w", strtotime($start_week));
							$day = $day-1;
							$rem_days = $last_day-$day;
							$date = new DateTime($start_week);
							$date->modify('+'.$rem_days.' day');
							$end_week = $date->format('Y-m-d');
							if($end_week > $row['end_week']){
						 		$end_week=$row['end_week'];
							}
							$week1 = unserialize($row['week1']);
							foreach($week1 as $key=> $value)
							{
								$day = $key + 1;
								$dateArr = $ttobj->getDateForSpecificDayBetweenDates($start_week,$end_week,$day,'',$prog_id);
								$timeslotVal = $tsobj->getTSbyIDsForProgramAvailbility('('.implode(',',$value).')');
								for($j=0;$j<count($dateArr);$j++){
									$mk_event_arr['blank']='';
									$mk_event_arr['timeslot']=$timeslotVal;
									$mk_event_arr['actual_timeslot_id']=implode(',',$value);
									$mk_event_arr['day']=$key;
									$mk_event_arr['particular_date']=$dateArr[$j];
									$mk_event_arr['cycle_num']=$numSufArr[$z];
									$mk_event_new_arr[]= $mk_event_arr;
								}
							}
							$date = new DateTime($end_week);
							$date->modify('+2 day');
							$start_week = $date->format('Y-m-d');
						}else{	
							$day = date("w", strtotime($start_week));
							$day = $day-1;
							$rem_days = $last_day-$day;
							$date = new DateTime($start_week);
							$date->modify('+'.$rem_days.' day');
							$end_week = $date->format('Y-m-d');	
							if($end_week > $row['end_week']){
						 		$end_week=$row['end_week'];
							}
							if(count(unserialize($row['week2'])) > 0)
							{
								$week2 = unserialize($row['week2']);
								foreach($week2 as $key=> $value)
								{
									$day = $key + 1;
									$dateArr = $ttobj->getDateForSpecificDayBetweenDates($start_week,$end_week,$day,'',$prog_id);
									$timeslotVal = $tsobj->getTSbyIDsForProgramAvailbility('('.implode(',',$value).')');
									for($j=0;$j<count($dateArr);$j++){
									$mk_event_arr['blank']='';
									$mk_event_arr['timeslot']=$timeslotVal;
									$mk_event_arr['actual_timeslot_id']=implode(',',$value);
									$mk_event_arr['day']=$key;
									$mk_event_arr['particular_date']=$dateArr[$j];
									$mk_event_arr['cycle_num']=$numSufArr[$z];
									$mk_event_new_arr[]= $mk_event_arr;
								}
							  }
							}
							$date = new DateTime($end_week);
							$date->modify('+2 day');
							$start_week = $date->format('Y-m-d');
						}
					}								
				}
				foreach($mk_event_new_arr as $mk_events_dates)
				{
					$final_dates[$mk_events_dates['particular_date']]['particular_date'] = $mk_events_dates['particular_date'];
					$final_dates[$mk_events_dates['particular_date']]['blank'] = $mk_events_dates['blank'];
					$final_dates[$mk_events_dates['particular_date']]['timeslot'] = $mk_events_dates['timeslot'];
					$final_dates[$mk_events_dates['particular_date']]['day'] = $mk_events_dates['day'];
					$final_dates[$mk_events_dates['particular_date']]['actual_timeslot_id'] = $mk_events_dates['actual_timeslot_id'];
					$final_dates[$mk_events_dates['particular_date']]['cycle_num'] = $mk_events_dates['cycle_num'];											
				}
				$sql_pgm_add_date = $this->conn->query("select DATE_FORMAT(additional_date,'%Y%m%d') as additional_date,actual_timeslot_id,timeslot_id,cycle_id from program_cycle_additional_day_time where additional_date >= '".$row['start_week']."' and additional_date <= '".$row['end_week']."' and program_year_id = '".$prog_id."'");
				while($result_pgm_add_date = mysqli_fetch_array($sql_pgm_add_date))
				{
					if(array_key_exists($result_pgm_add_date['additional_date'],$final_dates))
					{
						$time = explode(",",$final_dates[$result_pgm_add_date['additional_date']]['actual_timeslot_id']);
						$time1 = explode(",",$result_pgm_add_date['actual_timeslot_id']);
						$total_time = array_unique(array_merge($time,$time1));
						$sorted_array = array();
						foreach($total_time as $new_key => $arr1)
						{
							$sorted_array[$new_key] = $arr1;							
						}
						array_multisort($sorted_array, SORT_ASC, $total_time);
						$total_time_val = $tsobj->getTSbyIDsForProgramAvailbility('('.implode(',',$total_time).')');
						$final_dates[$result_pgm_add_date['additional_date']]['timeslot'] = $total_time_val;
						$final_dates[$result_pgm_add_date['additional_date']]['actual_timeslot_id'] = implode(',',$total_time);
					}else{
						$day = date("w", strtotime($result_pgm_add_date['additional_date']));
						$day = $day-1;
						$final_dates[$result_pgm_add_date['additional_date']]['particular_date'] = $result_pgm_add_date['additional_date'];
						$final_dates[$result_pgm_add_date['additional_date']]['blank'] = '';
						$final_dates[$result_pgm_add_date['additional_date']]['timeslot'] = $result_pgm_add_date['timeslot_id'];
						$final_dates[$result_pgm_add_date['additional_date']]['day'] = $day;
						$final_dates[$result_pgm_add_date['additional_date']]['actual_timeslot_id'] = $result_pgm_add_date['actual_timeslot_id'];
						$final_dates[$result_pgm_add_date['additional_date']]['cycle_num'] = $numSufArr[$result_pgm_add_date['cycle_id'] - 1];
					}						
				}
				$j=0;
				foreach($final_dates as $final_pgms)
				{
					$mk_event_new_arr[$j]['blank'] = $final_pgms['blank'];
					$mk_event_new_arr[$j]['timeslot'] = $final_pgms['timeslot'];					
					$mk_event_new_arr[$j]['day'] = $final_pgms['day'];
					$mk_event_new_arr[$j]['particular_date'] = $final_pgms['particular_date'];
					$mk_event_new_arr[$j]['cycle_num'] = $final_pgms['cycle_num'];
					$mk_event_new_arr[$j]['actual_timeslot_id'] = $final_pgms['actual_timeslot_id'];					
					$j++;
				}	
				$z++;
			}					
		}	
	  return $mk_event_new_arr;
	}
	public function getProgramAvailExceptionById($program_id='')
	{
	    $excep_query="select exception_date from program_cycle_exception where program_year_id='".$program_id."'";
		$q_excep = mysqli_query($this->conn, $excep_query);
		return $q_excep;
	
	}
	public function getProgramDataByPrgmYrID($id) {
			$prgm_query="select * from program_years where id='".$id."' limit 1";
			$q_res = mysqli_query($this->conn, $prgm_query);
			return $q_res;
	} 
	public function getProgramWithNoOfCycle() {
			$prgm_query="select pg.name, cl.id, cl.program_year_id, cl.no_of_cycle from program_years as pg LEFT JOIN cycle as cl ON pg.id = cl.program_year_id";
			$q_res = mysqli_query($this->conn, $prgm_query);
			return $q_res;
	}   
}

